@extends('layouts.app')

@section('content')
<div class="container">
  <div id="about-container" class="row">
    <div class="col-md-4 col-lg-3">
      <div id="menu" class="bg-white rounded shadow" >
        <div class="card-body">
        @include('portal.about.menu')
        </div>
      </div>
    </div>
    <div class="col-md-8 col-lg-9">
      <div id="about-content" class="bg-white rounded shadow p-3 p-lg-5">
        @yield('aboutContent')
      </div>
    </div>
  </div>
</div>

@endsection