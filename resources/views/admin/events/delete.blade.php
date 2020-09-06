@extends('admin.master')

@section('adminContent')

<section>
  <h3 class="is-700">Eliminar evento</h3>
  <h5 class="text-muted is-700">{{$event->title}}</h5>
  @if ($errors->any())
    <div class="alert alert-danger">
        <ul class="mb-0">
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
  @endif
  <form action="{{ route('admin.events.delete.form',['eventId' => $event->id]) }}" method="POST">
    @method('DELETE')
    @csrf
    <p>Al eliminar el evento, tenga en cuenta lo siguiente</p>
    <ul>
      <li>Dejará de ser accesible, haciendo que todos los links que se hayan compartido, se pierdan.</li>
      <li>Se eliminarán todas las imagenes cargadas</li>
      <li>No se podrá recuperar, debera crear otro.</li>
    </ul>
    <div class="form-group">
      <label><b>Ingrese su contraseña</b><span class="text-danger">*</span></label>
      <input type="password" class="form-control" name="password">
      <small class="form-text text-muted">Para poder eliminar el evento, ingrese su contraseña para confirmar.</small>
    </div>
    <div class="form-group">
     <label class="is-700 "><i class="fas fa-bell"></i>&nbsp;Enviar notificación a suscriptores <span class="text-danger">*</span></label>
      <p>¿Desea enviar una notificacion de la eliminación del evento a los suscriptores de los objetivos relacionados con el evento?</p>
      <div class="custom-control custom-switch">
        <input type="checkbox" class="custom-control-input" name="notify" id="notify" value="true">
        <label class="custom-control-label is-clickable" for="notify">Notificar a los suscriptores</label>
      </div>
      <small class="form-text text-muted">Se le enviará una notificación por email (si lo tienen habilitado) y por sistema, de que el evento ha sido eliminado.</small>
    </div>
    <button type="submit" class="btn btn-danger">Eliminar</button>
  </form>
</section>

@endsection