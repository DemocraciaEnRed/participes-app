@extends('admin.master')

@section('adminContent')

<section>
  <h3 class="is-700">Editar evento</h3>
  <p class="lead">Para crear un evento complete los siguientes campos:</p>
  @if ($errors->any())
    <div class="alert alert-danger">
        <ul class="mb-0">
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
  @endif
  <hr>
  <h5 class="is-700 has-text-danger"><i class="fas fa-plus"></i> <i class="far fa-image"></i> Agregar foto reporte</h5>
  <p>Debe ser una imagen JPG o JPEG , hasta 8 MB. Si el ancho de la imagen es mayor a 1366px, sera ajustada a estetamaño.</p>  
    <form action="{{route('admin.events.pictures.add',['eventId' => $event->id])}}" method="POST" enctype="multipart/form-data">
      @csrf
      <input-file name="photo" accept="image/*"></input-file>
      <div class="form-group">
        <button class="btn btn-primary btn-sm" type="submit"><i class="fas fa-upload"></i> Subir imagen</button>
      </div>
    </form>
  <hr>
  <h5 class="is-700 has-text-danger mb-3"><i class="far fa-images"></i> Fotos del evento</h5>
  @forelse($event->photos as $photo)
  <div class="d-inline-block mr-2 my-1">
    <a href="{{asset($photo->path)}}" target="_blank"><img src="{{asset($photo->thumbnail_path)}}" height="80" class="img rounded mb-1 align-top" alt=""></a> 
    <a class="is-clickable text-danger" onclick="event.preventDefault();document.getElementById('delete-photo-{{$photo->id}}').submit();"><i class="fas fa-times fa-lg fa-fw"></i></a>
    <form id="delete-photo-{{$photo->id}}" action="{{route('admin.events.pictures.delete',['eventId' => $event->id, 'pictureId' => $photo->id]) }}" method="POST" style="display: none;">
        @method('DELETE')
        @csrf
    </form>
  </div>
  @empty
  <p class="text-muted">No hay fotos cargadas en el evento</p>
  @endforelse
  <hr>
  <h5 class="is-700 has-text-danger"><i class="fas fa-edit"></i> Editar información</h5>
  <form method="POST" action="{{ route('admin.events.edit.form',['eventId' => $event->id]) }}" >
    @method('PUT')
    @csrf
    <div class="form-group">
      <label><b>Título del evento</b><span class="text-danger">*</span></label>
      <input type="text" class="form-control" name="title" value="{{$event->title}}" placeholder="Ingrese aquí...">
      <small class="form-text text-muted">Hasta 550 caracteres.</small>
    </div>
    <div class="form-group">
      <label><b>Descripción del evento</b><span class="text-danger">*</span></label>
      <textarea name="content" class="form-control" rows="4" placeholder="Ingrese aquí...">{{$event->content}}</textarea>
    </div>
    <div class="form-group">
      <div class="form-row">
        <div class="col-sm-4">
          <label><b>Dia del evento</b><span class="text-danger">*</span></label>
          <div class="input-group">
            <div class="input-group-prepend">
              <span class="input-group-text">Dia</span>
            </div>
            <input name="date" type="date" value="@dateInputFormat($event->date)" class="form-control" />
          </div>
        </div>
        <div class="col-sm-4">
          <label><b>Hora</b><span class="text-danger">*</span></label>
          <div class="input-group">
            <select name="hour" class="custom-select">
              @for ($i = 0; $i < 24; $i++)
              <option value="{{$i}}" {{$i == $event->date->format('H') ? 'selected' : null}}>{{$i}}</option>
              @endfor
            </select>
            <div class="input-group-append">
              <span class="input-group-text">Hr</span>
            </div>
          </div>
        </div>
        <div class="col-sm-4">
          <label><b>Minutos</b><span class="text-danger">*</span></label>
          <div class="input-group">
            <select name="minute" class="custom-select">
              @for ($i = 0; $i < 60; $i += 5)
              <option value="{{$i}}" {{$i == $event->date->format('i') ? 'selected' : null}}>{{$i}}</option>
              @endfor
            </select>
            <div class="input-group-append">
              <span class="input-group-text">Min</span>
            </div>
          </div>
        </div>
    </div>
      <small class="form-text text-muted">Fecha en que ocurre el reporte. Elija el dia, la hora y minuto del mismo</small>
    </div>
    <div class="form-group">
      <label><b>Dirección</b><span class="text-danger">*</span></label>
      <input type="text" class="form-control" name="address" placeholder="Ingrese aquí..." value="{{$event->address}}">
      <small class="form-text text-muted">Hasta 550 caracteres.</small>
    </div>
     <div class="form-group">
      <label><b>Links asociados</b>&nbsp;<span class="text-smallest text-info">(Opcional)</span></label>
      <input-urls name="urls" :urls='@json($event->urls)'></input-urls>
    </div>
    <div class="form-group">
      <label><b>Objetivos relacionados</b>&nbsp;<span class="text-smallest text-info">(Opcional)</span></label>
      <div>
        @foreach($objectives as $objective)
          <div class="custom-control custom-checkbox form-check-inline">
            <input class="custom-control-input" type="checkbox" name="objectives[]" id="obj{{$objective->id}}" :value="{{$objective->id}}" {{$event->hasObjective($objective->id) ? 'checked' : null }} {{$objective->hidden == true ? 'disabled' : null}}>
            <label class="custom-control-label" for="obj{{$objective->id}}">{{$objective->title}}@if($objective->hidden)&nbsp;<span class="text-smallest text-info">(Oculto)</span>@endif</label>
          </div>
        @endforeach
      </div>
    </div>
    <div class="border border-light rounded p-3">
      <label class="is-700 "><i class="fas fa-paper-plane"></i>&nbsp;Enviar notificacion a suscriptores</label>
      <div class="custom-control custom-switch">
        <input type="checkbox" class="custom-control-input" name="notify" id="notify" value="true">
        <label class="custom-control-label is-clickable" for="notify">Notificar a los suscriptores</label>
      </div>
      <small class="form-text text-muted">Se le enviará una notificación por email (si lo tienen habilitado) y por sistema a los suscriptores de los objetivos seleccionados, de la edicion de los datos del evento invitandolos a verlo.</small>
    </div>
    <br>
    <button type="submit" class="btn btn-primary">Editar</button>
  </form>
</section>

@endsection