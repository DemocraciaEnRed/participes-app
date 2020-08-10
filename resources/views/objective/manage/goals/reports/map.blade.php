@php
$geometry = $report->map_geometries ?: 'undefined';
$lat = $report->map_lat ?: ($objective->map_lat ?: 'undefined');
$long = $report->map_long ?: ($objective->map_long ?: 'undefined');
$zoom = $report->map_zoom ?: ($objective->map_zoom ?: 'undefined');
@endphp

@extends('objective.manage.goals.reports.master')

@section('stylesheets')
<link href='https://api.mapbox.com/mapbox-gl-js/v1.11.1/mapbox-gl.css' rel='stylesheet' />
<link href='https://api.mapbox.com/mapbox-gl-js/plugins/mapbox-gl-draw/v1.0.9/mapbox-gl-draw.css' rel='stylesheet' type='text/css' />
@endsection

@section('headscripts')
<script src='https://api.mapbox.com/mapbox-gl-js/v1.11.1/mapbox-gl.js'></script>
<script src='https://api.mapbox.com/mapbox-gl-js/plugins/mapbox-gl-draw/v1.0.9/mapbox-gl-draw.js'></script>
@endsection


@section('panelContent')

<section>
  <h1 class="">Mapa</h1>
  <p>Aqui puede crear puntos, areas, o lineas que tengan que ver con el reporte publicado</p>
   <hr />
    <form action="{{route('objectives.manage.goals.reports.map.form',['objectiveId' => $objective->id, 'goalId' => $goal->id, 'reportId' => $report->id])}}" method="POST">
      @method('PUT')
      @csrf
      <draw-map access-token="{{config('services.mapbox.key')}}" map-style="{{config('services.mapbox.style')}}" :lat="{{$lat}}" :long="{{$long}}" :zoom="{{$zoom}}" :init-collection="{{$geometry}}" />
    </form>
</section>

@endsection
