<?php

namespace App\Http\Controllers;
use App\Objective;
use App\Goal;
use App\Report;
use Illuminate\Http\Request;
use App\Http\Resources\Objective as ObjectiveResource;
use App\Http\Resources\Report as ReportResource;
use App\Http\Resources\SimpleReport as SimpleReportResource;

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
        $objective = Objective::findorfail($objectiveId)->load(['organizations','organizations.logo']);
        $reports = $objective->reports()->paginate(5);
        return view('objective.view',['objective' => $objective,'reports' => $reports]);
    }

     public function viewList(Request $request){
       
        return view('portal.catalogs.objectives',[
            
        ]);
    }

    public function fetch(Request $request)
    {   
        $pageSize = $request->query('size',10);
        $orderBy = $request->query('order_by');
        $hidden = $request->query('hidden',false);
        
        $objectives = Objective::query();
        if(!is_null($orderBy)){
            $orderByParams = explode(',',$orderBy);
            $objectives->orderBy($orderByParams[0],$orderByParams[1]);
        }
        $objectives->where('hidden',false);
        $objectives = $objectives->paginate($pageSize);
        return ObjectiveResource::collection($objectives);
    }

    public function fetchOne(Request $request, $objectiveId)
    {   
        $objective = Objective::findorfail($objectiveId);
        dd($objective);   
    }

    public function fetchReports(Request $request, $objectiveId){
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
        $reports->whereHas('goal',function ($q) use($request, $objectiveId) { 
            $q->where('objective_id',$objectiveId);
          });
        
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

    public function fetchStats(Request $request, $objectiveId){
        $objective = Objective::findorfail($objectiveId);
        $countGoals = Goal::where('objective_id',$objectiveId)->count();
        $countGoalsCompleted = Goal::where('objective_id',$objectiveId)->where('status','reached')->count();
        $countGoalsOngoin = Goal::where('objective_id',$objectiveId)->where('status','ongoing')->count();
        $countGoalsDelayed = Goal::where('objective_id',$objectiveId)->where('status','delayed')->count();
        $countGoalsInactive = Goal::where('objective_id',$objectiveId)->where('status','inactive')->count();
        $countGoalsInactive = Goal::where('objective_id',$objectiveId)->where('status','inactive')->count();
        $reportsTotal =$objective->reports()->count(); 
        $filesTotal =$objective->files()->count(); 
        $subscribersTotal =$objective->subscribers()->count(); 
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
                'reports_total' => $reportsTotal,
                'files_total' => $filesTotal,
                'subscribers_total' => $subscribersTotal,
                // 'reports_data' => $reportsData
            ]
        ],200);
    }

     public function formToggleSubscription(Request $request, $objectiveId){
        if(!$request->user()) {
            abort(403, 'No autorizado');
        }
        $objective = Objective::findorfail($objectiveId);
        $isSubscriber = $objective->isSubscriber($request->user()->id);
        if($isSubscriber){
            $objective->subscribers()->detach($request->user()->id);
            $msg = 'Te has desubscripto del objetivo';
        } else {
            $objective->subscribers()->attach($request->user()->id);
            $msg = '¡Te has subscripto al objetivo!';
        }
        return redirect()->back()->with('success',$msg);

    }
}
