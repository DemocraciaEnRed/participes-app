@extends('admin.master')

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
  {{-- <form method="POST" action="{{ route('admin.settings.form') }}" enctype="multipart/form-data"> --}}
  <hr>
  @include('admin.settings.app_logo_color')
  <hr>
  @include('admin.settings.app_logo_white')
  <hr>
  @include('admin.settings.app_logo_footer')
  <hr>
  @include('admin.settings.app_favicon')
  <hr>
  @include('admin.settings.app_home_subtitle')
  <hr>
  @include('admin.settings.app_social_title')
  <hr>
  @include('admin.settings.app_social_description')
  <hr>
  @include('admin.settings.app_social_image')
  <hr>
  @include('admin.settings.app_footer_contact_info')
  <hr>
  @include('admin.settings.app_footer_description')
  {{-- @include('admin.settings.app_social_image') --}}

</section>

@endsection