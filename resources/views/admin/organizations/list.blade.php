@extends('admin.master')

@section('adminContent')

<section>
  <h1 class="">Organizaciones</h1>
  <p>Lorem ipsum dolor sit amet consectetur, adipisicing elit. In eius ad officia tempora, temporibus repudiandae id
    ipsum neque deserunt rerum esse delectus consectetur voluptates eveniet quaerat commodi ducimus mollitia dolorem.
  </p>
  @forelse($organizations as $organization)
  <div class="card mb-3 shadow-sm">
    <div class="card-body d-flex">
        <div class="mr-4">
          @if($organization->logo)
          <img src="{{ asset($organization->logo->path) }}" class="mt-1 rounded" width="100" alt="" title="" />
          @else
          <img src="{{ asset('img/default-background.png') }}" class="mt-1 rounded" width="100" alt="" title="" />
          @endif
        </div>
        <div>
          <h4 class="card-title font-weight-bold">{{ $organization->name }}</h4>
          <p class="text-card text-smaller text-muted">{{ $organization->description }}</p>
          <a href="{{ route('admin.organizations.edit', ['id' => $organization->id]) }}" class="card-link"><i class="fas fa-pencil-alt"></i> Editar</a>
        </div>
    </div>
  </div>
  @empty
  <div class="card mb-3 shadow-sm">
    <div class="card-body">
        <div>
          <h6 class="card-title">No hay organizaciones cargadas</h4>
          <a href="{{ route('admin.organizations.create') }}" class="card-link"><b>Haga clic para crear una nueva organización <i class="fas fa-arrow-right"></i></b></a>
        </div>
    </div>
  </div>
  @endforelse
  {{ $organizations->links() }}

</section>

@endsection
