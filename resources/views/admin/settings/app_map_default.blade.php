<form action="{{ route('admin.settings.form.map') }}" method="POST">
  @method('PUT')
  @csrf
  <div class="form-group">
    <label><b>Definir centro y zoom por defecto del mapa</b></label>
    <p class="text-muted text-smaller">Defina el centro y zoom por defecto del mapa (Seria la posición "por default") en el caso de que no exista centro y zoom en otras entidades como metas proyectos o recursos</p>
  <set-map-default access-token="{{config('services.mapbox.key')}}" map-style="{{config('services.mapbox.style')}}" :lat="{{$settings['app_map_lat_default']->casted_value ?: 'undefined'}}" :long="{{$settings['app_map_long_default']->casted_value ?: 'undefined'}}" :zoom="{{$settings['app_map_zoom_default']->casted_value ?: 'undefined'}}"></set-map-default>
  </div>  
</form>
