@extends('admin.master')

@section('adminContent')

<section>
  <h1 class="">Crear organizacion</h1>
  <p>Para crear una organización, una agrupación conformada por ciudadanos independientes o bien algún sector encargado de un objetivo, completa los siguientes campos:</p>
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
  <form method="POST" action="{{ route('admin.organizations.create.form') }}" enctype="multipart/form-data">
    @csrf
    <div class="form-group">
      <label>Nombre</label>
      <input type="text" class="form-control" name="name" placeholder="Ingrese un nombre">
    </div>
    <div class="form-group">
      <label>Descripción</label>
      <textarea name="description" class="form-control" rows="4"></textarea>
    </div>
    <div class="form-group">
      <label>Logo</label>
      <input type="file" class="form-control-file" name="logo">
      <small id="emailHelp" class="form-text text-muted">Se recomienda que no exceda 2MB y que sea PNG con fondo transparente.</small>
    </div>
    <button type="submit" class="btn btn-primary">Submit</button>
  </form>
</section>

@endsection