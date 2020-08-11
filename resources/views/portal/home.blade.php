@php
    $heightHeader = 300
@endphp

@section('stylesheets')
<link href='https://api.mapbox.com/mapbox-gl-js/v1.11.1/mapbox-gl.css' rel='stylesheet' />
@endsection

@section('headscripts')
<script src='https://api.mapbox.com/mapbox-gl-js/v1.11.1/mapbox-gl.js'></script>
@endsection

@extends('layouts.app')

@section('content')
<div class="container push-to-header" style="margin-top: -250px">
  <div class="row justify-content-between mb-3 mb-md-5 flex-column-reverse flex-md-row">
    <div class="col-md-5 text-center text-md-left mb-3 mb-md-0">
      <h5 class="text-white">Canal de monitoreo ciudadano, para hacer seguimiento de objetivos y metas de gobierno</h5>
      <a href="#" class="btn btn-info">¿Que es participes?</a>
    </div>
    <div class="col-md-5 align-self-center">
      <img src="{{asset('img/participes-white.svg')}}" width="300" class="img-fluid image is-centered mb-3 mb-md-0"
        alt="{{ config('app.name', 'Laravel') }}">
    </div>
  </div>
  <div class="row mb-4">
    <div class="col-md-5 col-lg-4 mb-2 mb-md-0">
      <div class="card rounded shadow-sm">
        <div class="card-body text-center">
          <p><b>Resumen</b></p>
          <p><span class="h3 is-700"><i class="fas fa-bullseye text-info"></i>&nbsp{{$countObjectives}}</span><br>Objetivos publicados</p>
          <div class="row">
            <div class="col">
              <p><span class="h3 is-700"><i class="fas fa-medal text-primary"></i>&nbsp;{{$countGoals}}</span><br>Metas publicadas</p>
            </div>
            <div class="col">
              <p><span class="h3 is-700"><i class="fas fa-check text-success"></i>&nbsp{{$countGoalsCompleted}}</span><br>Metas completadas</p>
            </div>
          </div>
        </div>
      </div>
    </div>
    <div class="col-md-7 col-lg-8">
      <div class="card rounded shadow-sm">
        <div class="card-body">
          <p><b>Estado de las metas</b></p>
          <portal-home-stats fetch-url="{{route('apiService.home.stats')}}">
            @include('partials.loading')
          </portal-home-stats>
        </div>
      </div>
    </div>
  </div>
  <h4 class="is-400 mb-3">Ultimos reportes publicados</h4>
  <portal-home-reports-carrousel fetch-url="{{route('apiService.reports')}}"></portal-home-reports-carrousel>
  {{-- <p class="mb-4"><a href="{{route('reports')}}" class="btn btn-primary">Ver mas reportes</a></p> --}}
  <h4 class="is-400 mb-3">Ultimos objetivos actualizados</h4> 
  @foreach ($objectives as $objective)
  <div class="card rounded shadow-sm mb-3">
    <div class="card-body">
      <a href="{{route('objectives.index',['objectiveId' => $objective->id])}}"><h5 class="is-600">{{$objective->title}}</h5></a>
    </div>
  </div>
  @endforeach
  <p class="mb-4"><a href="{{route('objectives')}}" class="btn btn-primary">Ver mas objetivos</a></p>
  <h4 class="is-400 mb-3">Ultimos 15 reportes geolocalizados</h4>
  <div class="card shadow-sm">
    <div class="card-body">
      <map-reports fetch-url="{{route('apiService.reports',['mappable' => true, 'size'=> 15])}}" access-token="{{config('services.mapbox.key')}}" :paginated="false" map-style="{{config('services.mapbox.style')}}" :lat="{{$objective->map_lat ?: 'undefined'}}" :long="{{$objective->map_long ?: 'undefined'}}" :zoom="{{$objective->map_zoom ?: 'undefined'}}">
    </div>
  </div>

</div>
@endsection