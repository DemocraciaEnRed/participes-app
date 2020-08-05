@php
$countUnreadNotifications = count(Auth::user()->unreadNotifications)
@endphp

@extends('panel.master')

@section('panelContent')

<section>
  <div class="jumbotron d-flex bg-white">
    <div class="mr-4">
      @include('utils.avatar',['avatar' => Auth::user()->avatar, 'size' => 125])
    </div>
    <div class="">

      <h1 class="display-4">
        ¡Hola, {{Auth::user()->name}}!</h1>
      @if($countUnreadNotifications > 0)
      <p class="lead">¡Tenes {{$countUnreadNotifications}}
        {{$countUnreadNotifications > 1 ? 'notificaciones' : 'notificación'}} pendientes de leer!</p>
      @else
      <p class="lead">¡Que tengas buen dia!</p>
      @endif
    </div>
  </div>
  @if($countUnreadNotifications > 0)
  <div class="card border-secondary">
    <div class="card-body text-dark">
      <h5 class="card-title"><i class="far fa-bell"></i>&nbsp;Notificaciones sin leer</h5>
      <p class="card-text">Podes leerlos haciendo <a href="{{ route('panel.notifications.unread') }}">click aquí <i
    class="fas fa-arrow-right"></i></a></p>
  </div>
  </div>
  @else
  <div class="card border-secondary">
    <div class="card-body text-dark">
      <h5 class="card-title"><i class="far fa-bell"></i>&nbsp;Mis nofiticaciones</h5>
      <p class="card-text">Leelos haciendo <a href="{{ route('panel.notifications') }}">click aquí <i
            class="fas fa-arrow-right"></i></a></p>
    </div>
  </div>
  @endif
</section>

@endsection