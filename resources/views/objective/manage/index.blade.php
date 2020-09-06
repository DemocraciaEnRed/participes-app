@extends('objective.manage.master')

@section('panelContent')

<section>
  <div class="d-flex align-items-start mb-3">
    <div class="mr-3 category-icon-container" style="background-color: {{$objective->category->background_color}}">
      <i class="fa-2x fa-fw {{$objective->category->icon}}" style="color: {{$objective->category->color}}"></i>
    </div>
    <div class="w-100">
      <span class="" style="color:{{$objective->category->color}}">{{$objective->category->title}}</span>
      <h3 class="is-600">{{$objective->title}}</h3>
      <p class="lead">¡Bienvenido al panel de control del objetivo!</p>
    </div>
  </div>
  <div class="card border-light mb-3">
    <div class="card-body py-4">
      <portal-objective-stats fetch-url="{{route('apiService.objectives.stats',['objectiveId' => $objective->id])}}">
        @include('partials.loading')
      </portal-objective-stats>
    </div>
  </div>
  @if($objective->hidden)
  <div class="alert alert-dark">
    <i class="fas fa-eye-slash"></i> El objetivo se encuentra <b>oculto</b> al público. <a href="{{route('objectives.manage.configuration', ['objectiveId' => $objective->id]) }}">Cambiar<i class="fas fa-arrow-right fa-fw"></i></a>
  </div>
  @endempty
  @if($objective->goals->isEmpty())
  <div class="card border-secondary my-2">
    <div class="card-body">
      <h6><b><i class="fas fa-exclamation-triangle"></i> ¡El objetivo no cuenta con metas!</b></h6>
      <span class="text-muted">Debe comenzar creando las metas para el objetivo para que luego se puedan crear reportes a futuro.</span>
    </div>
  </div>
  @endempty
  @if($objective->members->isEmpty())
  <div class="card border-secondary my-2">
    <div class="card-body">
      <h6><b><i class="fas fa-exclamation-triangle"></i> ¡El objetivo no cuenta con miembros en el equipo!</b></h6>
      <span class="text-muted">Por lo tanto, solamente usuarios administradores de la plataforma pueden gestionar el objetivo, sus metas, o reportes. Para que otros usuarios puedan administrar el objetivo, debe asignar usuarios para que <b>coordinen</b> el objetivo o para que <b>reporten</b> sobre las metas del objetivo</span>
    </div>
  </div>
  @endempty
</section>

@endsection