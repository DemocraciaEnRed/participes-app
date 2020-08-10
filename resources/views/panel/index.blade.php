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
      <p class="lead">{{$saluditos[$saluditosIndex]}}</p>
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
      <p class="card-text">Leelas haciendo <a href="{{ route('panel.notifications') }}">click aquí <i
            class="fas fa-arrow-right"></i></a></p>
    </div>
  </div>
  @endif
</section>

@endsection