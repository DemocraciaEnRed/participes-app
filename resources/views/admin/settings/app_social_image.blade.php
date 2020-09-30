<form method="POST" action="{{ route('admin.settings.form.file') }}" enctype="multipart/form-data">
  @method('PUT')
  @csrf
  <div class="row">
    <div class="col">
      <div class="form-group">
        <label><b>Social Share - Imagen</b></label>
        <div class="alert alert-light">
          <i class="fas fa-exclamation-triangle"></i> <b>Importante!</b><br>
          La imagen debe ser de dimensiones 800x565 pixeles, no transparente. Recomendamos JPEG o PNG (Elija en base al tamaño de archivo mas chico. Recomendamos: Fotografia, usar JPG. Graficos planos, usar PNG)
        </div>
        <input type="hidden"  name="name" value="app_social_image" >
        <input type="hidden"  name="type" value="string" >
        <input type="hidden"  name="cached" value="true" >
        <input-file name="file" accept="image/png,image/jpg"></input-file>
      </div>
      <button type="submit" class="btn btn-sm btn-primary">Editar</button>
    </div>
    <div class="col">
        <img src="{{URL::to('/')}}{{app_setting('app_social_image','/social-sharer.png')}}" class="img-fluid">
    </div>
  </div>
</form>

