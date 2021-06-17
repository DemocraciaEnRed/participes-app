<?php

namespace App\Http\Controllers;
use DB;
use Carbon\Carbon;
use App\Objective;
use App\Goal;
use App\Report;
use App\Faq;
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
        $countObjectives = Objective::where('hidden',false)->count();
        $countGoals = Goal::whereHas('objective', function($q) {
            $q->where('hidden', false);
        })->count();
        $countGoalsCompleted = Goal::where('status','reached')->whereHas('objective', function($q) {
            $q->where('hidden', false);
        })->count();
        return view('portal.home',[
            'countObjectives' => $countObjectives,
            'countGoals' => $countGoals,
            'countGoalsCompleted' => $countGoalsCompleted
        ]);
    }
    
    public function viewAboutGeneral()
    {
        $faqs = Faq::select(['section','id','title'])->orderBy('order','ASC')->get()->groupBy('section')->toArray();
        $questions = Faq::where('section','general')->orderBy('order','ASC')->get();
        return view('portal.about.general', ['faqs' => $faqs, 'questions' => $questions]);
    }
    public function viewAboutQuestions()
    {
        $faqs = Faq::select(['section','id','title'])->orderBy('order','ASC')->get()->groupBy('section')->toArray();
        $questions = Faq::where('section','faq')->orderBy('order','ASC')->get();
        return view('portal.about.faq', ['faqs' => $faqs, 'questions' => $questions]);
    }
    public function viewAboutLegals()
    {
        $faqs = Faq::select(['section','id','title'])->orderBy('order','ASC')->get()->groupBy('section')->toArray();
        $questions = Faq::where('section','legal')->orderBy('order','ASC')->get();
        return view('portal.about.legal', ['faqs' => $faqs, 'questions' => $questions]);
    }
    // --------------------------------

    public function fetchStats(Request $request){
        $countGoals = Goal::whereHas('objective', function($q) {
            $q->where('hidden', false);
        })->count();
        $countGoalsCompleted = Goal::whereHas('objective', function($q) {
            $q->where('hidden', false);
        })->where('status','reached')->count();
        $countGoalsOngoin = Goal::whereHas('objective', function($q) {
            $q->where('hidden', false);
        })->where('status','ongoing')->count();
        $countGoalsDelayed = Goal::whereHas('objective', function($q) {
            $q->where('hidden', false);
        })->where('status','delayed')->count();
        $countGoalsInactive = Goal::whereHas('objective', function($q) {
            $q->where('hidden', false);
        })->where('status','inactive')->count();
        $reportsTotal = Report::whereHas('goal', function($q) {
            $q->whereHas('objective', function($q2) {
                $q2->where('hidden', false);
            });
        })->where('created_at','>=',Carbon::now()->subdays(15))->count();
        $reportsData = Report::whereHas('goal', function($q) {
            $q->whereHas('objective', function($q2) {
                $q2->where('hidden', false);
            });
        })->where('created_at', '>=', Carbon::now()->subdays(15))
            ->groupBy(DB::raw('DATE(created_at)'))
            ->orderBy('date', 'ASC')
            ->get(array(
                DB::raw('DATE(created_at) as "date"'),
                DB::raw('COUNT(*) as "count"')
            ));
        return response()->json([
            'message' => 'Ok',
            'data' => [
                'goals_total' => $countGoals,
                'goals_reached' => $countGoalsCompleted,
                'goals_ongoing' => $countGoalsOngoin,
                'goals_delayed' => $countGoalsDelayed,
                'goals_inactive' => $countGoalsInactive,
                'reports_total' => $reportsTotal,
                'reports_data' => $reportsData
            ]
        ],200);

    }
}
