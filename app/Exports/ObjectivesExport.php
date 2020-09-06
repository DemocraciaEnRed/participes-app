<?php

namespace App\Exports;

use App\Objective;
use App\Goal;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithHeadings;

class ObjectivesExport implements FromCollection, WithMapping, WithHeadings
{

    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        return Objective::all();
    }

    public function headings(): array
    {
        return [
            'Titulo',
            'Autor',
            'Email',
            'Oculto',
            'Metas',
            'Meta alcanzada',
            'Meta en progreso',
            'Meta no cumplida',
            'Meta inactiva',
            'Reportes',
            'Suscriptores',
            "Fecha creado",
            "Fecha actualizado",
        ];
    }

    public function map($objective): array
    {
        $countGoals = Goal::where('objective_id',$objective->id)->count();
        $countGoalsCompleted = Goal::where('objective_id',$objective->id)->where('status','reached')->count();
        $countGoalsOngoin = Goal::where('objective_id',$objective->id)->where('status','ongoing')->count();
        $countGoalsDelayed = Goal::where('objective_id',$objective->id)->where('status','delayed')->count();
        $countGoalsInactive = Goal::where('objective_id',$objective->id)->where('status','inactive')->count();
        $reportsTotal =$objective->reports()->count(); 
        $subscribersTotal =$objective->subscribers()->count();

        return [
            $objective->title,
            $objective->author->fullname,
            $objective->author->email,
            $objective->hidden ? 'Si' : 'No',
            (string) $countGoals,
            (string) $countGoalsCompleted,
            (string) $countGoalsOngoin,
            (string) $countGoalsDelayed,
            (string) $countGoalsInactive,
            (string) $reportsTotal,
            (string) $subscribersTotal,
            $objective->created_at->format('d/m/Y H:i:s'),
            $objective->updated_at->format('d/m/Y H:i:s'),
        ];
    }
    
}
