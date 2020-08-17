@php
    $heightHeader = 100
@endphp

@extends('layouts.app')

@section('content')
<div class="container">
  <div class="py-5">
  <h2 class="is-600 mb-3">Catálogo de reportes</h2>
  <search-reports fetch-url="{{route('apiService.reports')}}" querystring="">
    @include('partials.loading')
  </search-reports>
  </div>
</div>
@endsection