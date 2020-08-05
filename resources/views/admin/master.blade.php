@extends('layouts.app')

@section('content')

<div class="container push-to-header">
  <div class="row">
    <div class="col-md-4 col-lg-3">
      <div class="card shadow-sm rounded py-4 px-3 mb-3">
        @include('admin.menu')
      </div>
    </div>
    <div class="col-md-8 col-lg-9">
      <div class="card shadow-sm rounded p-4 mb-4">
        @yield('adminContent')
      </div>
    </div>
  </div>
</div>

@endsection