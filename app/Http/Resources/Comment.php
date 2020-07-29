<?php

namespace App\Http\Resources;

use Auth;
use App\Http\Resources\User as UserResource;
use App\Http\Resources\Reply as ReplyResource;
use Illuminate\Http\Resources\Json\JsonResource;

class Comment extends JsonResource
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
            'replies' => ReplyResource::collection($this->replies)
        ];
        if(Auth::user()){
          $res['reply_url'] = route('apiService.reports.comments.reply', ['reportId' => $request->report->id, 'commentId' => $this->id]);
          $res['delete_url'] = $this->when(Auth::user()->isMemberObjective($request->report->objective->id) ,route('apiService.reports.comments.delete', ['reportId' => $request->report->id, 'commentId' => $this->id]));
        }

        return $res;
    }
}
