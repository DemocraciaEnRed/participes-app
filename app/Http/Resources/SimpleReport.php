<?php

namespace App\Http\Resources;

use Auth;
// use App\Http\Resources\User as UserResource;
// use App\Testimony;
use App\Http\Resources\Goal as GoalResource;
use App\Http\Resources\Testimony as TestimonyResource;
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
            'type_label' => $this->type_label,
            'type_icon' => $this->type_icon,
            'title' => $this->title,
            'date' => $this->date,
            'when' => $this->date->diffForHumans(),
            'tags' => $this->tags,
            'status' => $this->status,
            'status' => $this->status_label,
            'map_lat' => $this->map_lat,
            'map_long' => $this->map_long,
            'map_zoom' => $this->map_zoom,
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
                    $res['testimony'] = TestimonyResource::make($this->userTestimony($user->id));
                    $res['testimony_url'] = route('apiService.reports.testimonies.run',$this->id);    
                }
                break;
              default:
                break;
            }
          }
        }
        return $res;
    }
}
