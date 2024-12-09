<?php

namespace App\Exports;

use App\Models\Post;
use App\Models\User;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\FromQuery;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithChunkReading;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithStyles;
use Maatwebsite\Excel\Concerns\WithTitle;
use Maatwebsite\Excel\Facades\Excel;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

class PostExportExcel implements WithHeadings, WithStyles, WithTitle,ShouldAutoSize,FromCollection
{
    public function collection()
    {
        // dump(User::all()->toArray());
        return Post::query()->chunk(100,function($records){
            foreach($records as $record){
                Excel::store(new YourExport($record), 'your_file.xlsx','public');
            }
        });
    }

    public function headings(): array
    {
        return [
            'ID',
            'UserId',
            'Title',
            'Content',
            'Created At',
            'Updated At',
        ];
    }

    // Định dạng các ô
    public function styles(Worksheet $sheet)
    {
        return [
            // Định dạng hàng đầu tiên (Tiêu đề)
            1 => [
                'font' => [
                    'bold' => true,
                    'size' => 14,
                    'color' => ['argb' => 'FFFFFF'],
                ],
                'fill' => [
                    'fillType' => \PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID,
                    'startColor' => ['argb' => '4CAF50'], // Màu nền xanh
                ],
                'alignment' => [
                    'horizontal' => \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER,
                    'vertical' => \PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_CENTER,
                ],
            ],

            // Định dạng các hàng còn lại
            'A' => [
                'alignment' => [
                    'horizontal' => \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER,
                ],
            ],
        ];
    }

    // Thêm tên sheet (tab) trong Excel
    public function title(): string
    {
        return 'Posts';
    }
}
