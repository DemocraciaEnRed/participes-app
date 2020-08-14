<?php

namespace App\Http\Resources;

use Auth;
// use App\Http\Resources\User as UserResource;
// use App\Http\Resources\Goal as GoalResource;
use Illuminate\Http\Resources\Json\JsonResource;

class Testimony extends JsonResource
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
            'report_id' => $this->report_id,
            'user_id' => $this->user_id,
            'value' => $this->value
        ];

        return $res;
    }
}
