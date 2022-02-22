<?php

namespace App\Notifications\Doctor;

use App\Channels\FcmChannel;
use App\Models\Patient;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;

class PatientRegistered extends Notification
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
        return [FcmChannel::class];
    }

    public function toFcm($notifiable)
    {
        return [
            'title' => "Новый пользователь зарегистрирован",
            'body' => "Пользователь {$this->patient->first_name} {$this->patient->last_name} зарегистрировался в приложении"
        ];
    }
}
