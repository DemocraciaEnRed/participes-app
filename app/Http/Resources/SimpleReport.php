<?php

namespace App\Http\Resources;

use Auth;
// use App\Http\Resources\User as UserResource;
// use App\Http\Resources\Reply as ReplyResource;
use Illuminate\Http\Resources\Json\JsonResource;

class SimpleReport extends JsonResource
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
            'goal_id' => $this->goal_id,
            'type' => $this->type,
            'type_label' => $this->typeLabel(),
            'title' => $this->title,
            'date' => $this->date,
            'when' => $this->date->diffForHumans(),
            'tags' => $this->tags,
            'status' => $this->status,
            'status' => $this->statusLabel(),
            'map_lat' => $this->map_lat,
            'map_long' => $this->map_long,
            'map_zoom' => $this->map_zoom,
            'comments_count' => $this->comments()->count(),
            'created_at' => $this->created_at,
            'published_at' => $this->created_at->diffForHumans(),
            'updated_at' => $this->updated_at,
            'url' => route('reports.index',['reportId' => $this->id])
        ];
        return $res;
    }
}
