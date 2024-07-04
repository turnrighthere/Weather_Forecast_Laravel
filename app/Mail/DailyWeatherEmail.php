<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class DailyWeatherEmail extends Mailable
{
    use Queueable, SerializesModels;

    public $weatherData;
    public $city;

    public function __construct($weatherData, $city)
    {
        $this->weatherData = $weatherData;
        $this->city = $city;
    }

    public function build()
    {
        return $this->markdown('emails.weather')
                    ->with([
                        'city' => $this->city,
                        'temp_c' => $this->weatherData['current']['temp_c'],
                        'condition' => $this->weatherData['current']['condition']['text'],
                        'humidity' => $this->weatherData['current']['humidity'],
                        'wind_kph' => $this->weatherData['current']['wind_kph'],
                        'icon' => $this->weatherData['current']['condition']['icon'],
                    ]);
    }
}