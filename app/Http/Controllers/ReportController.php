<?php

namespace App\Http\Controllers;

use Auth;
use Illuminate\Http\Request;

class ReportController extends Controller
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

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        return view('portal.home');
    }

    // public function commentReport(Request $request, $reportId){
    //   if (!Auth::check()) {
    //       abort(403, 'No autorizado')
    //   }
    //   return view('porta.home')
    // }

}
