@php
  $currentRoute = Route::currentRouteName();
	$currentRouteGoalId = Route::current()->parameters()['goalId'] ?? false ;
@endphp

<div class="card shadow-sm rounded mb-3">
  @if(!is_null($objective->cover))
    <div class="card-img-top has-background-image" alt="Card image cap" style="height:200px; background-image:url('{{$objective->cover->thumbnail_path}}')"></div>
  @endif
  <div class="card-body pb-2">
    <div class="d-flex align-items-center mb-3">
      <div class="mr-3 category-icon-container" style="background-color: {{$objective->category->background_color}}">
        <i class="fa-2x fa-fw {{$objective->category->icon}}" style="color: {{$objective->category->color}}"></i>
      </div>
      <div class="w-100">
        <span class=" text-smallest" style="color:{{$objective->category->color}}">{{$objective->category->title}}</span>
        <h6 class="is-600 m-0">
          {{$objective->title}}
        </h6>
      </div>
    </div>
    @if($objective->tags && count($objective->tags) > 0)
      <div class="my-3">
        @forelse ($objective->tags ?: [] as $tag)
        <li class="list-inline-item"><span class="text-muted text-smallest">{{$tag}}</span></li>
        @empty
        <li class="list-inline-item text-muted">No hay tags</li>
        @endforelse
      </div>
    @endif
    @if(!$objective->communities->isEmpty())
      <p class="text-smaller text-muted my-2">¡Unite a nuestra comunidad!</p>
      @foreach($objective->communities as $community)
              <a href="{{$community->url}}" target="_blank" class="py-1 px-2 text-smallest rounded d-inline-block my-1 mb-1" style="border: 1px solid {{$community->color}}; color: {{$community->color}}"><i class="{{$community->icon}}"></i>&nbsp;{{$community->label}}</a>
      @endforeach
    @endif
  </div>
   @isManager($objective->id)
  <hr>
  <div class="pl-3">
    <a href="{{route('objectives.manage.index',['objectiveId'=> $objective->id])}}" class="btn btn-link btn-sm"><i class="fas fa-external-link-alt"></i> Panel objetivo</a>
    @if($currentRoute == 'goals.index')
    <a href="{{route('objectives.manage.goals.index',['objectiveId'=> $objective->id, 'goalId' => $goal->id])}}" class="btn btn-link btn-sm"><i class="fas fa-external-link-alt"></i> Panel meta</a>
    @endif
  </div>
  @endisManager
  <hr>
  <ul class="list-unstyled objective-goals-list">
    <li class="list-item py-2 pl-4 pr-3 {{ $currentRoute == 'objectives.index' ? 'active' : null}} "><a href="{{route('objectives.index',['objectiveId' => $objective->id])}}">Vista general del objetivo</a></li>
    @forelse ($objective->goals as $goalAux)
    <li class="list-item py-2 pl-4 pr-3 {{ $currentRoute == 'goals.index' && $currentRouteGoalId == $goalAux->id ? 'active' : null }}"><i class="far fa-dot-circle fa-fw text-{{$goalAux->status}}"></i>&nbsp;<a href="{{route('goals.index',['goalId' => $goalAux->id])}}">{{$goalAux->title}}</a></li>
    @empty
    <li class="list-item py-2 pl-4 pr-3 text-muted">No hay metas</li>
    @endforelse
  </ul>
</div>