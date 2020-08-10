@php
  $icon = null;
  switch($report->type){
    case 'post':
      $icon = 'fas fa-bullhorn';
      break;
    case 'progress':
      $icon = 'fas fa-fast-forward';
      break;
    case 'milestone':
      $icon = 'fas fa-medal';
      break;
    default:
      $icon = 'fas fa-question';
      break;
  }
@endphp

@section('stylesheets')
<link href='https://api.mapbox.com/mapbox-gl-js/v1.11.1/mapbox-gl.css' rel='stylesheet' />
@endsection

@section('headscripts')
<script src='https://api.mapbox.com/mapbox-gl-js/v1.11.1/mapbox-gl.js'></script>
@endsection

@extends('layouts.app')

@section('content')
<div class="container push-to-header">
  <div class="card shadow-sm p-3 p-lg-5 mb-3">
    <div class="card-body">
      <div class="d-flex justify-content-between d-column">
        <h5 class="text-muted align-self-end mb-0"><i class="{{$icon}} fa-lg"></i>&nbsp;&nbsp;Reporte de
          {{$report->typeLabel()}}</h5>
        @isMember($objective->id)
        <a href="{{route('objectives.manage.goals.reports.index',['objectiveId' => $objective->id, 'goalId' => $goal->id, 'reportId' => $report->id])}}"
          class="ml-1 btn btn-primary"><i class="fas fa-edit"></i>&nbsp;Editar</a>
        @endisMember
      </div>
      <h2 class="is-600 text-primary">{{$report->title}}</h2>
      <h6 class="text-muted mb-3">Fecha del reporte: @datetime($report->date)<br>Publicado el
        @datetime($report->created_at)</h6>

      @if($report->type == 'progress')
      <div class="card shadow-sm mb-3">
        <div class="card-body d-flex justify-content-between">
          <div class="align-self-center">
            <h4 class="is-700 m-0">Progreso declarado</h4>
            <p class="m-0">Unidad del indicador: {{$goal->indicator_unit}}</p>
          </div>
          <h3 class="is-700 text-info ml-2 mb-0 align-self-center">{{$report->progress}}</h3>
        </div>
      </div>
      @endif

      @if($report->type == 'milestone')
      <div class="card shadow-sm mb-3">
        <div class="card-body d-flex justify-content-between">
          <div class="align-self-center animate__animated animate__flipInX">
            <h4 class="is-700 m-0">Hito completado</h4>
            <p class="is-size-5 mb-0 mt-1">{{$report->milestone->title}}</p>
          </div>
          <h3
            class="is-700 text-info ml-2 mb-0 align-self-center animate__animated animate__bounceIn animate__delay-1s">
            <i class="fas fa-medal fa-lg"></i></h3>
        </div>
      </div>
      @endif

      <div class="is-size-5 my-5">
        {{nl2br($report->content)}}
      </div>

      <div class="row mb-2">
        <div class="col-sm-6 my-2">
          <h5 class="is-700">Tags</h5>
          <ul class="list-inline mb-0">
            @forelse ($report->tags ?: [] as $tag)
            <li class="list-inline-item"><span class="is-size-5">{{$tag}}</span></li>
            @empty
            <li class="list-inline-item text-muted">No hay tags</li>
            @endforelse
          </ul>
        </div>
        <div class="col-sm-6 my-2">
          <h5 class="is-700">Autor</h5>
          @include('utils.avatar',['avatar' => $report->author->avatar, 'size' => 32, 'thumbnail' => true])
          {{$report->author->name}} {{$report->author->surname}}
        </div>
      </div>
      <div class="row mb-2">
        <div class="col-sm-6 my-2">
          <h5 class="is-700">Objetivo</h5>
          <a href="{{route('objectives.index',[$objective->id])}}" class="text-primary">{{$objective->title}}</a>
        </div>
        <div class="col-sm-6 my-2">
          <h5 class="is-700">Meta</h5>
          <a href="{{route('goals.index',[$goal->id])}}" class="text-primary">{{$goal->title}}</a>
        </div>
      </div>
      <h5 class="is-700 mb-3">Adjuntos</h5>
      @forelse ($report->files as $file)
      <div class="card mb-2 shadow-sm">
        <div class="card-body p-2 pl-4 pr-4 d-flex">
          <div class="mr-3 mt-2">
            <i class="far fa-file fa-lg"></i>
          </div>
          <div class="flex-fill">
            <p class="mb-0 text-smaller word-wrap-anywhere">{{ $file->name }}</p>
            <p class="text-card text-smaller text-muted mb-0">{{ $file->mime }}</p>
          </div>
          <div class="ml-3 mt-2">
            <a href="{{ asset($file->path) }}" class="card-link text-smaller"><i class="fas fa-download fa-lg"></i></a>
          </div>
        </div>
      </div>
      @empty
      <p class="my-2 text-muted">No hay archivos adjuntos al reporte</p>
      @endforelse
    </div>
  </div>
  @if($report->photos->count() > 0)
  <div class="card shadow-sm mb-3">
    <div class="card-body p-3 p-lg-5">
      <h3 class="is-600">Fotos</h3>
      @foreach ($report->photos as $photo)
      <p class="d-inline"><a href="{{asset($photo->path)}}" target="_blank"><img src="{{asset($photo->thumbnail_path)}}"
            height="150" class="img rounded mb-1" alt=""></a></p>
      @endforeach
    </div>
  </div>
  @endif
  @if(!is_null($report->map_center))
  <div class="card shadow-sm mb-3">
    <div class="card-body p-3 p-lg-5">
      <h3 class="is-600 mb-3">Mapa del reporte</h3>
      <portal-report-map access-token="{{config('services.mapbox.key')}}" map-style="{{config('services.mapbox.style')}}" :lat="{{$report->map_lat}}" :long="{{$report->map_long}}" :zoom="{{$report->map_zoom}}" :init-collection="{{$report->map_geometries}}"></portal-report-map>
      
    </div>
  </div>
  @endif
  <div class="card shadow-sm mb-3">
    <div class="card-body p-3 p-lg-5">
      <report-comments fetch-url="{{ route('apiService.reports.comments',['reportId' => $report->id]) }}"
        comment-url="{{ route('apiService.reports.comments.create',['reportId' => $report->id]) }}"
        :user="{{ Auth::user() ?  Auth::user()->load(['avatar']) : 'null' }}">
        @include('partials.loading')
      </report-comments>
    </div>
  </div>
</div>
@endsection