<form method="POST" action="{{ route('admin.settings.form') }}">
  @method('PUT')
  @csrf
  <label><b>Habilitar georeferenciacion (Mapas)</b></label>
  <p class="text-muted text-smaller">
    Habilite esta opción para habilitar la georeferenciación en el sitio. Esto le permitirá agregar mapas en sus objetivos y metas.
  </p>
  <p class="text-muted text-smaller">
    Nota: Se utiliza Mapbox como proveedor y debe contar con una cuenta de Mapbox y habilitar una nueva API Key para el dominio del sitio. Es importante que genere una <u>nueva</u> api key. La definición de la API Key se puede encontrar en la documentación de Mapbox.
  </p>
  <div class="form-group">
    <div class="custom-control custom-switch">
      <input type="hidden"  name="name" value="app_map_enabled" >
      <input type="hidden"  name="type" value="boolean" >
      <input type="hidden"  name="cached" value="true" >
      <input id="app_map_enabled" type="checkbox" class="custom-control-input" name="value" value="true" {{$settings['app_map_enabled']->value ? 'checked' : ''}}>
      <label for="app_map_enabled" class="custom-control-label">Habilitar georeferenciación</label>
    </div>
  </div>
  <button type="submit" class="btn btn-sm btn-primary">Editar</button>
</form>