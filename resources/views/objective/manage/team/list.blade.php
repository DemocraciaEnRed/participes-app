@extends('objective.manage.master')

@section('panelContent')

<section>
  <h3 class="is-700">Ver miembros del equipo</h3>
  <p class="lead">El equipo de un objetivo está conformado por los usuarios que podrán coordinar objetivos y realizar reportes y usuarios que únicamente podrán realizar reportes.
  </p>
  @if(!$objective->members->isEmpty())
    @isManager($objective->id)
    <a href="{{ route('objectives.manage.team.add', ['objectiveId' => $objective->id]) }}" class="btn btn-block btn-primary"><i class="fas fa-plus"></i> Agregar</a>
    @endisManager
    @foreach($objective->members as $member)
    <div class="card my-3 shadow-sm">
      <div class="card-body d-flex align-items-start">
        <div class="mr-3 text-center">
         @include('utils.avatar',['avatar' => $member->avatar, 'size' => 48, 'thumbnail' => true])
        </div>
        <div class="w-100">
          <h5 class="my-1 is-600">{{$member->surname}}, {{$member->name}}</h5>
          <span class="text-smaller text-muted">Rol: {{$member->pivot->role == 'manager' ? 'Coordina' : 'Reporta'}}</span>
        </div>
        @isManager($objective->id)
        <div class="text-right" role="group">
          <form id="remove{{$member->id}}" action="{{ route('objectives.manage.team.remove.form', ['objectiveId' => $objective->id, 'usrId' => $member->id]) }}" method="POST">
            @csrf
            @method('DELETE')
        <button type="submit" form="remove{{$member->id}}" class="btn btn-link btn-sm">
          <i class="fas fa-times"></i> Quitar
        </button>
          </form>
        </div>
        @endisManager
      </div>
    </div>
    @endforeach
  @else
  <div class="card shadow-sm my-3">
      <div class="card-body text-center">
        <i class="far fa-surprise"></i>&nbsp;¡No se encontraron miembros del equipo!
      </div>
    </div>
  @endif
</section>

@endsection
