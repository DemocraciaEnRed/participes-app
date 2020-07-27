@php
@endphp

@extends('objective.manage.goals.reports.master')

@section('panelContent')
  <div class="jumbotron rounded">
    <div class="row">

    <div class="col">
      <h2 class="is-300 {{ !$objective->cover ?: 'text-white'}}">{{$report->testimonies()->count()}}</h2>
      <p class="lead {{ !$objective->cover ?: 'text-white'}}">¡Bienvenido al panel de control del objetivo!</p>
    </div>
    <div class="col">
      <h2 class="is-300 {{ !$objective->cover ?: 'text-white'}}">{{$report->comments()->count()}}</h2>
      <p class="lead {{ !$objective->cover ?: 'text-white'}}">¡Bienvenido al panel de control del objetivo!</p>
    </div>
    </div>
    </div>
  <h5 class="font-weight-bold">Creado por</h5>
    <p>@include('utils.avatar',['avatar' => $report->author->avatar, 'size' => 32, 'thumbnail' => true]) {{$report->author->name}} {{$report->author->surname}}</p>
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