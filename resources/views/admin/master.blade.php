@extends('layouts.admin')

@section('content')

<div class="container push-to-header">
  <div class="row">
    <div class="col-md-4 col-lg-3">
      <div id="menu" class="card shadow-sm rounded">
        <div class="card-body">
          @include('admin.menu')
        </div>
      </div>
    </div>
    <div class="col-md-8 col-lg-9">
      <div class="card shadow-sm rounded">
        <div class="card-body p-3 p-lg-5">
        @yield('adminContent')
        </div>
      </div>
    </div>
  </div>
</div>

@endsection