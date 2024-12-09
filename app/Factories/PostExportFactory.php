<?php

namespace App\Factories;

use App\Factories\ExportInterface;
use App\Factories\PostExport;
use App\Factories\UserExport;

class PostExportFactory implements ExportFactoryInterface{
    public function createExportExcel(): ExportInterface{
        return new PostExport();
    }
}