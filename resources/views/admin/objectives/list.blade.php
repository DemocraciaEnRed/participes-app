@extends('admin.master')

@section('adminContent')

<section>
  <h3 class="is-700">Objetivos</h1>
  <p class="lead">Acá encontrarás el listado de objetivos que podés administrar</p>
  @if(count($objectives) > 0)
    @foreach($objectives as $objective)
    <div class="card my-3 shadow-sm">
      <div class="card-body d-flex align-items-start">
          <div class="mr-3 category-icon-container" style="background-color: {{$objective->category->background_color}}">
            <i class="fa-2x fa-fw {{$objective->category->icon}}" style="color: {{$objective->category->color}}"></i>
          </div>
          <div class="w-100">
            <span class="" style="color:{{$objective->category->color}}">{{$objective->category->title}}</span>
            <h4 class="is-700 my-1">
              <a href="{{route('objectives.manage.index',['objectiveId' => $objective->id])}}" class="text-dark">{{$objective->title}}</a>
            </h4>
            <p class="text-muted text-smaller my-1">{{Str::limit($objective->content, 200, $end=' [...]')}}</p> 
          </div>
        {{-- <h5 class="card-title font-weight-bold"><a class="text-primary" href="{{route('objectives.manage.index',['objectiveId' => $objective->id])}}">{{$objective->title}}</a></h5>
        <h6 class="card-subtitle mb-2">{{count($objective->goals)}} Metas <small class="text-muted">Creado {{$objective->created_at->diffForHumans()}}</small></h6>
            --}}
      </div>
    </div>
    @endforeach
  @else
    <div class="card mb-3 shadow-sm">
      <div class="card-body">
        <h6 class="card-title font-weight-bold m-0">No hay objetivos creados</h6>
      </div>
    </div>
  @endif
  {{ $objectives->links() }}
</section>

@endsection
