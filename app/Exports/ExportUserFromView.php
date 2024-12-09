<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromView;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Illuminate\Contracts\View\View;

class ExportUserFromView implements FromView, WithHeadings
{
    protected $users;

    public function __construct($users)
    {
        $this->users = $users;
    }

    public function view(): View
    {
        return view('exports.users', [
            'users' => $this->users
        ]);
    }

    public function headings(): array
    {
        return ['ID', 'Name', 'Email', 'Created At'];
    }
}

