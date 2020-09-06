<?php

namespace App\Http\Controllers;

use Auth;
use Log;
use Notification;
use App\Comment;
use App\Report;
use App\Goal;
use App\Testimony;
use App\Objective;
use Illuminate\Http\Request;
use App\Notifications\NewCommentReportForAuthor;
use App\Notifications\NewCommentReportForTeamObjective;
use App\Notifications\NewReplyReport;
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
        $orderBy = $request->query('order_by');
        $detailed = $request->query('detailed',false);
        $pageSize = $request->query('size',10);
        $type = $request->query('type',null);
        $title = $request->query('s',null);

        $reports = Report::query();
        if(!is_null($orderBy)){
            $orderByParams = explode(',',$orderBy);
            $reports->orderBy($orderByParams[0],$orderByParams[1]);
        }
        if($isMappable){
            $reports->whereNotNull('map_long')->whereNotNull('map_lat')->whereNotNull('map_center');
        }
        if(!is_null($type)){
            $reports->where('type',$type);
        }
        // if(!is_null($title)){
        //     $reports->where('title', 'like', "%{$title}%")->orWhere('tags','like', "%{$title}%");
        // }
        if(!is_null($title)){
            $titleExploded = explode(' ', $title);
            $reports->where(function ($query) use ($titleExploded) {
                foreach ($titleExploded as $keyword) {
                $query->orWhere('trace', 'like', "%{$keyword}%");
                }
            });
        }
        $reports = $reports->paginate($pageSize)->withQueryString();
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

        if($report->author->id != $request->user()->id ){
            $report->author->notify(new NewCommentReportForAuthor($report, $comment));
        }
        
        $teamMembersToNotify = $report->goal->objective->members->except([$report->author->id, $request->user()->id]);
        Notification::send($teamMembersToNotify, new NewCommentReportForTeamObjective($report, $comment));

        return response()->json(['message' => 'Se ha creado el comentario'], 200);

    }

    public function runEditComment(Request $request, $reportId, $commentId){
        $report = Report::findorfail($reportId);
        $comment = Comment::findorfail($commentId);

        if(!$request->user()){
            return response()->json(['message' => 'Not authorized'], 403);
        }

        $isTheOwner = $comment->user_id == $request->user()->id;
        $isVerified = $request->user()->hasVerifiedEmail();
        
         $rules = [
            'content' => 'required|string|max:2000'
        ];
        $request->validate($rules);

        if($isTheOwner && $isVerified){
            $comment->content = $request->input('content');
            $comment->edited = true;
            $comment->save();
            
            return response()->json(['message' => 'El comentario ha sido editado'], 200);
        }
        
        // Not the author and not a member of the objective
        
        return response()->json(['message' => 'Not authorized'], 403);
    }

    public function runDeleteComment(Request $request, $reportId, $commentId){
        $report = Report::findorfail($reportId);
        $comment = Comment::findorfail($commentId);
        
        if(!$request->user()){
            return response()->json(['message' => 'Not authorized'], 403);
        }

        $isTheOwner = $comment->user_id == $request->user()->id;
        $isVerified = $request->user()->hasVerifiedEmail();

        if($isTheOwner && $isVerified){
            $comment->delete();
            return response()->json(['message' => 'El comentario ha sido borrado'], 200);
        }
        
        $isUserObjectiveMember = $request->user()->isMemberObjective($report->objective->id);
        if($isUserObjectiveMember  && $isVerified){
            Log::channel('mysql')->info("[{$request->user()->fullname}] (Miembro del equipo) ha eliminado el comentario de [{$comment->user->fullname}] hecho en el reporte [{$report->title}], de la meta [{$report->goal->title}] del objetivo [{$report->objective->title}]", [
                'report_id' => $report->id,
                'report_title' => $report->title,
                'goal_id' => $report->goal->id,
                'goal_title' => $report->goal->title,
                'objective_id' => $report->objective->id,
                'objective_title' => $report->objective->title,
                'comment_id' => $comment->id,
                'comment_author_id' => $comment->user->id,
                'comment_author_fullname' => $comment->user->fullname,
                'comment_author_email' => $comment->user->email,
                'user_id' => $request->user()->id,
                'user_fullname' => $request->user()->fullname,
                'user_email' => $request->user()->email
            ]);
            $comment->delete();
            return response()->json(['message' => 'El comentario ha sido borrado'], 200);
        }
        
        $isUserAdmin = $request->user()->hasRole('admin');
        if($isUserAdmin && $isVerified){
             Log::channel('mysql')->info("[{$request->user()->fullname}] (Admin) ha eliminado el comentario de [{$comment->user->fullname}] hecho en el reporte [{$report->title}] de la meta [{$report->goal->title}] del objetivo [{$report->objective->title}]", [
                'report_id' => $report->id,
                'report_title' => $report->title,
                'goal_id' => $report->goal->id,
                'goal_title' => $report->goal->title,
                'objective_id' => $report->objective->id,
                'objective_title' => $report->objective->title,
                'comment_id' => $comment->id,
                'comment_author_id' => $comment->user->id,
                'comment_author_fullname' => $comment->user->fullname,
                'comment_author_email' => $comment->user->email,
                'user_id' => $request->user()->id,
                'user_fullname' => $request->user()->fullname,
                'user_email' => $request->user()->email
            ]);
            $comment->delete();
            return response()->json(['message' => 'El comentario ha sido borrado'], 200);
        }

        // Not the author and not a member of the objective
        
        return response()->json(['message' => 'Not authorized'], 403);
    }

    public function runCreateReply(Request $request, $reportId, $commentId){
        
        if(!$request->user()){
            return response()->json(['message' => 'Not authorized'], 403);
        }
        
        $isVerified = $request->user()->hasVerifiedEmail();
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
        
        $parentComment->user->notify(new NewReplyReport($parentComment->commentable, $comment));

        return response()->json(['message' => 'Se ha creado la respuesta'], 200);
    }

    public function runEditReply(Request $request, $reportId, $commentId, $replyId){
        $report = Report::findorfail($reportId);
        $comment = Comment::findorfail($replyId);
        if($comment->parent_id != $commentId){
            return response()->json(['message' => 'Not found'], 404);
        }

        if(!$request->user()){
            return response()->json(['message' => 'Not authorized'], 403);
        }

        $isTheOwner = $comment->user_id == $request->user()->id;
        $isVerified = $request->user()->hasVerifiedEmail();
        
         $rules = [
            'content' => 'required|string|max:2000'
        ];
        $request->validate($rules);

        if($isTheOwner && $isVerified){
            $comment->content = $request->input('content');
            $comment->edited = true;
            $comment->save();
            return response()->json(['message' => 'La respuesta ha sido editada'], 200);
        }
        
        // Not the author and not a member of the objective
        
        return response()->json(['message' => 'Not authorized'], 403);
    }

    public function runDeleteReply(Request $request, $reportId, $commentId, $replyId){
        $report = Report::findorfail($reportId);
        $comment = Comment::findorfail($replyId);
        if($comment->parent_id != $commentId){
            return response()->json(['message' => 'Not found'], 404);
        }

        if(!$request->user()){
            return response()->json(['message' => 'Not authorized'], 403);
        }

        $isTheOwner = $comment->user_id == $request->user()->id;
        $isVerified = $request->user()->hasVerifiedEmail();

        if($isTheOwner && $isVerified){
            $comment->delete();
            return response()->json(['message' => 'El comentario ha sido borrado'], 200);
        }
        
        $isUserObjectiveMember = $request->user()->isMemberObjective($report->objective->id);
        if($isUserObjectiveMember  && $isVerified){
            Log::channel('mysql')->info("[{$request->user()->fullname}] (Miembro del equipo) ha eliminado la respuesta de [{$comment->user->fullname}] hecho en un comentario del reporte [{$report->title}], de la meta [{$report->goal->title}] del objetivo [{$report->objective->title}]", [
                'report_id' => $report->id,
                'report_title' => $report->title,
                'goal_id' => $report->goal->id,
                'goal_title' => $report->goal->title,
                'objective_id' => $report->objective->id,
                'objective_title' => $report->objective->title,
                'comment_id' => $comment->id,
                'comment_parent_id' => $comment->parent_id,
                'comment_author_id' => $comment->user->id,
                'comment_author_fullname' => $comment->user->fullname,
                'comment_author_email' => $comment->user->email,
                'user_id' => $request->user()->id,
                'user_fullname' => $request->user()->fullname,
                'user_email' => $request->user()->email
            ]);
            $comment->delete();
            return response()->json(['message' => 'El comentario ha sido borrado'], 200);
        }
        
        $isUserAdmin = $request->user()->hasRole('admin');
        if($isUserAdmin && $isVerified){
            $comment->delete();
             Log::channel('mysql')->info("[{$request->user()->fullname}] (Admin) ha eliminado la respuesta de [{$comment->user->fullname}] hecho en un comentario del reporte [{$report->title}], de la meta [{$report->goal->title}] del objetivo [{$report->objective->title}] ", [
                'report_id' => $report->id,
                'report_title' => $report->title,
                'goal_id' => $report->goal->id,
                'goal_title' => $report->goal->title,
                'objective_id' => $report->objective->id,
                'objective_title' => $report->objective->title,
                'comment_id' => $comment->id,
                'comment_parent_id' => $comment->parent_id,
                'comment_author_id' => $comment->user->id,
                'comment_author_fullname' => $comment->user->fullname,
                'comment_author_email' => $comment->user->email,
                'user_id' => $request->user()->id,
                'user_fullname' => $request->user()->fullname,
                'user_email' => $request->user()->email
            ]);
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
