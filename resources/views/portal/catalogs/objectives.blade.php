@php
    // $hideHeader = true
    $heightHeader = 100
@endphp

@extends('layouts.app')

@section('content')
<div class="container">
  <div class="py-5">
  <h3 class="is-700 mb-3">Catálogo de objetivos</h3>
  <search-objectives fetch-url="{{route('apiService.objectives')}}" :categories='@json($categories)' :force-category="{{app('request')->input('category')}}">
    @include('partials.loading')
  </search-objectives>
  </div>
</div>
@endsection