@extends('layouts.panel')

@section('content')

<div class="container">
 <div class="alert alert-info">
    <i class="fas fa-info-circle"></i>&nbsp;Nota: El objetivo se encuentra <b>oculto</b>
</div>
  <div class="row">
    <div class="col-md-3">
      @include('objective.manage.goals.menu')
    </div>
    <div class="col-md-9">
      @yield('panelContent')
    </div>
  </div>
</div>

@endsection