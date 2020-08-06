@extends('admin.master')

@section('adminContent')

<section>
  <h1 class="">Crear categoria</h1>
  <p>Para crear una nueva categoría, completá los campos a continuación:</p>
  <hr>
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
      <label>Nombre</label>
      <input type="text" class="form-control" name="title" placeholder="Ingrese un nombre">
    </div>
    <div class="form-group">
      <label>Icono</label>
      {{-- <input type="text" class="form-control" name="icon" placeholder="Ingrese un icono"> --}}
      <input-icon name="icon"></input-icon>
    </div>
    <div class="form-group">
      <label>Color</label>
      <input type="color" class="form-control" name="color" placeholder="Ingrese un color en formato HEX">
      {{-- <small id="emailHelp" class="form-text text-muted">No ingrese el color con el "#"</small> --}}
    </div>
    <div class="text-right">
    <button type="submit" class="btn btn-primary"><i class="fas fa-plus"></i> Crear</button>
    </div>
  </form>
</section>

@endsection