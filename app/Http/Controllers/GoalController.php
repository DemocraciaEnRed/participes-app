<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Goal;
use App\Objective;
use App\Report;
use App\Http\Resources\Report as ReportResource;

class GoalController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        // Forces to be authenticated.
        // $this->middleware('auth');
    }

     public function index(Request $request, $goalId){
        $goal = Goal::findorfail($goalId);
        $objective = Objective::findorfail($goal->objective_id);
        return view('objective.goal.view',[
            'goal' => $goal,
            'objective' => $objective
        ]);
    }

    public function fetchReports(Request $request, $goalId){
        $pageSize = $request->query('size',10);
        $orderBy = $request->query('order_by');
        $detailed = $request->query('detailed');
        $fetchAll = $request->query('all');
        $onlyMappable = $request->query('mappable');
        $reports = Report::query();
        if(!is_null($orderBy)){
            $orderByParams = explode(',',$orderBy);
            $reports->orderBy($orderByParams[0],$orderByParams[1]);
        }
        $reports->where('goal_id',$goalId);
        if($onlyMappable){
            $reports->whereNotNull('map_long')->whereNotNull('map_lat')->whereNotNull('map_center');
        }
        // If "all=1" is not present
        if($fetchAll){
            // Paginate
            $reports = $reports->get();
        } else {
            // Otherwise
            // Get all
            $reports = $reports->paginate($pageSize)->withQueryString();
        }
        if($detailed){
            return ReportResource::collection($reports);
        } else {
            return SimpleReportResource::collection($reports);
        }
    }
}
