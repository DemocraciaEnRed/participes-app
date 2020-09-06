@extends('objective.manage.goals.master')

@section('panelContent')

<section>
  <h3 class="is-700">Reportes</h3>
  <p class="lead">A continuación encontrarás el listado de reportes asociados a la meta</p>
  @isManager($objective->id)
  @if(!$reports->isEmpty())
  <div class="my-3">
    <a href="{{route('objectives.manage.goals.reports.download', ['objectiveId' => $objective->id, 'goalId' => $goal->id])}}" class="btn btn-link btn-sm"><i class="fas fa-download fa-fw"></i><i class="far fa-file-excel fa-fw"></i>Descargar .xlsx</a>
  </div>
  @endif
  @endisManager
  @forelse($reports as $report)
  <div class="card my-3 shadow-sm">
    <div class="card-body d-flex justify-content-between">
      <div>
        <h5 class="card-title font-weight-bold m-0"><a href="{{ route('objectives.manage.goals.reports.index',['objectiveId' => $objective->id, 'goalId' => $goal->id, 'reportId' => $report->id]) }}">{{$report->title}}</a></h5>
        <p title="{{$report->date}}" class="text-muted text-smaller">{{$report->date->diffForHumans()}}</p>
        @if($report->type == "progress")
        <p class="text-smaller mb-0">Progreso declarado - {{$report->progress}} ({{$goal->indicator_unit}})</p>
        @elseif($report->type == "milestone")
        <p class="text-smaller mb-0">Completado: Hito {{$report->milestone->order}}#: {{$report->milestone->title}}</p>
        @endif
        <p class="text-smaller mb-0">Cambio de estado:  {{$report->status}}</p>
      </div>
      <div class="text-center" style="min-width: 70px">
        @if($report->type == "post")
        <h6 class="text-secondary m-0"><i class="fas fa-bullhorn fa-lg"></i></h6>
        <p class="text-secondary text-smaller m-0">Novedad</p>
        @elseif($report->type == "progress")
        <h6 class="text-secondary m-0"><i class="fas fa-fast-forward fa-lg"></i></h6>
        <p class="text-secondary text-smaller m-0">Avance</p>
        @elseif($report->type == "milestone")
        <h6 class="text-secondary m-0"><i class="fas fa-medal fa-lg"></i></h6>
        <p class="text-secondary text-smaller m-0">Hito</p>
        @endif
      </div>
    </div>
  </div>
  @empty
  <div class="card my-3 shadow-sm">
    <div class="card-body">
      <h6 class="card-title">No hay reportes creados</h6>
        <a href="{{ route('objectives.manage.goals.reports.add', ['objectiveId' => $objective->id, 'goalId' => $goal->id]) }}" class="card-link"><b>Haga clic para crear un nuevo reporte <i class="fas fa-arrow-right"></i></b></a>
    </div>
  </div>
  @endforelse
  {{ $reports->links() }}
</section>

@endsection
