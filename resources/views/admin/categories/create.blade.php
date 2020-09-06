@extends('admin.master')

@section('adminContent')

<section>
  <h3 class="is-700">Crear categoria</h3>
  <p class="lead">Para crear una nueva categoría, completá los campos a continuación:</p>
  @if ($errors->any())
    <div class="alert alert-danger">
        <ul class="mb-0">
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
  @endif
  <form method="POST" action="{{ route('admin.categories.create.form') }}">
    @csrf
    <div class="form-group">
      <label><b>Título</b></label>
      <input type="text" class="form-control" name="title" placeholder="Ingrese aquí" maxlength="255" >
      <small class="form-text text-muted">Hasta 225 caracteres</small>
    </div>
    <div class="form-group">
      <label><b>Ícono</b></label>
      <input-icon name="icon"></input-icon>
    </div>
    <div class="form-group">
      <label><b>Color del ícono</b></label>
      <input type="color" class="form-control" name="color">
    </div>
    <div class="text-right">
    <button type="submit" class="btn btn-primary"><i class="fas fa-plus"></i> Crear</button>
    </div>
  </form>
</section>

@endsection