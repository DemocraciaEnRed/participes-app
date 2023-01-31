<form method="POST" action="{{ route('admin.settings.form') }}">
  @method('PUT')
  @csrf
  <div class="form-group">
    <label><b>Homepage: Mostrar mapa</b></label>
    <p class="text-muted text-smaller">
      Puede activar o desactivar el mapa de la página principal.
    </p>
    <div class="custom-control custom-switch">
      <input type="hidden"  name="name" value="app_homepage_show_map" >
      <input type="hidden"  name="type" value="boolean" >
      <input type="hidden"  name="cached" value="true" >
      <input id="enable_map" type="checkbox" class="custom-control-input" name="value" placeholder="Mapbox Api Key" value="{{$settings['app_homepage_show_map']->value ? 'false' : 'true'}}" {{$settings['app_homepage_show_map']->value ? 'checked' : ''}}>
      <label for="enable_map" class="custom-control-label">Mostrar mapa en la homepage</label>
    </div>
  </div>
  <button type="submit" class="btn btn-sm btn-primary">Editar</button>
</form>