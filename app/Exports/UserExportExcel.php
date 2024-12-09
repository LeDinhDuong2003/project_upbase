<?php

namespace App\Exports;

use App\Models\User;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithStyles;
use Maatwebsite\Excel\Concerns\WithTitle;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

class UserExportExcel implements FromCollection, WithHeadings, WithStyles, WithTitle,ShouldAutoSize
{
    public function collection()
    {
        // dump(User::all()->toArray());
        return User::all();
    }

    public function headings(): array
    {
        return [
            'ID',
            'Name',
            'Email',
            'Created At',
            'Update At',
            'Role',
            'Img',
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
        return 'Users';
    }
}
