@extends('admin.master')

@section('adminContent')

<section>
  <h3 class="is-700">Crear evento</h3>
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
  <form method="POST" action="{{ route('admin.events.create.form') }}" enctype="multipart/form-data">
    @csrf
    <div class="form-group">
      <label>Título del evento</label>
      <input type="text" class="form-control" name="title" value="{{old('title')}}" placeholder="Ingrese aquí..." maxlength="550">
      <small class="form-text text-muted">Hasta 550 caracteres.</small>
    </div>
    <div class="form-group">
      <label>Descripción del evento</label>
      <textarea name="content" class="form-control" rows="4" placeholder="Ingrese aquí...">{{old('content')}}</textarea>
    </div>
    <div class="form-group">
      <div class="form-row">
        <div class="col-sm-4">
          <label>Dia del evento</label>
          <div class="input-group">
            <div class="input-group-prepend">
              <span class="input-group-text">Dia</span>
            </div>
            <input name="date" type="date" class="form-control" />
          </div>
        </div>
        <div class="col-sm-4">
          <label>Hora</label>
          <div class="input-group">
            <select name="hour"  class="custom-select">
              @for ($i = 0; $i < 24; $i++)
              <option value="{{$i}}">{{$i}}</option>
              @endfor
            </select>
            <div class="input-group-append">
              <span class="input-group-text">Hr</span>
            </div>
          </div>
        </div>
        <div class="col-sm-4">
          <label>Minutos</label>
          <div class="input-group">
            <select name="minute" class="custom-select">
              @for ($i = 0; $i < 60; $i += 5)
              <option value="{{$i}}">{{$i}}</option>
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
      <label>Dirección</label>
      <input type="text" class="form-control" name="address" placeholder="Ingrese aquí...">
    </div>
     <div class="form-group">
      <label>Links asociados</label>
      <input-urls name="urls"></input-urls>
    </div>
    <div class="form-group">
				<label>Album de fotos</label>
				<p class="form-text text-muted">Las fotos se verán en formato de album. En el reporte, tendran su previsualización. Ingrese solamente archivos en formato .JPG, .JPEG o .PNG, </p>
				<input-file name="photos[]" multiple accept="image/*"></input-file>
			</div>
    <div class="form-group">
      <label><b>Objetivos relacionados</b>&nbsp;<span class="text-smallest text-primary">(Opcional)</span></label>
      <div>
        @foreach($objectives as $objective)
          <div class="custom-control custom-checkbox form-check-inline">
            <input class="custom-control-input" type="checkbox" name="objectives[]" id="obj{{$objective->id}}" :value="{{$objective->id}}" {{$objective->hidden == true ? 'disabled' : null}}>
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
      <small class="form-text text-muted">Se le enviará una notificación por email (si lo tienen habilitado) y por sistema a los suscriptores de los objetivos seleccionados, de la creacion del evento invitandolos a verlo.</small>
    </div>
    <br>
    <button type="submit" class="btn btn-primary">Crear</button>
  </form>
</section>

@endsection