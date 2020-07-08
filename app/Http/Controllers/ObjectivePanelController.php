<?php

namespace App\Http\Controllers;
use App\Category;
use App\Organization;
use App\Role;
use App\File;
use App\User;
use App\Objective;
use App\Goal;
use App\Milestone;
use Illuminate\Http\Request;
use App\Http\Requests\CategoryRequest;
use App\Http\Requests\OrganizationRequest;
use App\Http\Requests\ObjectiveRequest;
use App\Http\Requests\GoalRequest;
use App\Http\Requests\MilestoneRequest;

class ObjectivePanelController extends Controller
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
        $this->middleware('check_role:admin');
    }

    public function index(Request $request){
      return view('objective.manage.index', ['objective' => $request->objective]);
    }

    public function viewListTeam(Request $request){
      return view('objective.manage.team.list', ['objective' => $request->objective]);
    }

    public function viewAddTeam(Request $request){
      return view('objective.manage.team.add', ['objective' => $request->objective]);
    }

    public function formAddTeam(Request $request){
      $user = User::findOrFail($request->input('userId'));
      $request->objective->members()->attach($user, ['role' => $request->input('role')]);
      return redirect()->route('objective.manage.team', ['objId' => $request->objective->id])->with('success','Miembro agregado');
    }
    public function formRemoveTeam(Request $request){
      return redirect()->route('objective.manage.team', ['objId' => $request->objective->id])->with('success','Miembro eliminado');
    }
    public function viewListGoals(Request $request){
      return view('objective.manage.goals.list',['objective' => $request->objective]);
    }

    public function viewAddGoal(Request $request){
      return view('objective.manage.goals.add',['objective' => $request->objective]);
    }

    public function formAddGoal(Request $request){
      $rules = [
        'title' => 'required|string|max:550',
        'status' => 'required|string|in:ongoing,delayed,inactive',
        'indicator' => 'required|string|max:550',
        'indicator_goal' => 'integer|min:1',
        'indicator_progress' => 'integer|min:0',
        'indicator_unit' => 'required|string|max:550',
        'indicator_frequency' => 'string|max:550',
        'source' => 'string|max:550',
        'milestones' => 'array',
        'milestones.*' => 'required|string|max:550',
      ];
      $request->validate($rules);
      
      $goal = new Goal();
      $goal->title = $request->input('title');
      $goal->status = $request->input('status');
      $goal->indicator = $request->input('indicator');
      $goal->indicator_goal = $request->input('indicator_goal');
      $goal->indicator_progress = $request->input('indicator_progress');
      $goal->indicator_unit = $request->input('indicator_unit');
      $goal->indicator_frequency = $request->input('indicator_frequency');
      $goal->source = $request->input('source');
      $goal->objective()->associate($request->objective);
      $goal->save();
      foreach($request->input('milestones') as $key => $inputMilestone){
        $milestone = new Milestone();
        error_log($key);
        $milestone->order = $key + 1;
        $milestone->title = $inputMilestone;
        $milestone->goal()->associate($goal);
        $milestone->save();
      }
      return redirect()->route('objective.manage.goals.index', ['objId' => $request->objective->id, 'goalId' => $goal->id])->with('success','Meta creada');
    }

    public function viewGoal(Request $request, $objId, $goalId){
      $goal = Goal::findorfail($goalId);
      return view('objective.manage.goals.view',['objective' => $request->objective, 'goal' => $goal]);
    }

    public function viewListGoalMilestones(Request $request, $objId, $goalId){
      $goal = Goal::findorfail($goalId);
      return view('objective.manage.goals.milestones.list',['objective' => $request->objective, 'goal' => $goal]);
    }

    public function viewAddGoalMilestone(Request $request, $objId, $goalId){
      $goal = Goal::findorfail($goalId);
      return view('objective.manage.goals.milestones.add',['objective' => $request->objective, 'goal' => $goal]);
    }

    public function formAddGoalMilestone(Request $request, $objId, $goalId){
      $rules = [
        'title' => 'required|string|max:550',
      ];
      $request->validate($rules);
      $goal = Goal::findorfail($goalId);
      $lastMilestone = Milestone::where('goal_id', $goalId)->orderBy('order', 'desc')->first();
      $milestone = new Milestone();
      $milestone->order = $lastMilestone->order + 1;
      $milestone->title = $request->input('title');
      $milestone->goal()->associate($goal);
      $milestone->save();
      return redirect()->route('objective.manage.goals.milestones', ['objId' => $request->objective->id, 'goalId' => $goal->id])->with('success','Hito creado');
    }

    public function viewNewReport(Request $request){
      return view('objective.manage.index',['objective' => $request->objective]);
    }

    public function formNewReport(Request $request){
      return view('objective.manage.index');
    }
}
