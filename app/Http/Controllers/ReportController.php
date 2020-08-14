<?php

namespace App\Http\Controllers;

use Auth;
use App\Comment;
use App\Report;
use App\Goal;
use App\Testimony;
use App\Objective;
use Illuminate\Http\Request;
use App\Http\Resources\Comment as CommentResource;
use App\Http\Resources\Report as ReportResource;
use App\Http\Resources\SimpleReport as SimpleReportResource;

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
        // $this->middleware('fetch_report');
    }

    private function hasManagerPrivileges(Request $request){
      if(!$request->user()->hasRole('admin') && !$request->user()->isManagerObjective($request->objective->id)){
        return response()->json(['message' => 'Not authorized'],403);
      }
      return;
    }

    public function index(Request $request, $reportId){
        $report = Report::findorfail($reportId);
        $goal = Goal::findorfail($report->goal_id);
        $objective = Objective::findorfail($goal->objective_id);
        $testimony = null;
        if($request->user()){
            $testimony = $report->userTestimony($request->user()->id)->first();
        }
        return view('report.view',[
            'report' => $report,
            'goal' => $goal,
            'objective' => $objective,
            'testimony' => $testimony
        ]);
    }

    public function viewList(Request $request){
       
        return view('portal.catalogs.reports',[
            
        ]);
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function fetch(Request $request)
    {   
        $isMappable = $request->query('mappable');
        $detailed = $request->query('detailed',false);
        $pageSize = $request->query('size',10);

        $reports = Report::query();
        $reports->orderBy('created_at','DESC');
        if($isMappable){
            $reports->whereNotNull('map_long')->whereNotNull('map_lat')->whereNotNull('map_center');
        }
        $reports = $reports->paginate($pageSize);
        if($detailed){
            return ReportResource::collection($reports);
        } else {
            return SimpleReportResource::collection($reports);
        }
    }

    public function fetchComments(Request $request, $reportId){
        $request->report = Report::findorfail($reportId);
        $comments = Comment::query();
        $comments->whereHasMorph(
            'commentable',
            'App\Report',
            function ($q) use ($reportId) {
                $q->where('commentable_id', $reportId);
            }
        );
        $comments = $comments->orderBy('created_at','DESC')->paginate(4);

        return CommentResource::collection($comments);
    }

    public function runCreateComment(Request $request, $reportId){
        $report = Report::findorfail($reportId);

        if(!$request->user()){
            return response()->json(['message' => 'Not authorized'], 403);
        }

        $rules = [
            'content' => 'required|string|max:2000'
        ];

        $request->validate($rules);

        $comment = new Comment();
        $comment->content = $request->input('content');
        $comment->user()->associate($request->user());
        $report->comments()->save($comment);

        return response()->json(['message' => 'Se ha creado el comentario'], 200);

    }

    public function runCreateReply(Request $request, $reportId, $commentId){
        if(!$request->user()){
            return response()->json(['message' => 'Not authorized'], 403);
        }

        $rules = [
            'content' => 'required|string|max:2000'
        ];
        $request->validate($rules);

        $parentComment = Comment::findorfail($commentId);

        $comment = new Comment();
        $comment->content = $request->input('content');
        $comment->user()->associate($request->user());
        $parentComment->replies()->save($comment);

        return response()->json(['message' => 'Se ha creado la respuesta'], 200);
    }

    public function runDeleteComment(Request $request, $reportId, $commentId){
        $report = Report::findorfail($reportId);
        $comment = Comment::findorfail($commentId);
        $isTheOwner = $comment->user_id == $request->user()->id;
        if($isTheOwner){
            $comment->delete();
            return response()->json(['message' => 'El comentario ha sido borrado'], 200);
        }
        
        $isUserObjectiveMember = $request->user()->isMemberObjective($report->objective->id);
        if($isUserObjectiveMember){
            $comment->delete();
            return response()->json(['message' => 'El comentario ha sido borrado'], 200);
        }
        
        // Not the author and not a member of the objective
        
        return response()->json(['message' => 'Not authorized'], 403);
    }

    public function runToggleTestimony(Request $request, $reportId){
        if(!$request->user()) {
            abort(403, 'No autorizado');
        }
        $report = Report::findorfail($reportId);
        $testimony = $report->userTestimony($request->user()->id)->first();
        if($testimony){
            $testimony->delete();
        } else {
            $testimony = new Testimony();
            $testimony->user()->associate($request->user());
            $testimony->report()->associate($report);
            $testimony->value = true;
            $testimony->save();
        }
        return response()->json(['message' => 'Agregado testimonio', 'value' => true], 200);

    }
    
    public function formToggleTestimony(Request $request, $reportId){
        if(!$request->user()) {
            abort(403, 'No autorizado');
        }
        $report = Report::findorfail($reportId);
        $testimony = $report->userTestimony($request->user()->id)->first();
        if($testimony){
            $testimony->delete();
            $msg = 'Hemos quitado tu feedback correctamente';
        } else {
            $testimony = new Testimony();
            $testimony->user()->associate($request->user());
            $testimony->report()->associate($report);
            $testimony->value = true;
            $testimony->save();
            $msg = '¡Hemos guardado tu feedback con exito, muchas gracias!';
        }
        return redirect()->route('reports.index', ['reportId' => $reportId])->with('success',$msg);

    }
}
