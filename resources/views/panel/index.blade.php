@php
$countUnreadNotifications = count(Auth::user()->unreadNotifications);
$saluditos = [
  '¿Ya revisaste el estado de los objetivos?',
  '¿Ya revisaste si hay nuevos reportes?',
  'Entre las dificultades se esconde la oportunidad (Albert Einstein)',
  'Por muy alta que sea una montaña, siempre hay un camino hacia la cima',
  '¡Disfrutá del proceso de participación!',
  'Si quieres conocer, tienes que participar en la práctica que transforma la realidad (Mao Tse Tung)',
  '¡El monitoreo te espera!',
  'La suerte para triunfar en la vida se llama: “creer en ti”',
  '¿Ya sonreiste en el día de hoy?',
  'Hoy es un buen día para comenzar un nuevo habito saludable!',
  'Juntarse es un comienzo, seguir juntos es un progreso y trabajar juntos es un éxito (Henry Ford)',
  'No se trata de donde estés, si no de a donde quieres llegar',
  'Trabajar en equipo divide el trabajo y multiplica los resultados',
  'Todos los problemas tienen solución, si los monitoreamos...',
  '¡Que la inspiración te acompañe!',
  '¡Esperamos tus aportes!',
  '¡Qué bueno encontrarte por acá!',
  '¡Que tengas buen dia!'
];
$saluditosIndex = array_rand($saluditos);
@endphp

@extends('panel.master')

@section('panelContent')

<section>
  <div class="d-flex bg-white justify-content-center">
    <div class="mr-4 animate__animated animate__bounceIn">
      @include('utils.avatar',['avatar' => Auth::user()->avatar, 'size' => 120])
    </div>
    <div class="align-self-center animate__animated animate__bounceIn  animate__delay-1s text-center">
      <h1 class="">
        ¡Hola, {{Auth::user()->name}}!</h1>
      @if($countUnreadNotifications > 0)
      <p class="lead">¡Tenes {{$countUnreadNotifications}}
        {{$countUnreadNotifications > 1 ? 'notificaciones' : 'notificación'}} pendientes de leer!</p>
      @else
      <p class="lead">{{$saluditos[$saluditosIndex]}}</p>
      @endif
    </div>
  </div>
  <hr class="my-4">

  @if(!Auth::user()->hasVerifiedEmail())
  <div class="alert alert-warning my-3">
      <h5 class="is-700"><i class="fas fa-exclamation-triangle"></i>&nbsp;Debe verificar su cuenta</h5>
      Es importante que verifique su cuenta para comenzar a participar en la plataforma. Para hacerlo, haga <a href="{{ route('panel.account.verify') }}">click aquí<i class="fas fa-arrow-right fa-fw"></i></a>
  </div>
  @endif
  @if($countUnreadNotifications > 0)

  <h5 class="is-700"><i class="far fa-bell"></i>&nbsp;Notificaciones sin leer</h5>
  <p class="">Hacé <a href="{{ route('panel.notifications.unread') }}">click aquí <i class="fas fa-arrow-right"></i></a></p>

  @else
 
  <h5 class="is-700"><i class="far fa-bell"></i>&nbsp;Mis nofiticaciones</h5>
  <p>Leelas haciendo <a href="{{ route('panel.notifications') }}">click aquí <i
        class="fas fa-arrow-right"></i></a></p>
 
  @endif
</section>

@endsection