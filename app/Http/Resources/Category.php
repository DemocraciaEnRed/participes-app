<?php

namespace App\Http\Resources;

use Auth;
// use App\Http\Resources\Goal as GoalResource;
// use App\Http\Resources\Reply as ReplyResource;
use Illuminate\Http\Resources\Json\JsonResource;

class Category extends JsonResource
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
            'title' => $this->title,
            'icon' => $this->icon,
            'color' => $this->color,
            'background_color' => $this->background_color
        ];
        return $res;
    }
}
