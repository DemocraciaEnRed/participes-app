<?php

namespace App\Http\Controllers;
use Notification;
use Image;
use Storage;
use Str;
use App\Category;
use App\Organization;
use App\Role;
use App\File;
use App\ImageFile;
use App\User;
use App\Objective;
use App\Goal;
use App\Milestone;
use App\Report;
use App\Notifications\NewReport;
use Illuminate\Http\Request;

class ReportPanelController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        // Forces to be authenticated.
        $this->middleware('auth');
        $this->middleware('fetch_objective');
        $this->middleware('goal_belongs_objective');
        $this->middleware('fetch_goal');
        $this->middleware('report_belongs_goal');
        $this->middleware('fetch_report');
        $this->middleware('can_manage_objective');
    }

    private function hasManagerPrivileges(Request $request){
      if(!$request->user()->hasRole('admin') && !$request->user()->isManagerObjective($request->objective->id)){
        abort(403, 'No autorizado');
      }
      return;
    }

    public function viewReport(Request $request, $objectiveId, $goalId, $reportId){

      return view('objective.manage.goals.reports.view',['objective' => $request->objective, 'goal' => $request->goal, 'report' => $request->report]);
    }
}