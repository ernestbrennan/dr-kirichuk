<?php

namespace App\Jobs;

use App\Applozic\Facades\Applozic;
use App\Models\File;
use App\Models\Patient;
use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;

class MassMailing implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    private $patientIds;
    private $fileId;
    private $text;
    private $log;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct($patientIds, $text, $fileId, $log)
    {
        $this->patientIds = $patientIds;
        $this->text = $text;
        $this->fileId = $fileId;
        $this->log = $log;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        $patients = Patient::find($this->patientIds);

        $file = File::find($this->fileId);

        $fileMeta = $file ? Applozic::uploadFile($file) : null;

        $patients->each(function ($patient) use ($fileMeta) {
            PatientMessage::dispatch($patient, $this->text, $fileMeta, $this->log);
        });
    }
}
