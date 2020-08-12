@php
  $currentRoute = Route::currentRouteName();
	$currentRouteGoalId = Route::current()->parameters()['goalId'] ?? false ;
@endphp

<div class="card shadow-sm rounded mb-3">
  @if(!is_null($objective->cover))
    <div class="card-img-top has-background-image" alt="Card image cap" style="height:200px; background-image:url('{{$objective->cover->thumbnail_path}}')"></div>
  @endif
  <div class="card-body pb-2">
    <div class="d-flex align-items-center">
      <div class="mr-3 category-icon-container" style="background-color: {{$objective->category->backgroundColor()}}">
        <i class="fa-2x fa-fw {{$objective->category->icon}}" style="color: {{$objective->category->color}}"></i>
      </div>
      <div class="w-100">
        <span class=" text-smallest" style="color:{{$objective->category->color}}">{{$objective->category->title}}</span>
        <h6 class="is-600">
          {{$objective->title}}
        </h6>
      </div>
    </div>
    <div class="mb-3">
      @forelse ($objective->tags as $tag)
      <li class="list-inline-item"><span class="text-muted text-smallest">{{$tag}}</span></li>
      @empty
      <li class="list-inline-item text-muted">No hay tags</li>
      @endforelse
    </div>
    <p class="text-smaller text-muted my-2">Unirse a la comunidad</p>
      <a href="https://google.com" class="btn btn-outline-primary btn-sm">Contactanos</a>
      <hr>
    <p class="text-smaller text-muted mt-2 mb-0">Visualizar</p>
  </div>
  <ul class="list-unstyled objective-goals-list">
    <li class="list-item py-2 pl-4 pr-3 text-smaller {{ $currentRoute == 'objectives.index' ? 'active' : null}} "><a href="{{route('objectives.index',['objectiveId' => $objective->id])}}">Vista general</a></li>
    @forelse ($objective->goals as $goal)
    <li class="list-item py-2 pl-4 pr-3 text-smaller {{ $currentRoute == 'goals.index' && $currentRouteGoalId == $goal->id ? 'active' : null }}"><i class="far fa-dot-circle fa-fw text-{{$goal->status}}"></i>&nbsp;<a href="{{route('goals.index',['goalId' => $goal->id])}}">{{$goal->title}}</a></li>
    @empty
    <li class="list-item py-2 pl-4 pr-3 text-smaller text-muted">No hay metas</li>
    @endforelse
  </ul>
</div>