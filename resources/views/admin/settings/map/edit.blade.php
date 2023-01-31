@extends('admin.master')

@section('stylesheets')
<link href='https://api.mapbox.com/mapbox-gl-js/v1.11.1/mapbox-gl.css' rel='stylesheet' />
@endsection

@section('headscripts')
<script src='https://api.mapbox.com/mapbox-gl-js/v1.11.1/mapbox-gl.js'></script>
@endsection

@section('adminContent')

<section>
<h3 class="is-700">Mapas y Georeferencia</h3>

  <div class="alert alert-dark">
    <i class="fas fa-info-circle"></i> Mapas y georeferencias utiliza mapbox-gl-js/v1.11.1 
  </div>

 <p class="lead">Los siguientes son campos para habilitar y configurar mapas y georeferencias en la plataforma</p>
  @if ($errors->any())
    <div class="alert alert-danger">
        <ul class="mb-0">
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
  @endif
  @include('admin.settings.reset_cache')
  <hr>
  @include('admin.settings.map.app_map_enabled')
  <hr>
  @include('admin.settings.map.app_homepage_show_map')
  <hr>
  @include('admin.settings.map.app_mapbox_api_key')
  <hr>
  @include('admin.settings.map.app_mapbox_style')
  @if($settings['app_map_enabled']->value && $settings['app_mapbox_api_key']->value && $settings['app_mapbox_style']->value)
    <hr>
    @include('admin.settings.map.app_map_default')
    @else
    <hr>
  <div class="form-group">
    <div class="alert alert-light">
      <p class="mb-0">Para poder configurar el mapa por defecto debe tener habilitado la georeferenciación, y tener una clave de acceso a la API de Mapbox y un estilo de mapa</p>
    </div>
  </div>
  @endif
</section>

@endsection