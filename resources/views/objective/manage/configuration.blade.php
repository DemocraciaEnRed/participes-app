

@extends('objective.manage.master')

@section('stylesheets')
<link href='https://api.mapbox.com/mapbox-gl-js/v1.11.1/mapbox-gl.css' rel='stylesheet' />
@endsection

@section('headscripts')
<script src='https://api.mapbox.com/mapbox-gl-js/v1.11.1/mapbox-gl.js'></script>
@endsection



@section('panelContent')

<section>
  <h1 class="">Configuración</h1>
  <p>A continuación, encontrarás opciones para configurar la visibilidad del objetivo</p>
  <hr>
   @if ($errors->any())
    <div class="alert alert-danger">
        <ul class="mb-0">
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
  @endif
  <h5 class="font-weight-bold"><i class="far fa-eye"></i> Ocultar objetivo</h5>
  <p>Al ocultar el objetivo, ocurre lo siguiente</p>
  <ul>
    <li>El objetivo deja de ser visible publicamente</li>
    <li>Administradores y miembros del equipo pueden acceder al panel de control del objetivo</li>
    <li>Coordinadores pueden volver a hacer visible el objetivo</li>
    <li>Miembros del equipo pueden crear reportes, pero los suscriptores no serán notificados</li>
    <li>Coordinadores pueden seguir creando metas.</li>
  </ul>
  <form action="{{ route('objectives.manage.configuration.hide.form',['objectiveId' => $objective->id]) }}" method="POST">
    @method('PUT')
    @csrf
    <div class="form-group">
      <div class="custom-control custom-switch">
        <input type="checkbox" class="custom-control-input" name="hidden" id="isHidden" {{$objective->hidden ? 'checked' : ''}} value="true">
        <label class="custom-control-label is-clickable" for="isHidden">Ocultar objetivo</label>
      </div>
    </div>
    <button type="submit" class="btn btn-primary">Guardar</button>
  </form>
  <hr>
  <form action="{{ route('objectives.manage.configuration.map.form',['objectiveId' => $objective->id]) }}" method="POST">
    @method('PUT')
    @csrf
    <h5 class="font-weight-bold"><i class="far fa-eye"></i> Definir centro y zoom por defecto del mapa</h5>
    <p>Defina el centro y zoom por defecto del mapa, para asegurar que los reportes del objetivo se vean de forma contenida dentro del area del mapa</p>
    <set-map-default access-token="{{config('services.mapbox.key')}}" map-style="{{config('services.mapbox.style')}}" :lat="{{$objective->map_lat ?: 'undefined'}}" :long="{{$objective->map_long ?: 'undefined'}}" :zoom="{{$objective->map_zoom ?: 'undefined'}}">
  </form>
</section>

@endsection
