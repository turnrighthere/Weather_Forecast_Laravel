<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Mail;
use App\Models\Subscriber;
use Illuminate\Support\Facades\Http;
use App\Mail\DailyWeatherEmail;

class SendDailyWeatherEmail extends Command
{
    protected $signature = 'send:daily-weather-email';
    protected $description = 'Send daily weather email to subscribers';

    public function __construct()
    {
        parent::__construct();
    }

    public function handle()
    {
        $subscribers = Subscriber::all();
        $apiKey = env('WEATHER_API_KEY');

        foreach ($subscribers as $subscriber) {
            $response = Http::get("http://api.weatherapi.com/v1/current.json?key=$apiKey&q={$subscriber->city}&aqi=no");

            if ($response->successful()) {
                $weatherData = $response->json();
                Mail::to($subscriber->email)->send(new DailyWeatherEmail($weatherData, $subscriber->city));
            }
        }

        $this->info('Daily weather emails have been sent successfully.');
    }
}
