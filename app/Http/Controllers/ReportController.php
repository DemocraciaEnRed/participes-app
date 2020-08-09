<?php

namespace App\Http\Controllers;

use Auth;
use App\Comment;
use App\Report;
use Illuminate\Http\Request;
use App\Http\Resources\Comment as CommentResource;
use App\Http\Resources\Report as ReportResource;

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

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function fetch(Request $request)
    {   
        $reports = Report::query(); 
        $reports->orderBy('created_at','DESC');
        $reports = $reports->paginate(10);
        return ReportResource::collection($reports);
    }

    public function fetchComments(Request $request, $reportId){
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

}
