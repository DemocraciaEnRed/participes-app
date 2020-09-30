@extends('admin.master')

@section('adminContent')

<section>
  <h3 class="is-700">Organizaciones</h3>
  <p class="lead">En esta sección se podrán cargar organizaciones de la sociedad civil, agrupaciones conformadas por ciudadanos independientes, o bien, cualquier sector que pueda estar asociado a un objetivo.</p>
  @forelse($organizations as $organization)
  <div class="card mb-3 shadow-sm">
    <div class="card-body d-flex align-items-start">
        <div class="mr-4">
          @if($organization->logo)
          <img src="{{ asset($organization->logo->path) }}" class="rounded" width="75" alt="Logo {{$organization->name}}" title="{{$organization->name}}" />
          @else
          <img src="{{ asset('img/default-background.png') }}" class="rounded" width="75" alt="Logo {{$organization->name}}" title="{{$organization->name}}" />
          @endif
        </div>
        <div class="w-100">
          <h4 class="is-700">{{ $organization->name }}</h4>
          <span class="text-smaller text-muted">{{ $organization->description }}</span>
          <div class="text-right">
          </div>
        </div>
        <div class="text-right">
          <a href="{{ route('admin.organizations.edit', ['organizationId' => $organization->id]) }}" class="btn btn-link btn-sm"><i class="fas fa-pencil-alt fa-fw"></i>Editar</a>
          <a href="{{ route('admin.organizations.delete', ['organizationId' => $organization->id]) }}" class="btn btn-link btn-sm"><i class="fas fa-trash fa-fw"></i>Eliminar</a>
        </div>
    </div>
  </div>
  @empty
  <div class="card my-3 shadow-sm">
      <div class="card-body text-center">
        <h6>No hay organizaciones creadas</h6>
      </div>
    </div>
  @endforelse
  {{ $organizations->links() }}

</section>

@endsection
