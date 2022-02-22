<?php

namespace App\Console\Commands;

use App\Applozic\Facades\Applozic;
use App\Models\ScheduledMessage;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Log;

class ApplozicScheduledMessage extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'applozic:scheduled-message';

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

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $applozic = Applozic::via('doctor');

        ScheduledMessage::where('date', '<=', now()->toDateTimeString())
            ->get()
            ->each(function ($message) use ($applozic) {

                try {
                    Log::debug($message->load('messageable'));

                    $applozic->sendMessage($this->findPatientIdFromMessage($message), $message->content);
                } catch (\Exception $e){
                    $message->delete();

                } finally{

                    $message->delete();
                }
            });
    }

    private function findPatientIdFromMessage($message)
    {
        $patient_id = null;

        switch ($message->messageable_type) {
            case 'visit':
                $patient_id = $message->messageable->patient->id;
                break;

            case 'patient':
                $patient_id = $message->messageable->id;
                break;
        }

        return $patient_id;
    }
}
