@php
@endphp

@extends('objective.manage.goals.reports.master')

@section('panelContent')
  <h3 class="font-weight-bold">Dashboard</h3>
  <h5 class="font-weight-bold">Creado por</h5>
    <p>{{$report->author->name}} {{$report->author->surname}}</p>
  <h5 class="font-weight-bold">Album de fotos</h5>
  @forelse ($report->photos as $photo)
      <p class="d-inline"><a href="{{asset($photo->path)}}" target="_blank"><img src="{{asset($photo->thumbnail_path)}}" height="80" class="img rounded" alt=""></a></p>
  @empty
    <p>No hay fotos asociadas al reporte</p>
  @endforelse
  <br>
  <br>
  <h5 class="font-weight-bold">Archivos</h5>
  @forelse ($report->files as $file)
    <p><a href="{{asset($file->path)}}" target="_blank"><i class="far fa-file"></i>&nbsp;{{$file->name}}</a></p>
  @empty
    <p>No hay archivos asociadas al reporte</p>
  @endforelse
@endsection