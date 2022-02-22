<?php

namespace App\Console\Commands;

use App\Applozic\Facades\Applozic;
use App\Models\Patient;
use App\Models\ScheduledMessage;
use App\Services\MailingService;
use Carbon\Carbon;
use Illuminate\Console\Command;

class ApplozicBirthdayMessage extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'applozic:birthday-message';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    private $mailing_service = null;
    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct(MailingService $mailing_service)
    {
        parent::__construct();

        $this->mailing_service = $mailing_service;
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $applozic = Applozic::via('doctor');
        $today = Carbon::today();

        $mailing = $this->mailing_service->birthdayGet();

        if (!$mailing) return;

        Patient::query()
            ->whereMonth('birthday', $today->month)
            ->whereDay('birthday', $today->day)
            ->get()
            ->each(function ($patient) use ($applozic, $mailing) {
                if ($mailing->file_meta) {
                    $applozic->sendAttachmentMessage($patient->id, $mailing->file_meta);
                }
                $applozic->sendMessage($patient->id, $mailing->content);
            });
    }
}
