@extends('objective.manage.goals.reports.master')

@section('panelContent')

<section>
  <h1 class="">Comentarios</h1>
  <p>Los comentarios</p>
   <hr>
  {{-- <form action="{{route('objective.manage.goals.reports.comments.form',['objectiveId' => $objective->id, 'goalId' => $goal->id, 'reportId' => $report->id])}}" method="POST">
    @csrf
    <div class="form-group">
      <label><b>Agregar un nuevo comentario</b></label>
      <textarea name="content" class="form-control" rows="3"></textarea>
    </div>
    <div class="form-group">
      <button class="btn btn-primary" type="submit">Subir comentario</button>
    </div>
  </form> --}}
  {{-- <hr> --}}
  <report-comments fetch-url="{{ route('apiService.reports.comments',['reportId' => $report->id]) }}" comment-url="{{ route('apiService.reports.comments.create',['reportId' => $report->id]) }}" :user="{{ Auth::user() ?  Auth::user()->load(['avatar']) : null }}">
  {{-- @forelse($comments as $comment)
  <div class="card mb-2 shadow-sm">
    <div class="card-body">
      <div class="media">
          @include('utils.avatar',['avatar' => $comment->user->avatar, 'size' => 64, 'thumbnail' => true, 'class' => 'align-self-start mr-3'])
          <div class="media-body">
            <p class="text-smaller mb-0"><i class="fas fa-shield-alt fa-fw"></i><b>{{$comment->user->name}} {{$comment->user->surname}}</b><span class="text-muted text-smallest">&nbsp;@datetime($comment->created_at)</span></p>
            <p class="text-smaller mb-0">{{$comment->content}}</p>
          </div>
      </div>
    </div>
  </div>
  @empty
  <div class="card mb-3 shadow-sm">
    <div class="card-body">
        <div class="text-center">
          <h6 class="card-title">No hay comentarios en el reporte</h4>
        </div>
    </div>
  </div>
  @endforelse
  {{ $comments->links() }} --}}
</section>

@endsection
