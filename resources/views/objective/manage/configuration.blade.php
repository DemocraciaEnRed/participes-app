

@extends('objective.manage.master')

@section('panelContent')

<section>
  <h1 class="">Configuración</h1>
  <p>A continuación, encontrarás opciones para configurar la visibilidad del objetivo</p>
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
  <h5 class="font-weight-bold"><i class="far fa-eye"></i> Ocultar objetivo</h5>
  <p>Al ocultar el objetivo, ocurre lo siguiente</p>
  <ul>
    <li>El objetivo deja de ser visible publicamente</li>
    <li>Administradores y miembros del equipo pueden acceder al panel de control del objetivo</li>
    <li>Coordinadores pueden volver a hacer visible el objetivo</li>
    <li>Miembros del equipo pueden crear reportes, pero los suscriptores no serán notificados</li>
    <li>Coordinadores pueden seguir creando metas.</li>
  </ul>
  <form action="{{ route('objective.manage.configuration.form',['objId' => $objective->id]) }}" method="POST">
    @method('PUT')
    @csrf
    <div class="form-group">
      <div class="custom-control custom-switch">
        <input type="checkbox" class="custom-control-input" name="hidden" id="mailable" {{$objective->hidden ? 'checked' : ''}} value="true">
        <label class="custom-control-label is-clickable" for="mailable">Ocultar objetivo</label>
      </div>
    </div>
    <button type="submit" class="btn btn-primary">Guardar</button>
  </form>
</section>

@endsection
