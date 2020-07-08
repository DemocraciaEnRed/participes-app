@extends('layouts.app')

@section('content')

<div class="container">
  @if($objective->hidden)
  <div class="alert alert-info">
    <i class="fas fa-info-circle"></i>&nbsp;Nota: El objetivo se encuentra <b>oculto</b>
  </div>
  @endif
  <div class="row">
    <div class="col-md-3">
      @include('objective.manage.menu')
    </div>
    <div class="col-md-9">
      @yield('panelContent')
    </div>
  </div>
</div>

@endsection
