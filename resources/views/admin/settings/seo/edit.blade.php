@extends('admin.master')

@section('adminContent')

<section>
<h3 class="is-700">SEO & Analytics</h3>
 <p class="lead">Los siguientes son campos para configurar SEO y Analytics en la plataforma. Los metadatos de SEO son los que se utilizan para mostrar información en los buscadores y redes sociales al igual que preview en las aplicaciones móviles o al compartir links</p>
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
  @include('admin.settings.seo.app_google_analytics_4_id')
  <hr>
  @include('admin.settings.seo.app_social_title')
  <hr>
  @include('admin.settings.seo.app_social_description')
  <hr>
  @include('admin.settings.seo.app_social_image')
  <hr>
</section>

@endsection