<?php

namespace App\Console\Commands;

use App\Applozic\Facades\Applozic;
use App\Models\Patient;
use App\Models\ScheduledMessage;
use App\Services\MailingService;
use Carbon\Carbon;
use Illuminate\Console\Command;

class DBClear extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'db:clear-db';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        Patient::query()->where('phone', 'like', '%+%')
            ->get()
            ->each(function ($patient) {
                $phone_formatted = preg_replace("/[^0-9.]/", '', $patient->phone);
                $duple_patient = Patient::getByPhone($phone_formatted);

                if (!$duple_patient || !$duple_patient->registered_at) {

                    $duple_patient && $duple_patient->delete();
                    $patient->update(['phone' => $phone_formatted]);

                    return;
                }

                if (!$patient->registered_at) {
                    $patient->delete();

                    return;
                }

                if ($patient->registered_at > $duple_patient->registered_at) {

                    $duple_patient->delete();
                    $patient->update(['phone' => $phone_formatted]);

                } else {
                    $patient->delete();
                }
            });

        Patient::query()
            ->where('updated_at', '<', Carbon::now()->subDays(2)->toDateTimeString())
            ->update(['verify_code' => null]);
    }
}
