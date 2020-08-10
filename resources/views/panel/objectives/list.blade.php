@extends('panel.master')

@section('panelContent')

<section>
  <h1 class="">Mis objetivos</h1>
  <p>Estos son los objetivos de los cuales formas parte del equipo.</p>
  @if(count($objectives) > 0)
  @foreach($objectives as $objective)
  <div class="card mb-3 shadow-sm">
    <div class="card-body">
      <p class="text-smaller text-muted mb-1">
        @if($objective->hidden)
        <span class="badge badge-warning align-middle"><i class="fas fa-eye-slash"></i>Oculto</span>&nbsp;&nbsp;
        @endif
        <i class="{{$objective->category->icon}}"></i> {{$objective->category->title}} -
        {{$objective->goals()->count()}} Metas</p>
      <h5 class="card-title font-weight-bold mb-1"><a class="text-primary"
          href="{{route('objectives.manage.index',['objectiveId' => $objective->id])}}">{{$objective->title}}</a></h5>
      <p>
        @foreach ($objective->tags as $tag)
        <span class="badge badge-light align-middle">{{$tag}}</span>
        @endforeach
      </p>
      <p class="text-muted text-smaller mb-0">{{Str::limit($objective->content, 200, $end=' [...]')}}</p>
    </div>
  </div>
  @endforeach
  @else
  <div class="card mb-3 shadow-sm">
    <div class="card-body text-center">
      <h6 class="card-title mb-2"><i class="far fa-surprise"></i>&nbsp;No forma parte de ningun objetivo</h6>
      <p class="text-smaller mb-0">¿Quiere participar activamente? Únase a algun objetivo!</p>
    </div>
  </div>
  @endif
  {{ $objectives->links() }}

</section>

@endsection