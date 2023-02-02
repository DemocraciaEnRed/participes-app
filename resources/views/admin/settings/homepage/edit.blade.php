@extends('admin.master')

@section('adminContent')

<section>
<h3 class="is-700">Homepage</h3>

 <p class="lead">Los siguientes son campos para personalizar la página de inicio de la aplicación</p>
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
  @include('admin.settings.homepage.app_homepage_subtitle')
  <hr>
  @include('admin.settings.homepage.app_homepage_show_categories_selector')
  <hr>
  @include('admin.settings.homepage.app_homepage_show_latest_reports')
  <hr>
  @include('admin.settings.homepage.app_homepage_latest_reports_at_the_end')
  <hr>
  @include('admin.settings.homepage.app_homepage_show_graph_last_reports')
</section>

@endsection