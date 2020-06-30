@extends('admin.master')

@section('adminContent')

<section>
  <h1 class="">Crear categoria</h1>
  <p>Lorem ipsum dolor sit amet consectetur, adipisicing elit. In eius ad officia tempora, temporibus repudiandae id ipsum neque deserunt rerum esse delectus consectetur voluptates eveniet quaerat commodi ducimus mollitia dolorem.</p>
  <hr>
  @if ($errors->any())
    <div class="alert alert-danger">
        <ul>
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
  @endif
  <form method="POST" action="{{ route('admin.categories.create.form') }}">
    @csrf
    <div class="form-group">
      <label for="exampleInputEmail1">Nombre</label>
      <input type="text" class="form-control" name="title" placeholder="Ingrese un nombre">
    </div>
    <div class="form-group">
      <label for="exampleInputEmail1">Icono</label>
      <input type="text" class="form-control" name="icon" placeholder="Ingrese un icono">
    </div>
    <div class="form-group">
      <label for="exampleInputEmail1">Color</label>
      <input type="text" class="form-control" name="color" placeholder="Ingrese un color en formato HEX">
      <small id="emailHelp" class="form-text text-muted">No ingrese el color con el "#"</small>
    </div>
    <button type="submit" class="btn btn-primary">Submit</button>
  </form>
</section>

@endsection