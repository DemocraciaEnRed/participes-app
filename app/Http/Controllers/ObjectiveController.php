<?php

namespace App\Http\Controllers;
use App\Objective;
use Illuminate\Http\Request;

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
    }

    public function index(Request $request, $objectiveId){
        $objective = Objective::findorfail($objectiveId);
        return view('objective.view',['objective' => $objective]);
    }

}
