<?php

namespace App\Jobs;

use App\Applozic\Facades\Applozic;
use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Support\Facades\Cache;
use Exception;
use Illuminate\Support\Facades\Log;

class PatientMessage implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    private $patient;
    private $text;
    private $fileMeta;
    private $log;


    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct($patient, $text, $fileMeta, $log)
    {
        $this->patient = $patient;
        $this->text = $text;
        $this->fileMeta = $fileMeta;
        $this->log = $log;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        $applozic = Applozic::via('doctor');

        if ($this->fileMeta) {
            $applozic->sendAttachmentMessage($this->patient->id, $this->fileMeta);
        }

        $applozic->sendMessage($this->patient->id, $this->text);
        $this->log->update(['succeed_count' => $this->log->succeed_count + 1]);
//
//        try {
//            if ($this->fileMeta) {
//                $applozic->sendAttachmentMessage($this->patient->id, $this->fileMeta);
//            }
//
//            $applozic->sendMessage($this->patient->id, $this->text);
//            $this->log->update(['succeed_count' => $this->log->succeed_count + 1]);
//
//        } catch (\Exception $exception) {
//            Cache::forget('doctor_auth_token');
//            $this->log->update(['failed_count' => $this->log->failed_count + 1]);
//
//            throw $exception;
//        }
    }

    public function failed(Exception $exception)
    {
        Cache::forget('doctor_auth_token');
        $this->log->update(['failed_count' => $this->log->failed_count + 1]);

        Log::error($exception->getMessage());
    }
}
