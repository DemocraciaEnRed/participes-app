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
        // dd($this->isAuthor(Auth::user()->id));
        // dd(Auth::user()->isMemberObjective($request->report->objective->id));}
        $res = [
            'id' => $this->id,
            'content' => $this->content,
            'user' => UserResource::make($this->user),
            'created_at' => $this->created_at->diffForHumans(),
            'edited' => $this->edited,
            'updated_at' => $this->updated_at->diffForHumans(),
            'replies' => ReplyResource::collection($this->replies)
        ];
        if(Auth::user()){
          $res['reply_url'] = route('apiService.reports.comments.reply', ['reportId' => $request->report->id, 'commentId' => $this->id]);
          $res['edit_url'] = $this->when($this->isAuthor(Auth::user()->id),route('apiService.reports.comments.edit', ['reportId' => $request->report->id, 'commentId' => $this->id]));
          $res['delete_url'] = $this->when(Auth::user()->isMemberObjective($request->report->objective->id) || $this->isAuthor(Auth::user()->id) || Auth::user()->hasRole('admin'),route('apiService.reports.comments.delete', ['reportId' => $request->report->id, 'commentId' => $this->id]));
          $res['user_verified'] = Auth::user()->hasVerifiedEmail();
          $res['author_member_objective'] = $this->user->isMemberObjective($request->report->objective->id);
        }

        return $res;
    }
}
