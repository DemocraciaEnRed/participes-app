@extends('admin.master')

@section('adminContent')

<section>
<h3 class="is-700">Editar categoria</h3>
  <p class="lead">Para editar la categoría, completá los campos a continuación:</p>
@if ($errors->any())
    <div class="alert alert-danger">
        <ul class="mb-0">
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
  @endif
  <form method="POST" action="{{ route('admin.categories.edit.form', ['categoryId' => $category->id]) }}">
    @method('PUT')
    @csrf
    <div class="form-group">
      <label><b>Título</b></label>
      <input type="text" class="form-control" name="title" placeholder="Ingrese aquí" maxlength="255" value="{{$category->title}}">
      <small class="form-text text-muted">Hasta 225 caracteres</small>
    </div>
    <div class="form-group">
      <label><b>Ícono</b></label>
      <input-icon name="icon" value="{{$category->icon}}"></input-icon>
    </div>
    <div class="form-group">
      <label><b>Color del ícono</b></label>
      <input type="color" class="form-control" name="color" value="{{$category->color}}">
    </div>
    <button type="submit" class="btn btn-primary">Editar</button>
  </form>

</section>

@endsection