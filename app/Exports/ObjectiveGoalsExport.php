<?php

namespace App\Exports;

use App\Objective;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithHeadings;

class ObjectiveGoalsExport implements FromCollection, WithMapping, WithHeadings
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
        return Objective::findorfail($this->id)->goals()->get();
    }

    public function headings(): array
    {
        return [
            'Titulo',
            'Estado',
            'Indicador',
            "Fuente",
            "Frecuencia del indicador",
            "Unidad del indicador",
            "Valor a alcanzar",
            "Valor actual",
            "Progreso (%)",
            "Reportes",
            "Hitos",
            "Mapeado",
            "Email autor",
            "Fecha creado",
            "Fecha actualizado",
        ];
    }

    public function map($goal): array
    {
        return [
            $goal->title,
            $goal->status_label,
            $goal->indicator,
            $goal->source ?? '-',
            $goal->indicator_frequency,
            $goal->indicator_unit,
            (string) $goal->indicator_goal,
            (string) $goal->indicator_progress,
            (string) $goal->progress_percentage,
            (string) $goal->reports->count(),
            (string) $goal->milestones->count(),
            $goal->map_lat ? 'Si' : 'No',
            $goal->created_at->format('d/m/Y H:i:s'),
            $goal->updated_at->format('d/m/Y H:i:s'),
        ];
    }
}
