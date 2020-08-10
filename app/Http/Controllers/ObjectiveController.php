<?php

namespace App\Http\Controllers;
use App\Objective;
use App\Goal;
use App\Report;
use Illuminate\Http\Request;
use App\Http\Resources\Report as ReportResource;

class ObjectiveController extends Controller
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
        // $this->middleware('check_role:admin');
        // $this->middleware('fetch_objective');
    }

    public function index(Request $request, $objectiveId){
        $objective = Objective::findorfail($objectiveId);
        return view('objective.view',['objective' => $objective]);
    }

     public function viewList(Request $request){
       
        return view('portal.catalogs.objectives',[
            
        ]);
    }

    public function fetchObjectiveReports(Request $request, $objectiveId){
        $fetchAll = $request->query('all');
        $isMappable = $request->query('mappable');
        $reports = Report::query();
        $reports->whereHas('goal',function ($q) use($request) { 
            $q->where('objective_id',$objectiveId);
          });
        if($isMappable){
            $reports->whereNotNull('map_long')->whereNotNull('map_lat')->whereNotNull('map_center');
        }
        // If "all=1" is not present
        if($fetchAll){
            // Paginate
            $reports = $reports->get();
            return ReportResource::collection($reports);
        }
        // Otherwise
        // Get all
        $reports = $reports->paginate(10)->withQueryString();
        return ReportResource::collection($reports);
    }

    public function fetchStats(Request $request, $objectiveId){
        $countGoals = Goal::where('objective_id',$objectiveId)->count();
        $countGoalsCompleted = Goal::where('objective_id',$objectiveId)->where('status','reached')->count();
        $countGoalsOngoin = Goal::where('objective_id',$objectiveId)->where('status','ongoing')->count();
        $countGoalsDelayed = Goal::where('objective_id',$objectiveId)->where('status','delayed')->count();
        $countGoalsInactive = Goal::where('objective_id',$objectiveId)->where('status','inactive')->count();

        // $reportsTotal = Report::->where('objective_id',$objectiveId)->where('created_at','>=',Carbon::now()->subdays(15))->count();
        // $reportsData = Report::->where('objective_id',$objectiveId)->where('created_at', '>=', Carbon::now()->subdays(15))
        //                     ->groupBy(DB::raw('DATE(created_at)'))
        //                     ->orderBy('date', 'ASC')
        //                     ->get(array(
        //                         DB::raw('DATE(created_at) as "date"'),
        //                         DB::raw('COUNT(*) as "count"')
        //                     ));
        return response()->json([
            'message' => 'Ok',
            'data' => [
                'goals_total' => $countGoals,
                'goals_reached' => $countGoalsCompleted,
                'goals_ongoing' => $countGoalsOngoin,
                'goals_delayed' => $countGoalsDelayed,
                'goals_inactive' => $countGoalsInactive,
                // 'reports_total' => $reportsTotal,
                // 'reports_data' => $reportsData
            ]
        ],200);

    }
}
