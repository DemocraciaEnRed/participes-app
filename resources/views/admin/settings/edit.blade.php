@extends('admin.master')

@section('stylesheets')
<link href='https://api.mapbox.com/mapbox-gl-js/v2.9.1/mapbox-gl.css' rel='stylesheet' />
@endsection

@section('headscripts')
<script src='https://api.mapbox.com/mapbox-gl-js/v2.9.1/mapbox-gl.js'></script>
@endsection

@section('adminContent')

<section>
<h3 class="is-700">Editar configuracion</h3>
 <p class="lead">Las siguientes son campos para la configuración de la aplicación</p>
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
  @include('admin.settings.app_logo_color')
  <hr>
  @include('admin.settings.app_logo_white')
  <hr>
  @include('admin.settings.app_logo_footer')
  <hr>
  @include('admin.settings.app_favicon')
  <hr>
  @include('admin.settings.app_footer_contact_info')
  <hr>
  @include('admin.settings.app_footer_description')
  <hr>
  {{-- @include('admin.settings.app_social_image') --}}

</section>

@endsection