<form method="POST" action="{{ route('admin.settings.form.file') }}" enctype="multipart/form-data">
  @method('PUT')
  @csrf
  <div class="row">
    <div class="col">
      <div class="form-group">
        <label><b>Logo App - Favicon</b></label>
         <div class="alert alert-light">
          <i class="fas fa-exclamation-triangle"></i> <b>Importante!</b><br>
          Debe ser de dimensiones 1:1 (cuadrado), PNG y fondo transparente. Como maximo recomendamos hasta 250x250px.
        </div>
        <input type="hidden"  name="name" value="app_favicon" >
        <input type="hidden"  name="type" value="string" >
        <input type="hidden"  name="cached" value="true" >
        <input-file name="file" accept="image/png"></input-file>
      </div>
      <button type="submit" class="btn btn-sm btn-primary">Editar</button>
    </div>
    @if($settings['app_favicon']->value)
    <div class="col">
      <div class="alert alert-white">
        <img src="{{asset($settings['app_favicon']->value)}}" class="img-fluid">
      </div>
    </div>
    @endif
  </div>
</form>
