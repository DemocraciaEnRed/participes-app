<?php

namespace App\Http\Resources;

use Auth;
use App\Http\Resources\User as UserResource;
use Illuminate\Http\Resources\Json\JsonResource;

class Reply extends JsonResource
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
        ];
        if(Auth::user()){
          $res['delete_url'] = $this->when(Auth::user()->isMemberObjective($request->report->objective->id) ,route('apiService.reports.comments.reply.delete', ['reportId' => $request->report->id, 'commentId' => $this->parent_id, 'replyId' => $this->id]));
        }

        return $res;
    }
}
