<?php

namespace App\Http\Resources;

use Auth;
use DB;
use App\Http\Resources\Goal as GoalResource;
use App\Http\Resources\Category as CategoryResource;
use App\Http\Resources\Report as ReportResource;
use Illuminate\Http\Resources\Json\JsonResource;

class Objective extends JsonResource
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
            'category' => CategoryResource::make($this->category),
            'category_id' => $this->category_id,
            'author_id' => $this->author_id,
            'title' => $this->title,
            'content' => $this->content,
            'tags' => $this->tags,
            'archived' => $this->archived,
            'hidden' => $this->hidden,
            'created_at' => $this->created_at,
            'published_at' => $this->created_at->diffForHumans(),
            'updated_at' => $this->updated_at,
            'url' => route('objectives.index',['objectiveId' => $this->id])
        ];
        
        $with = $request->query('with');
        if(!is_null($with)){
          $withParams = explode(',',$with);
          foreach ($withParams as $withParam) {
            switch($withParam){
              case 'objective_goals':
                $res['goals'] = GoalResource::collection($this->goals);
                break;
              case 'objective_reports':
                $res['reports'] = GoalResource::collection($this->goals);
                break;
              case 'objective_latest_goals':
                $res['latest_goals'] = GoalResource::collection($this->goals()->orderBy('updated_at','DESC')->limit(4)->get());
                break;
              case 'objective_latest_reports':
                $res['latest_reports'] = ReportResource::collection($this->reports()->orderBy('updated_at','DESC')->limit(4)->get());
                break;
              case 'objective_stats':
                $res['reports_count'] = $this->reports()->count();
                $res['goals_count'] = $this->goals()->count();
                $res['goals_status'] = $this->goals()->select('status',DB::raw('COUNT(*) AS total'))->groupBy('status')->get()->pluck('total','status');
                break;
              default:
                break;
            }
          }
        }
        return $res;
    }
}
