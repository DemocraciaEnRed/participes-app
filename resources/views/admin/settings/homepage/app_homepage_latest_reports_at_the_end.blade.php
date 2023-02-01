<form method="POST" action="{{ route('admin.settings.form') }}">
  @method('PUT')
  @csrf
  <label><b>Mostrar "Ultimos reportes publicados" luego de los objetivos</b></label>
  <p class="text-muted text-smaller">
    Habilite esta opción para que el segmento de "Ultimos reportes publicados" luego del listado de los objetivos. De lo contrario, se mostrará antes.
  </p>
  <div class="form-group">
  <div class="custom-control custom-switch">
    <input type="hidden"  name="name" value="app_homepage_latest_reports_at_the_end" >
    <input type="hidden"  name="type" value="boolean" >
    <input type="hidden"  name="cached" value="true" >
    <input id="app_homepage_latest_reports_at_the_end" type="checkbox" class="custom-control-input" name="value" value="true" {{$settings['app_homepage_latest_reports_at_the_end']->value ? 'checked' : ''}}>
    <label for="app_homepage_latest_reports_at_the_end" class="custom-control-label">Mostrar "Ultimos reportes publicados" luego de los objetivos</label>
  </div>
  </div>
  <button type="submit" class="btn btn-sm btn-primary">Editar</button>
</form>