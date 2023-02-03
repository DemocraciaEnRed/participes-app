<form method="POST" action="{{ route('admin.settings.form') }}">
  @method('PUT')
  @csrf
  <label><b>Mostrar "Ultimos reportes publicados"</b></label>
  <p class="text-muted text-smaller">
    Habilite esta opción para mostrar el segmento de "Ultimos reportes publicados" en la home.
  </p>
  <div class="form-group">
  <div class="custom-control custom-switch">
    <input type="hidden"  name="name" value="app_homepage_show_latest_reports" >
    <input type="hidden"  name="type" value="boolean" >
    <input type="hidden"  name="cached" value="true" >
    <input id="app_homepage_show_latest_reports" type="checkbox" class="custom-control-input" name="value" value="true" {{$settings['app_homepage_show_latest_reports']->value ? 'checked' : ''}}>
    <label for="app_homepage_show_latest_reports" class="custom-control-label">Mostrar "Ultimos reportes publicados"</label>
  </div>
  </div>
  <button type="submit" class="btn btn-sm btn-primary">Editar</button>
</form>