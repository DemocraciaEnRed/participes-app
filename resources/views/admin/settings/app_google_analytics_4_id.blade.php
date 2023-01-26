<form method="POST" action="{{ route('admin.settings.form') }}">
  @method('PUT')
  @csrf
  <div class="form-group">
    <label><b>Google Analytics 4 - Tag ID</b></label>
    <p class="text-muted text-smaller">Si quiere activar el tracking de Google Analytics, ingresá el Tag ID de Google Analytics 4. Nota: Debe tener una cuenta de Google Analytics 4 para poder usar esta funcionalidad, una propiedad y un tag comenzando con "G-########".</p>
    <p class="text-muted text-smaller">El campo vacio desactiva el plugin de Google Analytics</p>
    <input type="hidden"  name="name" value="app_google_analytics_4_id" >
    <input type="hidden"  name="type" value="string" >
    <input type="hidden"  name="cached" value="true" >
    <input type="text" class="form-control" name="value" placeholder="Tag ID de Google Analytics 4" value="{{$settings['app_google_analytics_4_id']->value}}">
  </div>
  <button type="submit" class="btn btn-sm btn-primary">Editar</button>
</form>