@extends('objective.manage.master')

@section('panelContent')

<section>
  <h3 class="is-700">Comunidades</h3>
  <p class="lead">Las comunidades de los objetivos son puntos de acceso para que los ciudadanos puedan interactuar en otros. Estos son los "Botones" para invitar a ser parte de la comunidad</p>
  @forelse ($communities as $community)
  <div class="card my-3 shadow-sm">
    <div class="card-body d-flex align-items-center">
      <div class="w-100">
        <a href="{{$community->url}}" target="_blank" class="py-1 px-3 rounded d-inline-block" style="border: 2px solid {{$community->color}}; color: {{$community->color}}"><i class="{{$community->icon}}"></i>&nbsp;{{$community->label}}</a>
      </div>
      <div class="text-right">
        <a href="#" onclick="event.preventDefault();document.getElementById('delete-community-{{$community->id}}').submit();" class="btn btn-link btn-sm"><i class="fas fa-trash-alt fa-fw"></i>Eliminar</a>
        <form id="delete-community-{{$community->id}}" action="{{ route('objectives.manage.communities.remove.form',['objectiveId' => $objective->id, 'communityId' => $community->id]) }}" method="POST" style="display: none;">
            @method('DELETE')
            @csrf
        </form>
      </div>
    </div>
  </div>
  @empty
  <div class="card shadow-sm my-3">
    <div class="card-body text-center">
      <i class="far fa-surprise"></i>&nbsp;¡No hay comunidades del objetivo!
    </div>
  </div>
  @endforelse

   <a href="{{ route('objectives.manage.communities.add', ['objectiveId' => $objective->id]) }}" class="btn btn-block btn-primary">Crear una nueva comunidad <i class="fas fa-plus"></i></a>
  
</section>

@endsection
