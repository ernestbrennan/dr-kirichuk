<?php

namespace App\Notifications\Auth;

use App\Channels\TwilioChannel;
use App\Models\Patient;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;

class VerifyPhoneCodeNotification extends Notification
{
    use Queueable;

    private $patient;

    function __construct(Patient $patient)
    {
        $this->patient = $patient;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function via($notifiable)
    {
        return [TwilioChannel::class];
    }

    /**
     * Get the mail representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return string
     */
    public function toTwilio($notifiable)
    {
        return 'Ваш код верификации: ' . $this->patient->verify_code;
    }
}
