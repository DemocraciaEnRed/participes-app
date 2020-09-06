@extends('objective.manage.master')

@section('panelContent')

<section>
  <h3 class="is-700">Metas del objetivo</h3>
  <p class="lead">A continuación, encontrarás todas las metas asociadas a tu objetivo</p>
  @isManager($objective->id)
  @if(!$objective->goals->isEmpty())
  <div class="my-3">
    <a href="{{route('objectives.manage.goals.download', ['objectiveId' => $objective->id])}}" class="btn btn-link btn-sm"><i class="fas fa-download fa-fw"></i><i class="far fa-file-excel fa-fw"></i>Descargar .xlsx</a>
  </div>
  @endif
  @endisManager
  @forelse ($objective->goals as $goal)
  <div class="card my-3 shadow-sm">
    <div class="card-body d-flex justify-content-between align-items-center">
      <div class="mr-3 category-icon-container text-center">
        <i class="far fa-2x fa-fw fa-dot-circle text-{{$goal->status}}"></i>
        <span class="text-{{$goal->status}} rounded-circle is-700 text-smallest ">{{$goal->progress_percentage}}%</span>
      </div>
      <div class="w-100">
        <span class="text-{{$goal->status}}">Meta {{$goal->status_label}}</span>
        <h5 class="is-700 m-0">
          <a class="text-dark" href="{{ route('objectives.manage.goals.index', ['objectiveId' => $objective->id,'goalId' => $goal->id]) }}">{{$goal->title}}</a>
        </h5>
      </div>
    </div>
  </div>
  @empty
  <div class="card shadow-sm my-3">
    <div class="card-body text-center">
      <i class="far fa-surprise"></i>&nbsp;¡No hay metas del objetivo!
    </div>
  </div>
  @endforelse
</section>

@endsection
