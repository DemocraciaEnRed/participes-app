<form method="POST" action="{{ route('admin.settings.form') }}">
  @method('PUT')
  @csrf
  <div class="form-group">
    <label><b>Mapbox API Key</b></label>
    <p class="text-muted text-smaller">
      Si quiere activar el mapa de Mapbox, ingresá el API Key de Mapbox.
    </p>
    <p class="text-muted text-smaller">
      Nota: Debe tener una cuenta de Mapbox y habilitar una nueva API Key para el dominio del sitio. Es importante que genere una <u>nueva</u> api key.
    </p>
    <input type="hidden"  name="name" value="app_mapbox_api_key" >
    <input type="hidden"  name="type" value="string" >
    <input type="hidden"  name="cached" value="true" >
    <input type="text" class="form-control" name="value" placeholder="Mapbox Api Key" value="{{$settings['app_mapbox_api_key']->value}}">
  </div>
  <button type="submit" class="btn btn-sm btn-primary">Editar</button>
</form>