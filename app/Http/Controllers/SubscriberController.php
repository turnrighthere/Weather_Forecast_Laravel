<?php

namespace App\Http\Controllers;

use App\Models\Subscriber;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;
use App\Mail\SubscriptionConfirmation;
use App\Mail\UnsubscriptionConfirmation;
use Illuminate\Support\Facades\Http;



class SubscriberController extends Controller
{
    public function index()
    {
        $subscribers = Subscriber::all();
        return view('subscribers.index', compact('subscribers'));
    }
    public function sendEmails()
    {
        $subscribers = Subscriber::all();
        $apiKey = env('WEATHER_API_KEY');

        foreach ($subscribers as $subscriber) {
            $response = Http::get("http://api.weatherapi.com/v1/current.json?key=$apiKey&q={$subscriber->city}&aqi=no");

            if ($response->successful()) {
                $weatherData = $response->json();
                $data = [
                    'city' => $subscriber->city,
                    'temp_c' => $weatherData['current']['temp_c'],
                    'condition' => $weatherData['current']['condition']['text'],
                    'humidity' => $weatherData['current']['humidity'],
                    'wind_kph' => $weatherData['current']['wind_kph'],
                    'icon' => $weatherData['current']['condition']['icon'],
                ];

                Mail::send('emails.weather', $data, function ($message) use ($subscriber) {
                    $message->to($subscriber->email)
                            ->subject('Your Daily Weather Update');
                });
            }
        }

        return redirect()->back()->with('success', 'Emails have been sent successfully.');
    }
    public function showSubscriptionForm()
    {
        return view('subscription');
    }
    public function subscribe(Request $request)
    {
        $request->validate([
            'email' => 'required|email|unique:subscribers,email',
            'city' => 'required|string',
        ]);

        $subscriber = new Subscriber();
        $subscriber->email = $request->email;
        $subscriber->city = $request->city;
        $subscriber->token = Str::random(60);
        $subscriber->save();

        // Send confirmation email
        Mail::to($subscriber->email)->send(new SubscriptionConfirmation($subscriber));

        return redirect()->back()->with('success', 'Please check your email to confirm your subscription.');
    }

    public function verifyEmail($token)
    {
        $subscriber = Subscriber::where('token', $token)->firstOrFail();
        $subscriber->email_verified_at = now();
        $subscriber->save();

        return redirect()->route('subscribe.form')->with('success', 'Your email has been verified.');
    }

    public function unsubscribe($token)
    {
        $subscriber = Subscriber::where('token', $token)->firstOrFail();
        $subscriber->delete();

        // Send unsubscription confirmation email
        Mail::to($subscriber->email)->send(new UnsubscriptionConfirmation($subscriber));

        return redirect()->route('subscribe.form')->with('success', 'You have been unsubscribed successfully.');
    }
}

