<?php

namespace App\Http\Controllers;

use Auth;
use App\Comment;
use App\Report;
use Illuminate\Http\Request;
use App\Http\Resources\Comment as CommentResource;

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
        $this->middleware('fetch_report');
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

    public function fetchComments(Request $request, $reportId){
        // dd(Auth::user());
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
        $request->report->comments()->save($comment);

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
        $comment = Comment::findorfail($commentId);
        $isTheOwner = $comment->user_id == $request->user()->id;
        if($isTheOwner){
            $comment->delete();
            return response()->json(['message' => 'El comentario ha sido borrado'], 200);
        }
        
        $isUserObjectiveMember = $request->user()->isMemberObjective($request->report->objective->id);
        if($isUserObjectiveMember){
            $comment->delete();
            return response()->json(['message' => 'El comentario ha sido borrado'], 200);
        }
        
        // Not the author and not a member of the objective
        
        return response()->json(['message' => 'Not authorized'], 403);
    }

}
