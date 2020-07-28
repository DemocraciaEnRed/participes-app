@extends('layouts.panel')

@section('content')

<div class="container">
  <div class="row">
    <div class="col-md-3">
      @include('panel.menu')
    </div>
    <div class="col-md-9">
      @yield('panelContent')
    </div>
  </div>
</div>

@endsection
