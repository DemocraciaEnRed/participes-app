<?php

namespace App\Http\Resources;

use Auth;
use App\Http\Resources\User as UserResource;
use Illuminate\Http\Resources\Json\JsonResource;

class SimpleComment extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        // return parent::toArray($request);
        // dd($request->report->objective->id);
        // dd($request->user());
        // dd(Auth::user()->isMemberObjective($request->report->objective->id));}
        $res = [
            'id' => $this->id,
            'content' => $this->content,
            'user' => UserResource::make($this->user),
            'created_at' => $this->created_at->diffForHumans(),
            'replies_count' => $this->replies()->count()
        ];

        return $res;
    }
}
