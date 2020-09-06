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
        // dd($this->isAuthor(Auth::user()->id));
        // dd(Auth::user()->isMemberObjective($request->report->objective->id));}
        $res = [
            'id' => $this->id,
            'content' => $this->content,
            'user' => UserResource::make($this->user),
            'created_at' => $this->created_at->diffForHumans(),
            'edited' => $this->edited,
            'updated_at' => $this->updated_at->diffForHumans(),
        ];
        if(Auth::user()){
            $res['edit_url'] = $this->when($this->isAuthor(Auth::user()->id),route('apiService.reports.comments.reply.edit', ['reportId' => $request->report->id, 'commentId' => $this->parent_id, 'replyId' => $this->id]));
            $res['delete_url'] = $this->when(Auth::user()->isMemberObjective($request->report->objective->id) || $this->isAuthor(Auth::user()->id) || Auth::user()->hasRole('admin'),route('apiService.reports.comments.reply.delete', ['reportId' => $request->report->id, 'commentId' => $this->parent_id, 'replyId' => $this->id]));
            $res['user_verified'] = Auth::user()->hasVerifiedEmail();
            $res['author_member_objective'] = Auth::user()->isMemberObjective($request->report->objective->id);
        }

        return $res;
    }
}
