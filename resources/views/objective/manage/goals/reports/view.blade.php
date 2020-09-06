@php
@endphp

@extends('objective.manage.goals.reports.master')

@section('panelContent')
  <div class="d-flex align-items-start mb-3">
    <div class="mr-3 text-center">
      <i class="fa-2x text-primary {{$report->type_icon}}"></i>
    </div>
    <div class="w-100">
      <span class="text-muted">Reporte de {{$report->type_label}}</span>
      <h3 class="is-700">
        {{$report->title}}
      </h3>
    </div>
  </div>
 <div class="card border-light my-3">
    <div class="card-body py-4 row justify-content-between">
      <div class="col-4 col-lg-2 text-center my-2 my-lg-0">
        <h6 class="font-weight-bold">Feedbacks</h6>
        <span class="h6"><i class="far fa-thumbs-up fa-fw"></i> {{$report->positive_testimonies}}</span>
      </div>
      <div class="col-4 col-lg-2 text-center my-2 my-lg-0">
        <h6 class="font-weight-bold">Comentarios</h6>
        <span class="h6"><i class="far fa-comments fa-fw"></i> {{$report->comments->count()}}</span>
      </div>
      <div class="col-4 col-lg-2 text-center my-2 my-lg-0">
        <h6 class="font-weight-bold">Mapa</h6>
        <span class="h6"><i class="fas fa-map-marked-alt fa-fw"></i> {{!is_null($report->map_lat) ? 'Si' : 'No'}}</span>
      </div>
      <div class="col-6 col-lg-2 text-center my-2 my-lg-0">
        <h6 class="font-weight-bold">Fotos</h6>
        <span class="h6"><i class="far fa-images fa-fw"></i> {{$report->photos->count()}}</span>
      </div>
      <div class="col-6 col-lg-2 text-center my-2 my-lg-0">
        <h6 class="font-weight-bold">Archivos</h6>
        <span class="h6"><i class="far fa-copy fa-fw"></i> {{$report->files->count()}}</span>
      </div>
    </div>
 </div>
@endsection