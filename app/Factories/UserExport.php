<?php

namespace App\Factories;

use App\Exports\UserExportExcel;
use App\Models\User;
use Maatwebsite\Excel\Facades\Excel;

class UserExport implements ExportInterface{
    public function export(){
        return Excel::download(new UserExportExcel, 'users.xlsx');
    }
}