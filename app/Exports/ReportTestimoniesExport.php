<?php

namespace App\Exports;

use App\Report;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithHeadings;

class ReportTestimoniesExport implements FromCollection, WithMapping, WithHeadings
{

    public function __construct(int $id)
    {
        $this->id = $id;
    }

    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        return Report::findorfail($this->id)->testimonies()->get();
    }

    public function headings(): array
    {
        return [
            'Usuario',
            'Usuario Email',
            "Feedback",
        ];
    }

    public function map($testimony): array
    {
        return  [
          $testimony->user->fullname,
          $testimony->user->email,
          $testimony->value ? 'Positivo' : 'Negativo'
        ];
    }
}
