<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Mail;
use App\Http\Controllers\WeatherController;
use App\Http\Controllers\SubscriberController;


Route::get('/', [WeatherController::class, 'index']);
Route::post('/weather', [WeatherController::class, 'getWeather']);
Route::post('/subscribe', [WeatherController::class, 'subscribe']);
Route::get('/weather', [WeatherController::class, 'getWeather']);
Route::get('/email-weather',[WeatherController::class,'sendEmail']);

Route::get('/subscribers', [SubscriberController::class, 'index'])->name('subscribers.index');
Route::get('/send-emails', [SubscriberController::class, 'sendEmails'])->name('subscribers.sendEmails');

// Route::get('/subscribe', [SubscriberController::class, 'showSubscriptionForm'])->name('subscribe.form');
// Route::post('/subscribe', [SubscriberController::class, 'subscribe'])->name('subscribe');
Route::get('/unsubscribe/{token}', [SubscriberController::class, 'unsubscribe'])->name('unsubscribe');
Route::get('/verify-email/{token}', [SubscriberController::class, 'verifyEmail'])->name('verify.email');