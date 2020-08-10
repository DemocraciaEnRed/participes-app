@php
@endphp

@extends('objective.manage.goals.reports.master')

@section('panelContent')
    <div class="card shadow-sm mb-3">
      <div class="card-body d-flex justify-content-between">
        <div>
          <h5 class="font-weight-bold mb-0">Usuarios de acuerdo <span class="badge badge-primary badge-pill align-middle">{{$report->comments()->count()}}</span></h5>
        </div>
        <div class="ml-2">
          <a href="#"><i class="fas fa-arrow-right"></i></a>
        </div>
      </div>
    </div>
    <div class="card shadow-sm mb-3">
      <div class="card-body d-flex justify-content-between">
        <div>
          <h5 class="font-weight-bold mb-0">Comentarios <span class="badge badge-primary badge-pill align-middle">{{$report->comments()->count()}}</span></h5>
        </div>
        <div class="ml-2">
          <a href="#"><i class="fas fa-arrow-right"></i></a>
        </div>
      </div>
    </div>
  <h5 class="font-weight-bold">Creado por</h5>
    <p>@include('utils.avatar',['avatar' => $report->author->avatar, 'size' => 32, 'thumbnail' => true]) {{$report->author->name}} {{$report->author->surname}}</p>
  <h5 class="font-weight-bold">Album de fotos</h5>
  @if($report->photos()->count())
    <p>
    El reporte cuenta con {{$report->photos()->count()}} fotos. Para verlos, haga <a href="{{ route('objectives.manage.goals.reports.album', ['objectiveId' => $objective->id,'goalId' => $goal->id, 'reportId' => $report->id]) }}">click aqui <i class="fas fa-arrow-right"></i></a>
  </p>
  @else
    <p>No hay archivos asociados al reporte</p>
  @endif
  <h5 class="font-weight-bold">Archivos</h5>
  @if($report->files()->count())
    <p>
    El reporte cuenta con {{$report->files()->count()}} archivos. Para verlos, haga <a href="{{ route('objectives.manage.goals.reports.files', ['objectiveId' => $objective->id,'goalId' => $goal->id, 'reportId' => $report->id]) }}">click aqui <i class="fas fa-arrow-right"></i></a>
    </p>
  @else
    <p>No hay archivos asociados al reporte</p>
  @endif
  <h5 class="font-weight-bold">Mapa</h5>
  @if(isset($report->map_lat))
    <p>
      El reporte cuenta con un mapa. Para ver el mapa, haga <a href="{{ route('objectives.manage.goals.reports.map', ['objectiveId' => $objective->id,'goalId' => $goal->id, 'reportId' => $report->id]) }}">click aqui <i class="fas fa-arrow-right"></i></a>
    </p>
  @else
    <p>No hay un mapa asociado al reporte</p>
  @endif
@endsection