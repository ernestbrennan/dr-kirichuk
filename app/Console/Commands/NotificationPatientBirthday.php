<?php

namespace App\Console\Commands;

use App\Models\Doctor;
use App\Models\Notification;
use App\Models\Patient;
use App\Notifications\Doctor\PatientBirthday;
use Carbon\Carbon;
use Dingo\Api\Auth\Auth;
use Illuminate\Console\Command;

class NotificationPatientBirthday extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'notification:patient-birthday';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    public function handle()
    {
        $doctor = Doctor::first();

        Patient::query()
            ->whereMonth('birthday', Carbon::today()->month)
            ->whereDay('birthday', Carbon::today()->day)
            ->get()->each(function ($patient) use ($doctor) {
                Notification::create([
                    'type' => Notification::TYPE_PATIENT_BIRTHDAY,
                    'patient_id' => $patient->id
                ]);

                $doctor->notify(new PatientBirthday($patient));
            });
    }
}
