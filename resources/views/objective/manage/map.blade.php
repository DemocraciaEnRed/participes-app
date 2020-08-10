@extends('objective.manage.master')

@section('stylesheets')
<link href='https://api.mapbox.com/mapbox-gl-js/v1.11.1/mapbox-gl.css' rel='stylesheet' />
@endsection

@section('headscripts')
<script src='https://api.mapbox.com/mapbox-gl-js/v1.11.1/mapbox-gl.js'></script>
@endsection


@section('panelContent')

<section>
  <h1 class="">Mapa de reportes</h1>
  <p>A continuación podrás ver todos los reportes que estén georeferenciados</p>
  <map-reports fetch-url="{{route('apiService.objectives.reports',['objectiveId' => $objective->id, 'mappable'=> true])}}" access-token="{{config('services.mapbox.key')}}" map-style="{{config('services.mapbox.style')}}" :lat="{{$objective->map_lat ?: 'undefined'}}" :long="{{$objective->map_long ?: 'undefined'}}" :zoom="{{$objective->map_zoom ?: 'undefined'}}">

</section>

@endsection
