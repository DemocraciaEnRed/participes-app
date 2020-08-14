<?php

namespace App\Http\Resources;

use Auth;
// use App\Http\Resources\User as UserResource;
use App\Http\Resources\Goal as GoalResource;
use App\Http\Resources\Testimony as TestimonyResource;
use App\Http\Resources\SimpleComment as SimpleCommentResource;
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
            'comments_count' => $this->comments()->count(),
                        'positive_testimonies_count' => $this->positiveTestimonies()->count(), 
            'negative_testimonies_count' => $this->negativeTestimonies()->count(), 
            'created_at' => $this->created_at,
            'published_at' => $this->created_at->diffForHumans(),
            'updated_at' => $this->updated_at,
            'url' => route('reports.index',['reportId' => $this->id])
        ];

        $user = Auth::user();
        $with = $request->query('with');
        if(!is_null($with)){
          $withParams = explode(',',$with);
          foreach ($withParams as $withParam) {
            switch($withParam){
              case 'report_goal':
                $res['goal'] = GoalResource::make($this->goal);
                break;
              case 'report_actions': 
                if($user){
                    $res['testimony'] = TestimonyResource::make($this->userTestimony($user->id)->first());
                    $res['testimony_url'] = route('apiService.reports.testimonies.run',$this->id);    
                }
                break;
              case 'report_latest_comments':
                $res['latest_comments'] = SimpleCommentResource::collection($this->comments()->orderBy('created_at','DESC')->limit(4)->get());
                break;
              default:
                break;
            }
          }
        }
        
        return $res;
    }
}
