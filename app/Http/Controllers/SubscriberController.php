<?php

namespace App\Http\Controllers;

use App\Models\Subscriber;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;


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

        foreach ($subscribers as $subscriber) {
            $data = [
                'email' => $subscriber->email,
                'city' => $subscriber->city,
            ];

            Mail::send('email-template', $data, function ($message) use ($subscriber) {
                $message->to($subscriber->email)
                        ->subject('Your Daily Weather Update');
            });
        }

        return redirect()->back()->with('success', 'Emails have been sent successfully.');
    }
}

