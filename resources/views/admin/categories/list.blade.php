@extends('admin.master')

@section('adminContent')

<section>
  <h1 class="">Categorias</h1>
  <p>A continuación encontrarán las categorías dentro de las cuales se agruparán los objetivos:</p>
  @forelse($categories as $category)
  <div class="card mb-3 shadow-sm">
    <div class="card-body d-flex justify-content-between">
        <div>
          <h4 class="card-title font-weight-bold">{{$category->title}}</h4>
          <a href="#" class="card-link"><i class="fas fa-pencil-alt"></i> Editar</a>
          <a href="#" class="card-link text-danger"><i class="fas fa-trash"></i> Eliminar</a>
        </div>
        <div class="ml-3">
          <i class="{{$category->icon}} fa-3x fa-fw mt-1" style="color:{{$category->color}}"></i>
        </div>
    </div>
  </div>
  @empty
  <div class="card mb-3 shadow-sm">
    <div class="card-body">
        <div>
          <h6 class="card-title">No hay categorias cargadas</h4>
          <a href="{{ route('admin.categories.create') }}" class="card-link"><b>Haga clic para crear una nueva categoria <i class="fas fa-arrow-right"></i></b></a>
        </div>
    </div>
  </div>
  @endforelse
</section>

@endsection
