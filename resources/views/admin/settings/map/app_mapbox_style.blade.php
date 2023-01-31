<form method="POST" action="{{ route('admin.settings.form') }}">
  @method('PUT')
  @csrf
  <div class="form-group">
    <label><b>Mapbox Style URL</b></label>
    <p class="text-muted text-smaller">
      Ingrese el estilo de Mapbox. Puede utilizar estilos ya definidos por Mapbox (Por ejemplo: <code>mapbox://styles/mapbox/light-v10</code>) o crear estilos de mapa custom desde Mapbox Studio. Para más información, visite <a href="https://docs.mapbox.com/help/glossary/style-url/" target="_blank">https://docs.mapbox.com/help/glossary/style-url/</a>
    </p>
    <input type="hidden"  name="name" value="app_mapbox_style" >
    <input type="hidden"  name="type" value="string" >
    <input type="hidden"  name="cached" value="true" >
    <input type="text" class="form-control" name="value" placeholder="Mapbox Style URL" value="{{$settings['app_mapbox_style']->value}}">
  </div>
  <button type="submit" class="btn btn-sm btn-primary">Editar</button>
</form>