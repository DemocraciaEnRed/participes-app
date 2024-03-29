<form method="POST" action="{{ route('admin.settings.form.file') }}" enctype="multipart/form-data">
  @method('PUT')
  @csrf
  <div class="row">
    <div class="col">
      <div class="form-group">
        <label><b>Logo App - Color</b></label>
        <p class="text-muted text-smaller">
          <i class="fas fa-exclamation-triangle"></i> <b>Importante!</b> Se aceptan SVG o PNG. De ser SVG, recomendamos que la dimensiones del archivo tenga una relacion 2:1 o 3:1 (Ancho mas largo que el alto). De ser un archivo PNG, recomendamos con fondo transparente y tambien dimensiones de relacion 2:1 o 3:1 (Ancho mas largo que el alto)
        </p>
        <input type="hidden"  name="name" value="app_logo_color" >
        <input type="hidden"  name="type" value="string" >
        <input type="hidden"  name="cached" value="true" >
        <input-file name="file" accept="image/png,image/svg+xml"></input-file>
      </div>
      <button type="submit" class="btn btn-sm btn-primary">Editar</button>
    </div>
    @if($settings['app_logo_color']->value)
    <div class="col">
      <div class="alert alert-white">
        <img src="{{asset($settings['app_logo_color']->value)}}" class="img-fluid">
      </div>
    </div>
    @endif
  </div>
</form>
