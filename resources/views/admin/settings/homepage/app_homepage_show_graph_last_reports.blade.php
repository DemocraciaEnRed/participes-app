<form method="POST" action="{{ route('admin.settings.form') }}">
  @method('PUT')
  @csrf
  <label><b>Mostrar gráfico de "Reportes en los últimos 15 dias"</b></label>
  <p class="text-muted text-smaller">
    Habilite esta opción para mostrar el gráfico de "Reportes en los últimos 15 dias" en la home.
  </p>
  <div class="form-group">
  <div class="custom-control custom-switch">
    <input type="hidden"  name="name" value="app_homepage_show_graph_last_reports" >
    <input type="hidden"  name="type" value="boolean" >
    <input type="hidden"  name="cached" value="true" >
    <input id="app_homepage_show_graph_last_reports" type="checkbox" class="custom-control-input" name="value" value="true" {{$settings['app_homepage_show_graph_last_reports']->value ? 'checked' : ''}}>
    <label for="app_homepage_show_graph_last_reports" class="custom-control-label">Mostrar gráfico de "Reportes en los últimos 15 dias"</label>
  </div>
  </div>
  <button type="submit" class="btn btn-sm btn-primary">Editar</button>
</form>