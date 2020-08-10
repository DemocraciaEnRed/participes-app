@php
$progress = round( ($goal->indicator_progress / $goal->indicator_goal)*100  );
@endphp

@extends('objective.manage.goals.master')

@section('panelContent')
  <h3 class="font-weight-bold">Dashboard</h3>
  {{-- <h3 class="font-weight-bold">{{$goal->title}}</h3>
  <h6 class="text-secondary">Meta del objetivo: {{$objective->title}}</h6> --}}
  <hr>
    <h5 class="font-weight-bold">Progreso de la meta</h6>
    <div class="progress mb-3">
      <div class="progress-bar" role="progressbar" style="width: {{$progress}}%;" aria-valuenow="{{$progress}}" aria-valuemin="0" aria-valuemax="100">{{$progress}}%</div>
    </div>
  <div class="row">
    <div class="col md-6">
          <h5 class="font-weight-bold">Indicador</h6>
    <p>{{$goal->indicator}}</p>
    </div>
    <div class="col md-6">
         <h5 class="font-weight-bold">Estado</h6>
          <p>{{$goal->statusLabel()}}</p>
    </div>
  </div>
  <div class="row">
    <div class="col md-6">
      <h5 class="font-weight-bold">Valor a alcanzar</h6>
      <p>{{$goal->indicator_goal}}</p> 
    </div>
    <div class="col md-6">
      <h5 class="font-weight-bold">Valor actual</h6>
      <p>{{$goal->indicator_progress}} <small class="text-secondary">({{$progress}}%)</small></p>
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
    <p>{{$goal->source}}</p>
  @if(count($goal->milestones) > 0)
  <h5 class="font-weight-bold">Hitos&nbsp;<span class="badge badge-primary badge-pill">{{count($goal->milestones)}}</span></h6>
  <p>
    La meta cuenta con {{count($goal->milestones)}} hitos. Para verlo, haga <a href="{{ route('objectives.manage.goals.milestones', ['objectiveId' => $objective->id,'goalId' => $goal->id]) }}">click aqui <i class="fas fa-arrow-right"></i></a>
  </p>
  @else
  <div class="card border-secondary">
    <div class="card-body text-dark">
      <h5 class="card-title"><i class="fas fa-info-circle"></i>&nbsp;La meta no cuenta con hitos</h5>
      <p class="card-text">Si necesita crear hitos, puede crearlos haciendo <a href="{{ route('objectives.manage.goals.milestones.add', ['objectiveId' => $objective->id,'goalId' => $goal->id]) }}">click aquí <i class="fas fa-arrow-right"></i></a></p>
    </div>
  </div>
  @endif
  @if($goal->reports()->count() > 0)
  <h5 class="font-weight-bold">Reportes&nbsp;<span class="badge badge-primary badge-pill">{{$goal->reports()->count()}}</span></h6>
  <p>
    La meta cuenta con {{$goal->reports()->count()}} reportes. Para verlo, haga <a href="{{ route('objectives.manage.goals.reports', ['objectiveId' => $objective->id,'goalId' => $goal->id]) }}">click aqui <i class="fas fa-arrow-right"></i></a>
  </p>
  @else
  <div class="card border-secondary">
    <div class="card-body text-dark">
      <h5 class="card-title"><i class="fas fa-info-circle"></i>&nbsp;La meta no cuenta con reportes</h5>
      <p class="card-text">Si necesita crear reportes, puede crearlos haciendo <a href="{{ route('objectives.manage.goals.reports.add', ['objectiveId' => $objective->id,'goalId' => $goal->id]) }}">click aquí <i class="fas fa-arrow-right"></i></a></p>
    </div>
  </div>
  @endif
@endsection