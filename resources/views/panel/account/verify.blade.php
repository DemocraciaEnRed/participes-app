@extends('panel.master')

@section('panelContent')

<section>
<h3 class="is-700">Verificar mi cuenta</h3>
@if(Auth::user()->hasVerifiedEmail())
<div class="alert alert-success my-4">
  <i class="fas fa-check fa-fw"></i>&nbsp;¡Bien! ¡Tu cuenta se encuentra verificada!
</div>
@else
<div class="alert alert-dark my-4">
  <i class="fas fa-exclamation-triangle"></i>&nbsp;Su cuenta no se encuentra verificada
</div>
<p>Es importante que verifique su correo electronico <b>{{Auth::user()->email}}</b> para que pueda:</p>
    <ul>
      <li>Participar de los reportes comentando o compartiendo su feedback.</li>
      <li>Para poder suscribirse a sus objetivos de interes y recibir notificaciones (de encontrarse habilitada la opcion de recibir por correo electrónico).</li>
      <li>Para poder formar parte de un equipo de algún objetivo y participar de forma mas cercana.</li>
    </ul>
<p>Para poder verificar su cuenta, haga <a href="{{route('verification.notice')}}">clic aquí<i class="fas fa-arrow-right fa-fw"></i></a></p>
@endif
</section>

@endsection