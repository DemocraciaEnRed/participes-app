<?php

namespace App\Http\Controllers;
use App\Objective;
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
        $this->middleware('fetch_objective');
    }

    public function index(Request $request, $objectiveId){
        return view('objective.view',['objective' => $request->objective]);
    }

    public function fetchObjectiveReports(Request $request, $objectiveId){
        $fetchAll = $request->query('all');
        $isMappable = $request->query('mappable');
        $reports = Report::query();
        $reports->whereHas('goal',function ($q) use($request) { 
            $q->where('objective_id',$request->objective->id);
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
}
