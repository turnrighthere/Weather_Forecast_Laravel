<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Mail;
use App\Models\Subscriber;

class WeatherController extends Controller
{
    public function index()
    {
        return view('welcome');
    }

    public function getWeather(Request $request)
    {
        $city = $request->input('city');
        $apiKey = env('WEATHER_API_KEY');
        $response = Http::get("http://api.weatherapi.com/v1/current.json?key=$apiKey&q=$city&aqi=no");


        // Loop to get weather forecast for the next 4 days
        for ($i = 0; $i < 4; $i++) {
            // Calculate the date for the next 'i' days
            $date = now()->addDays($i)->format('Y-m-d');
            $response_forecast = Http::get("http://api.weatherapi.com/v1/forecast.json?key=$apiKey&q=$city&dt=$date&aqi=no&alerts=no");

            if ($response_forecast->successful()) {
                $forecastData = $response_forecast->json();
                $weatherDataForecast[] = [
                    'date' => $date,
                    'day_name' => now()->addDays($i)->format('D'), // Get the day name
                    'temp_c' => $forecastData['forecast']['forecastday'][0]['day']['avgtemp_c'],
                    'condition' => $forecastData['forecast']['forecastday'][0]['day']['condition']['text'],
                    'icon' => $forecastData['forecast']['forecastday'][0]['day']['condition']['icon'],
                    'wind_kph' => $forecastData['forecast']['forecastday'][0]['day']['maxwind_kph'],
                    'humidity' => $forecastData['forecast']['forecastday'][0]['day']['avghumidity'],
                ];
            } else {
                return response()->json([
                    'error' => $response_forecast->status(),
                    'message' => 'Unable to fetch weather data'
                ], $response_forecast->status());
            }
        }


        if ($response->successful()) {
            $weatherData = $response->json();
            return view('weather', compact('weatherData','weatherDataForecast'));
        } else {
            $error = $response->status();
            $message = 'Unable to fetch weather data';
            return view('weather', compact('error', 'message'));
        }
    }

    public function subscribe(Request $request)
    {
        $request->validate([
            'email' => 'required|email|unique:subscribers,email',
            'city' => 'required|string'
        ]);

        Subscriber::create([
            'email' => $request->email,
            'city' => $request->city,
        ]);
        
        return redirect()->back()->with('success', 'You have successfully subscribed.');
    }
    
}
