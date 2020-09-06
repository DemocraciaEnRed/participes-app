<?php

namespace App\Exports;

use App\Report;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithHeadings;

class ReportCommentsExport implements FromCollection, WithMapping, WithHeadings
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
        return Report::findorfail($this->id)->comments()->get();
    }

    public function headings(): array
    {
        return [
            'Tipo',
            'ID',
            'Respuesta a (ID)',
            'Autor',
            'Autor Email',
            "Comentario",
            "Fecha creado",
            "Fecha actualizado",
        ];
    }

    public function map($comment): array
    {
        $theReturn = array();
        
        $parentComment = [
          'Comentario',
          $comment->id,
          '-',
          $comment->user->fullname,
          $comment->user->email,
          $comment->content,
          $comment->created_at->format('d/m/Y H:i:s'),
          $comment->updated_at->format('d/m/Y H:i:s'),
        ];

        array_push($theReturn,$parentComment);

        foreach($comment->replies as $reply){
          $commentReply = [
            'Respuesta',
            $reply->id,
            $reply->parent_id,
            $reply->user->fullname,
            $reply->user->email,
            $reply->content,
            $reply->created_at->format('d/m/Y H:i:s'),
            $reply->updated_at->format('d/m/Y H:i:s'),
          ];

          array_push($theReturn,$commentReply);
        }
        return $theReturn;
    }
}
