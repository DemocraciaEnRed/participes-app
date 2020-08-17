<?php

namespace App\Http\Resources;

use Auth;
// use App\Http\Resources\Goal as GoalResource;
// use App\Http\Resources\Reply as ReplyResource;
use Illuminate\Http\Resources\Json\JsonResource;

class Goal extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        $res = [
            'id' => $this->id,
            'title' => $this->title,
            'status' => $this->status,
            'status_label' => $this->status_label,
            'indicator' => $this->indicator,
            'indicator_goal' => $this->indicator_goal,
            'indicator_progress' => $this->indicator_progress,
            'progress_percentage' => $this->progress_percentage,
            'indicator_unit' => $this->indicator_unit,
            'indicator_frequency' => $this->indicator_frequency,
            'source' => $this->source,
            'url' => route('goals.index',['goalId' => $this->id])
        ];
        return $res;
    }
}
