@extends('admin.master')

@section('adminContent')

<section>
  <h1 class="">Categorias</h1>
  <p>Lorem ipsum dolor sit amet consectetur, adipisicing elit. In eius ad officia tempora, temporibus repudiandae id
    ipsum neque deserunt rerum esse delectus consectetur voluptates eveniet quaerat commodi ducimus mollitia dolorem.
  </p>
  <hr>
  <table class="table table-sm">
    <thead class="thead-dark">
      <tr>
        <th scope="col">Nombre</th>
        <th class="text-center" scope="col">Icono</th>
        <th class="text-center" scope="col">Color</th>
        <th class="text-center" scope="col">Accion</th>
      </tr>
    </thead>
    <tbody>
      @if(count($categories) > 0)
        @foreach($categories as $category)
          <tr>
            <td>{{ $category->title }}</td>
            <td class="text-center">{{ $category->icon }}</td>
            <td class="text-center">{{ $category->color }}</td>
            <td class="text-center">
              <div class="btn-group btn-group-sm" role="group">
                <a href="{{ route('admin.categories.edit', ['id' => $category->id]) }}"
                  type="button" class="btn btn-primary">Editar</a>
              </div>
            </td>
          </tr>
        @endforeach
      @else
        <tr>
          <td colspan="4">No hay categorias</td>
        </tr>
      @endif
    </tbody>
  </table>
</section>

@endsection
