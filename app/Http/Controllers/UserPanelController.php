<?php

namespace App\Http\Controllers;
use App\Category;
use Illuminate\Http\Request;

class UserPanelController extends Controller
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
        $this->middleware('check_role:user');
    }

    public function index(Request $request){
        return view('panel.index');
    }

    public function viewChangePassword(Request $request){
        return view('panel.password.change');
    }

}
