<?php
namespace App\Console\Commands;

use Illuminate\Console\Command;
use GuzzleHttp\Client;

class CallSendEmails extends Command
{
    protected $signature = 'call:send-emails';
    protected $description = 'Call the sendEmails method in SubscriberController';

    public function __construct()
    {
        parent::__construct();
    }

    public function handle()
    {
        $client = new Client();
        $response = $client->get('http://weather-app1-267d87690827.herokuapp.com/send-emails');

        if ($response->getStatusCode() == 200) {
            $this->info('Emails sent successfully');
        } else {
            $this->error('Failed to send emails');
        }
    }
}
