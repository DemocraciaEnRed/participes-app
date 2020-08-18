@extends('objective.manage.master')

@section('panelContent')

<section>
  <h3 class="is-700">Equipo</h3>
  <p class="lead">El equipo de un objetivo está conformado por los usuarios que podrán coordinar objetivos y realizar reportes y usuarios que únicamente podrán realizar reportes.
  </p>
  @if(!$objective->members->isEmpty())
    @foreach($objective->members as $member)
    <div class="card my-3 shadow-sm">
      <div class="card-body d-flex align-items-start">
        <div class="mr-3 text-center">
         @include('utils.avatar',['avatar' => $member->avatar, 'size' => 48, 'thumbnail' => true])
        </div>
        <div class="w-100">
          <h5 class="my-1 is-600">{{$member->surname}}, {{$member->name}}</h5>
          <p class="my-1 text-smaller text-muted">Rol: {{$member->pivot->role == 'manager' ? 'Coordina' : 'Reporta'}}</p>
          <div class="mt-2" role="group">
            <form id="remove{{$member->id}}" action="{{ route('objectives.manage.team.remove.form', ['objectiveId' => $objective->id, 'usrId' => $member->id]) }}" method="POST">
              @csrf
              @method('DELETE')
            </form>
            <button type="submit" form="remove{{$member->id}}" class="btn btn-outline-danger btn-sm">
              <i class="fas fa-times"></i>&nbsp;Quitar del equipo
            </button>
          </div>
        </div>
      </div>
    </div>
    @endforeach
  @else
  <div class="card shadow-sm my-3">
      <div class="card-body text-center">
        <h6 class="m-0"><i class="far fa-surprise"></i>&nbsp;¡No se encontraron miembros del equipo!</h6>
      </div>
    </div>
  @endif
</section>

@endsection
