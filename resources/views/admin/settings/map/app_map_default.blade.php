<form action="{{ route('admin.settings.map.form') }}" method="POST">
  @method('PUT')
  @csrf
  <div class="form-group">
    <label><b>Definir centro y zoom por defecto del mapa</b></label>
    <p class="text-muted text-smaller">Defina el centro y zoom por defecto del mapa (Seria la posición "por default") en el caso de que no exista centro y zoom en otras entidades como metas proyectos o recursos</p>
    <set-map-default access-token="{{app_setting('app_mapbox_api_key')}}" map-style="{{app_setting('app_mapbox_style')}}" :lat="{{app_setting('app_map_lat_default') ?: 'undefined'}}" :long="{{app_setting('app_map_long_default') ?: 'undefined'}}" :zoom="{{app_setting('app_map_zoom_default') ?: 'undefined'}}"></set-map-default>
  </div>  
</form>
