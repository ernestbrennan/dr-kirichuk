<?php

namespace App\Channels;

use Illuminate\Notifications\Notification;
use Twilio\Rest\Client;

class TwilioChannel
{
    function send($notifiable, Notification $notification)
    {
        $message = $notification->toTwilio($notifiable);

        $client = new Client(env('TWILIO_SID'), env('TWILIO_TOKEN'));

        $client->messages->create(
            "+" . $notifiable->phone,
            [
                'from' => env('TWILIO_FROM_PHONE'),
                'body' => $message
            ]
        );
    }
}
