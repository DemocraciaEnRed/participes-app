@extends('admin.master')

@section('adminContent')

<section>
  <h3 class="is-700">Objetivos</h1>
  <p class="lead">Acá encontrarás el listado de objetivos que podés administrar</p>
  @if(!$objectives->isEmpty())
  <div class="my-3">
    <a href="{{route('admin.objectives.download')}}" class="btn btn-link btn-sm"><i class="fas fa-download fa-fw"></i><i class="far fa-file-excel fa-fw"></i>Descargar .xlsx</a>
  </div>
  @endif
  @forelse($objectives as $objective)
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
    </div>
  </div>
  @empty
  <div class="card my-3 shadow-sm">
    <div class="card-body text-center">
      <h6>No hay objetivos creados</h6>
    </div>
  </div>
  @endforelse
  {{ $objectives->links() }}
</section>

@endsection
