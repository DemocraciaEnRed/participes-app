@extends('objective.manage.master')

@section('panelContent')

<section>
  <div class="{{ !$objective->cover ?: 'has-background-image rounded'}}" style="{{!$objective->cover ?: 'background-image: url('.asset($objective->cover->thumbnail_path).')'}}">
    <div class="jumbotron rounded">
      <h2 class="is-300 {{ !$objective->cover ?: 'text-white'}}">{{$objective->title}}</h2>
      <p class="lead {{ !$objective->cover ?: 'text-white'}}">¡Bienvenido al panel de control del objetivo!</p>
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