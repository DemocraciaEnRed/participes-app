@extends('panel.master')

@section('panelContent')

<section>
<h1 class="">Verificar mi cuenta</h1>
@if(Auth::user()->hasVerifiedEmail())
<div class="alert alert-success my-4">
  <i class="fas fa-check fa-fw"></i>&nbsp;¡Bien! ¡Tu cuenta se encuentra verificada!
</div>
@else
<div class="alert alert-dark my-4">
  <i class="fas fa-exclamation-triangle"></i>&nbsp;Debes verificar tu cuenta para poder comenzar a participar
</div>
<p>Para poder verificar tu cuenta, hace <a href="{{route('verification.notice')}}">clic aquí</a></p>
@endif
</section>

@endsection