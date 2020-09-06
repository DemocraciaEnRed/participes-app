<?php

namespace App\Exports;

use App\Objective;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithHeadings;

class ObjectiveSubscribersExport implements FromCollection, WithMapping, WithHeadings
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
        return Objective::findorfail($this->id)->subscribers()->get();
    }

    public function headings(): array
    {
        return [
            'Nombre',
            'Apellido',
            'Email',
            "Fecha Subscripción"
        ];
    }

    public function map($user): array
    {
        return [
            $user->name,
            $user->surname,
            $user->email,
            $user->pivot->created_at->format('d/m/Y'),
        ];
    }
    
}
