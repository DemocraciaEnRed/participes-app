<?php

namespace App\Exports;

use App\Goal;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithHeadings;

class GoalReportsExport implements FromCollection, WithMapping, WithHeadings
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
        return Goal::findorfail($this->id)->reports()->get();
    }

    public function headings(): array
    {
        return [
            'Titulo',
            'Autor',
            'Autor Email',
            'Tipo',
            'Fecha del reporte',
            "Tags",
            "Mapeado",
            "Comentarios",
            "Feedbacks positivos",
            "Estado de la meta previamente",
            "Nuevo estado de la meta",
            "Progreso previo",
            "Progreso declarado",
            "Hito completado",
            "Fecha de completado del hito",
            "Email autor",
            "Fecha creado",
            "Fecha actualizado",
        ];
    }

    public function map($report): array
    {
        return [
            $report->title,
            $report->author->fullname,
            $report->author->email,
            $report->type_label,
            $report->date->format('d/m/Y'),
            implode(', ', $report->tags),
            $report->map_geometries ? 'Si' : 'No',
            (string) $report->comments->count(),
            (string) $report->positiveTestimonies->count(),
            $report->previous_status_label ?? '-',
            $report->status_label ?? '-',
            $report->previous_progress ? (string) $report->previous_progress : '-',
            $report->progress ? (string) $report->progress : '-',
            $report->milestone ? $report->milestone->title : '-',
            $report->milestone ? $report->milestone->completed->format('d/m/Y') : '-',
            $report->created_at->format('d/m/Y H:i:s'),
            $report->updated_at->format('d/m/Y H:i:s'),
        ];
    }

}
