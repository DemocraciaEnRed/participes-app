@extends('objective.manage.master')

@section('panelContent')

<section>
  <div class="jumbotron d-flex">
    {{-- <div class="mr-4">
      @include('utils.avatar',['avatar' => Auth::user()->avatar, 'size' => 125])
    </div> --}}
    <div class="">
      <h6 class="display-4">{{$objective->title}}</h6>
      <p class="lead">¡Bienvenido al panel de control del objetivo!</p>
    </div>
  </div>
  @if($objective->hidden)
  <div class="alert alert-dark">
    <i class="fas fa-eye-slash"></i> El objetivo se encuentra <u>oculto</u> al publico
  </div>
  @endempty
  @if(count($objective->members) === 0)
  <div class="alert alert-danger">
    <h5><i class="fas fa-exclamation-triangle"></i> ¡El objetivo no cuenta con miembros en el equipo!</h5>
    Solamente usuarios administradores de la plataforma pueden editar el objetivo.<br> Para que otros usuarios puedan administrar el objetivo, debe asignar usuarios para que <u>coordinen</u> el objetivo o para que <u>reporten</u> al objetivo
  </div>
  @endempty
  @if(count($objective->goals) === 0)
  <div class="alert alert-danger">
    <h5><i class="fas fa-exclamation-triangle"></i> ¡El objetivo no cuenta con metas!</h5>
    Debe comenzar creando las metas del objetivo.
  </div>
  @endempty
</section>

@endsection