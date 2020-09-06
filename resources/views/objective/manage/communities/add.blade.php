@extends('objective.manage.master')

@section('panelContent')

<section>
  <h3 class="is-700">Agregar comunidades</h3>
  <p class="lead">A continuación, podrás agregar nuevas comunidades que en el fondo son links externos</p>
  @if ($errors->any())
    <div class="alert alert-danger">
      <ul class="mb-0">
        @foreach ($errors->all() as $error)
          <li>{{ $error }}</li>
        @endforeach
      </ul>
    </div>
  @endif
  <form method="POST" action="{{ route('objectives.manage.communities.add.form', ['objectiveId' => $objective->id]) }}" >
    @csrf
    <div class="form-group">
      <label><b>Etiqueta de la comunidad</b></label>
      <input type="text" class="form-control" name="label" placeholder="Escriba aquí" maxlength="225">
      <small class="form-text text-muted">Hasta 225 caracteres</small>
    </div>
    <div class="form-group">
      <label><b>URL a la comunidad</b></label>
      <input type="text" class="form-control" name="url" placeholder="Copie el link aquí" maxlength="550">
      <small class="form-text text-muted">Hasta 550 caracteres</small>
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