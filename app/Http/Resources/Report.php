<?php

namespace App\Http\Resources;

use Auth;
// use App\Http\Resources\User as UserResource;
// use App\Http\Resources\Reply as ReplyResource;
use Illuminate\Http\Resources\Json\JsonResource;

class Report extends JsonResource
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
            'author_id' => $this->author_id,
            'goal_id' => $this->goal_id,
            'type' => $this->type,
            'type_label' => $this->typeLabel(),
            'title' => $this->title,
            'content' => $this->content,
            'date' => $this->date,
            'when' => $this->date->diffForHumans(),
            'tags' => $this->tags,
            'status' => $this->status,
            'progress' => $this->progress,
            'map_lat' => $this->map_lat,
            'map_long' => $this->map_long,
            'map_zoom' => $this->map_zoom,
            'map_center' => $this->map_center,
            'map_geometries' => $this->map_geometries,
            'milestone_achieved' => $this->milestone_achieved,
            'created_at' => $this->created_at,
        ];
        return $res;
    }
}
