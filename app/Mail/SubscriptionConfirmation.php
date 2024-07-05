<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;
use App\Models\Subscriber;


class SubscriptionConfirmation extends Mailable
{
    use Queueable, SerializesModels;

    public $subscriber;

    public function __construct(Subscriber $subscriber)
    {
        $this->subscriber = $subscriber;
    }

    public function build()
    {
        return $this->view('emails.subscription-confirmation')
                    ->subject('Please confirm your email address')
                    ->with([
                        'subscriber' => $this->subscriber,
                        'verificationUrl' => route('verify.email', $this->subscriber->token),
                    ]);
    }
}
