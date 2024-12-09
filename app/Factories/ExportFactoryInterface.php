<?php

namespace App\Factories;

use App\Factories\ExportInterface;

interface ExportFactoryInterface{
    public function createExportExcel():ExportInterface;
}