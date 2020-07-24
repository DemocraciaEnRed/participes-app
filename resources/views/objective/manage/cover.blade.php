@extends('objective.manage.master')

@section('panelContent')

<section>
  <h1 class="">Imagen de portada</h1>
  <p>Lorem ipsum dolor sit amet consectetur, adipisicing elit. In eius ad officia tempora, temporibus repudiandae id
    ipsum neque deserunt rerum esse delectus consectetur voluptates eveniet quaerat commodi ducimus mollitia dolorem.
  </p>
  <hr>
  <h5 class="font-weight-bold"><i class="fas fa-upload"></i> Nueva imagen</h5>
  <p>Debe ser una imagen JPG o JPEG , hasta 8 MB. Si el ancho de la imagen es mayor a 1366px, sera ajustada a este
    tamaño.</p>
  <form action="{{route('objective.manage.cover.form',['objId' => $objective->id])}}" method="POST"
    enctype="multipart/form-data">
    @csrf
    <input-file name="image" accept="image/jpeg"></input-file>
    <div class="form-group">
      <button class="btn btn-primary" type="submit">Subir</button>
    </div>
  </form>
  <hr>
  @if($objective->cover)
  <h5 class="font-weight-bold"><i class="far fa-image"></i> Portada actual</h5>
   <img src="{{asset($objective->cover->path)}}" class="img-fluid img-thumbnail" alt="">
  @else
  <div class="alert alert-dark">
    <i class="fas fa-eye-slash"></i> El objetivo no cuenta con una imagen de portada
  </div>
  @endif

</section>

@endsection