@extends('admin.master')

@section('adminContent')

<section>
  <h1 class="">Crear objetivo</h1>
  <p>Para crear un nuevo objetivo, completá los campos a continuación:</p>
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
  @if (count($categories) > 0)
  <form method="POST" action="{{ route('admin.objectives.create.form') }}">
    @csrf
    <div class="form-group">
      <label>Titulo del objetivo</label>
      <input type="text" class="form-control" name="title" placeholder="Ingrese un nombre">
    </div>
    <div class="form-group">
      <label>Descripción del objetivo</label>
      <textarea name="content" class="form-control" rows="4"></textarea>
    </div>
    <div class="form-group">
      <label>Categoria del objetivo</label>
      <select class="custom-select" name="category">
        @foreach ($categories as $category)
        <option value="{{$category->id}}">{{$category->title}}</option>
        @endforeach
      </select>
    </div>
    <div class="form-group">
      <label>Tags</label>
      <input-tags name="tags"></input-tags>
    </div>
    <div class="form-group">
      <label>Organizaciones relacionadas con el objetivo</label>
      <div>
        @foreach($organizations as $organization)
          <div class="custom-control custom-checkbox form-check-inline">
            <input class="custom-control-input" type="checkbox" name="organizations[]" id="org{{$organization->id}}" :value="{{$organization->id}}">
            <label class="custom-control-label" for="org{{$organization->id}}">{{$organization->name}}</label>
          </div>
        @endforeach
      </div>
    </div>
    <div class="alert alert-light">
      Luego de hacer clic en el boton <b>Crear</b>, sera redireccionado al panel de control del objetivo.<br>
      Recuerde: El objetivo se va a crear como <u>oculto</u>.
    </div>
    <button type="submit" class="btn btn-primary">Crear</button>
  </form>
  @else
  <div class="alert alert-warning" role="alert">
    No puede crear objetivos sin categorias. Debe ir al panel de <a href="{{ route('admin.categories') }}">Categorias</a>
  </div>
  @endif
</section>

@endsection