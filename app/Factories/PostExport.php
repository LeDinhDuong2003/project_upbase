<?php

namespace App\Factories;

use App\Exports\PostExportExcel;
use App\Exports\UserExportExcel;
use Maatwebsite\Excel\Facades\Excel;

class PostExport implements ExportInterface {
    public function export(){
        return Excel::store(new PostExportExcel, 'posts.xlsx');
    }
}