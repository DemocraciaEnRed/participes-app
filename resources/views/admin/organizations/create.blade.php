@extends('admin.master')

@section('adminContent')

<section>
  <h1 class="">Crear organizacion</h1>
  <p>Lorem ipsum dolor sit amet consectetur, adipisicing elit. In eius ad officia tempora, temporibus repudiandae id ipsum neque deserunt rerum esse delectus consectetur voluptates eveniet quaerat commodi ducimus mollitia dolorem.</p>
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