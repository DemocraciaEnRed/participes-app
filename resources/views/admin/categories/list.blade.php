@extends('admin.master')

@section('adminContent')

<section>
  <h3 class="is-700">Categorías</h3>
  <p class="lead">A continuación encontrarán las categorías dentro de las cuales se agruparán los objetivos:</p>
  @forelse($categories as $category)
  <div class="card mb-3 shadow-sm">
    <div class="card-body d-flex align-items-center">
      <div class="mr-3 category-icon-container" style="background-color: {{$category->background_color}}">
        <i class="fa-2x fa-fw {{$category->icon}}" style="color: {{$category->color}}"></i>
      </div>
        <div class="w-100">
          <h5 class="m-0" style="color: {{$category->color}}">{{$category->title}}</h5>
        </div>
        <div class="text-right">
          <a href="{{ route('admin.categories.edit', ['categoryId' => $category->id]) }}" class="btn btn-link btn-sm"><i class="fas fa-pencil-alt fa-fw"></i>Editar</a>
          <a href="{{ route('admin.categories.delete', ['categoryId' => $category->id]) }}" class="btn btn-link btn-sm"><i class="fas fa-trash-alt fa-fw"></i>Eliminar</a>
        </div>
    </div>
  </div>
  @empty
  <div class="card mb-3 shadow-sm">
    <div class="card-body">
      <div>
        <h6 class="card-title">No hay categorías cargadas</h4>
        <a href="{{ route('admin.categories.create') }}" class="card-link"><b>Haga clic para crear una nueva categoria <i class="fas fa-arrow-right"></i></b></a>
      </div>
    </div>
  </div>
  @endforelse
</section>

@endsection
