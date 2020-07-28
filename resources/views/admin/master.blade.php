@extends('layouts.panel')

@section('content')

<div class="container">
  <div class="row">
    <div class="col-md-3">
      @include('admin.menu')
    </div>
    <div class="col-md-9">
      @yield('adminContent')
    </div>
  </div>
</div>

@endsection
