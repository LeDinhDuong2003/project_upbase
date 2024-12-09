<?php

namespace App\Factories;

use App\Factories\ExportInterface;
use App\Factories\UserExport;

class UserExportFactory implements ExportFactoryInterface{
    public function createExportExcel(): ExportInterface{
        return new UserExport();
    }
}