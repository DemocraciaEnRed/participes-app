@extends('objective.manage.goals.master')

@section('panelContent')
  <div class="d-flex align-items-start mb-3">
    <div class="mr-3 category-icon-container text-center">
      <i class="far fa-2x fa-fw fa-dot-circle text-{{$goal->status}}"></i>
      <span class="text-{{$goal->status}} rounded-circle is-700 text-smallest ">{{$goal->progress_percentage}}%</span>
    </div>
    <div class="w-100">
      <span class="text-{{$goal->status}}">Meta {{$goal->status_label}}</span>
      <h3 class="is-700">
        {{$goal->title}}
      </h3>
    </div>
  </div>
  <div class="card border-light my-3">
    <div class="card-body py-4 row justify-content-between">
      <div class="col-6 text-center">
        <h6 class="font-weight-bold">Reportes</h6>
        <span class="h6"><i class="far fa-file-alt fa-fw"></i> {{$goal->reports()->count()}}</span>
      </div>
      <div class="col-6 text-center">
        <h6 class="font-weight-bold">Hitos</h6>
        <span class="h6"><i class="far fa-star fa-fw"></i> {{$goal->milestones()->count()}}</span>
      </div>
    </div>
 </div>
    <h5 class="font-weight-bold">Progreso de la meta</h6>
    <div class="progress mb-3">
      <div class="progress-bar bg-{{$goal->status}}" role="progressbar" style="width: {{$goal->progress_percentage}}%;" aria-valuenow="{{$goal->progress_percentage}}" aria-valuemin="0" aria-valuemax="100">{{$goal->progress_percentage}}%</div>
    </div>
  <div class="row">
    <div class="col md-6">
          <h5 class="font-weight-bold">Indicador</h6>
    <p>{{$goal->indicator}}</p>
    </div>
    <div class="col md-6">
         <h5 class="font-weight-bold">Estado</h6>
          <p class="text-{{$goal->status}}"><i class="far fa-fw fa-dot-circle text-{{$goal->status}}"></i>{{$goal->status_label}}</p>
    </div>
  </div>
  <div class="row">
    <div class="col md-6">
      <h5 class="font-weight-bold">Valor a alcanzar</h6>
      <p>{{$goal->indicator_goal}}</p> 
    </div>
    <div class="col md-6">
      <h5 class="font-weight-bold">Valor actual</h6>
      <p>{{$goal->indicator_progress}} <small class="text-secondary">({{$goal->progress_percentage}}%)</small></p>
    </div>
  </div>
  <div class="row">
    <div class="col md-6">
      <h5 class="font-weight-bold">Unidad del indicador</h6>
      <p>{{$goal->indicator_unit}}</p> 
    </div>
    <div class="col md-6">
      <h5 class="font-weight-bold">Frecuencia</h6>
      <p>{{$goal->indicator_frequency ?: '- Sin Datos -'}}</p>
    </div>
  </div>
  <h5 class="font-weight-bold">Fuente</h6>
  @if ($goal->source)
    <p>{{$goal->source}}</p>
  @else
    <p class="text-muted">Sin información cargada</p>
  @endif
  @if($goal->milestones->isEmpty())
  <div class="card border-secondary my-2">
    <div class="card-body">
      <h6><b><i class="fas fa-info-circle"></i>&nbsp;La meta no cuenta con hitos</b></h6>
      <span class="text-muted">Puede crearlos haciendo <a href="{{ route('objectives.manage.goals.milestones.add', ['objectiveId' => $objective->id,'goalId' => $goal->id]) }}">click aquí <i class="fas fa-arrow-right"></i></a></span>
    </div>
  </div>
  @endif
  @if($goal->reports->isEmpty())
  <div class="card border-secondary my-2">
    <div class="card-body">
      <h6><b><i class="fas fa-info-circle"></i>&nbsp;La meta no cuenta con reportes</b></h6>
      <span class="text-muted">Puede crearlos haciendo <a href="{{ route('objectives.manage.goals.reports.add', ['objectiveId' => $objective->id,'goalId' => $goal->id]) }}">click aquí <i class="fas fa-arrow-right"></i></a></span>
    </div>
  </div>
  @endif
@endsection