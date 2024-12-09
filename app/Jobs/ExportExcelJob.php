<?php

namespace App\Jobs;

use App\Exports\YourExport;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Queue\Queueable;
use Maatwebsite\Excel\Facades\Excel;

class ExportExcelJob implements ShouldQueue
{
    use Queueable;

    /**
     * Create a new job instance.
     */
    protected $fileName;

    // Constructor để truyền tên file hoặc dữ liệu cần thiết
    public function __construct($fileName)
    {
        $this->fileName = $fileName;
    }

    public function handle()
    {
        // Bạn có thể thay đổi logic này để xuất dữ liệu
        Excel::store(new YourExport(), $this->fileName, 'public');
    }
}
