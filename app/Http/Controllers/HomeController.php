<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class HomeController extends Controller
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
    public function viewAboutGeneral()
    {
        return view('portal.about.general');
    }
    public function viewAboutQuestions()
    {
        return view('portal.about.faq');
    }
    public function viewAboutLegals()
    {
        return view('portal.about.legal');
    }
    // --------------------------
    public function viewAboutGeneralTwo()
    {
        return view('portal.about2.general');
    }
    public function viewAboutQuestionsTwo()
    {
        return view('portal.about2.faq');
    }
    public function viewAboutLegalsTwo()
    {
        return view('portal.about2.legal');
    }

}
