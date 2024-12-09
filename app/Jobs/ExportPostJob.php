<?php

namespace App\Jobs;

use App\Exports\PostExportExcel;
use App\Factories\PostExport;
use App\Factories\PostExportFactory;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Queue\Queueable;
use Maatwebsite\Excel\Facades\Excel;

class ExportPostJob implements ShouldQueue
{
    use Queueable;
    protected $fileName;

    /**
     * Create a new job instance.
     */
    public function __construct($fileName)
    {
        $this->fileName = $fileName;
        //
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        Excel::store(new PostExportExcel(),$this->fileName,'public');
    }
}
