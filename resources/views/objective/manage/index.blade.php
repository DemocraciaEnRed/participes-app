@extends('objective.manage.master')

@section('panelContent')

<section>
  <div class="{{ !$objective->cover ?: 'has-background-image rounded'}}" style="{{!$objective->cover ?: 'background-image: url('.asset($objective->cover->thumbnail_path).')'}}">
  <div class="d-flex align-items-start mb-3">
    <div class="mr-3 category-icon-container" style="background-color: {{$objective->category->background_color}}">
      <i class="fa-2x fa-fw {{$objective->category->icon}}" style="color: {{$objective->category->color}}"></i>
    </div>
    <div class="w-100">
      <span class="" style="color:{{$objective->category->color}}">{{$objective->category->title}}</span>
      <h3 class="is-600 {{ !$objective->cover ?: 'text-white'}}">{{$objective->title}}</h3>
      <p class="lead {{ !$objective->cover ?: 'text-white'}}">¡Bienvenido al panel de control del objetivo!</p>
    </div>
  </div>
  <div class="card border-light mb-3">
    <div class="card-body py-4">
      <portal-objective-stats fetch-url="{{route('apiService.objectives.stats',['objectiveId' => $objective->id])}}">
        @include('partials.loading')
      </portal-objective-stats>
    </div>
  </div>
  </div>
  @if($objective->hidden)
  <div class="alert alert-dark">
    <i class="fas fa-eye-slash"></i> El objetivo se encuentra <u>oculto</u> al publico
  </div>
  @endempty
  @if($objective->members->isEmpty())
  <div class="alert alert-danger">
    <h5 class="is-600"><i class="fas fa-exclamation-triangle"></i> ¡El objetivo no cuenta con miembros en el equipo!</h5>
    Solamente usuarios administradores de la plataforma pueden editar el objetivo.<br> Para que otros usuarios puedan administrar el objetivo, debe asignar usuarios para que <u>coordinen</u> el objetivo o para que <u>reporten</u> al objetivo
  </div>
  @endempty
  @if($objective->goals->isEmpty())
  <div class="alert alert-danger">
    <h5><i class="fas fa-exclamation-triangle"></i> ¡El objetivo no cuenta con metas!</h5>
    Debe comenzar creando las metas para el objetivo.
  </div>
  @endempty
</section>

@endsection