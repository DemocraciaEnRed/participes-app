@extends('objective.manage.master')

@section('stylesheets')
<link href='https://api.mapbox.com/mapbox-gl-js/v2.9.1/mapbox-gl.css' rel='stylesheet' />
@endsection

@section('headscripts')
<script src='https://api.mapbox.com/mapbox-gl-js/v2.9.1/mapbox-gl.js'></script>
@endsection


@section('panelContent')

<section>
  <h1 class="">Mapa de reportes</h1>
  <p>A continuación podrás ver todos los reportes que estén georeferenciados</p>
  <map-reports fetch-url="{{route('apiService.objectives.reports',['objectiveId' => $objective->id, 'mappable'=> true])}}" access-token="{{app_setting('app_mapbox_api_key')}}" map-style="{{app_setting('app_mapbox_style')}}" :lat="{{$objective->map_lat ?: app_setting('app_map_lat_default')}}" :long="{{$objective->map_long ?: app_setting('app_map_long_default')}}" :zoom="{{$objective->map_zoom ?: app_setting('app_map_zoom_default')}}">

</section>

@endsection

