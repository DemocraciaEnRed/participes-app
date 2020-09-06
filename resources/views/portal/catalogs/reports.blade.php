@php
    $heightHeader = 100
@endphp

@extends('layouts.app')

@section('content')
<div class="container">
  <div class="py-5">
  <h3 class="is-700 mb-3">Catálogo de reportes</h3>
  <search-reports fetch-url="{{route('apiService.reports')}}" querystring="">
    @include('partials.loading')
  </search-reports>
  </div>
</div>
@endsection