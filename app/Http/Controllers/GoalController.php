<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Goal;
use App\Objective;

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
        return view('goal.view',[
            'goal' => $goal,
            'objective' => $objective
        ]);
    }
}
