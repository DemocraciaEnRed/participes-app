@extends('objective.manage.goals.reports.master')

@section('panelContent')

<section>
  <h1 class="">Album de fotos</h1>
  <p>Lorem ipsum dolor sit amet consectetur adipisicing elit. Saepe culpa odio cumque eaque fuga dolor beatae ullam, voluptate corrupti quam facere quisquam a dolore rerum atque molestiae qui minus nam!</p>
   <hr>
  <h5 class="font-weight-bold"><i class="fas fa-upload"></i> Nueva imagen</h5>
  <p>Debe ser una imagen JPG o JPEG , hasta 8 MB. Si el ancho de la imagen es mayor a 1366px, sera ajustada a este
    tamaño.</p>  
    <form action="{{route('objectives.manage.goals.reports.album.form',['objectiveId' => $objective->id, 'goalId' => $goal->id, 'reportId' => $report->id])}}" method="POST" enctype="multipart/form-data">
    @csrf
    <input-file name="photo" accept="image/*"></input-file>
    <div class="form-group">
      <button class="btn btn-primary" type="submit">Subir imagen</button>
    </div>
  </form>
  <hr>
  @forelse($photos as $photo)
  <p class="d-inline"><a href="{{asset($photo->path)}}" target="_blank"><img src="{{asset($photo->thumbnail_path)}}" height="120" class="img rounded mb-1" alt=""></a></p>
  @empty
  <div class="card mb-3 shadow-sm">
    <div class="card-body">
        <div class="text-center">
          <h6 class="card-title">No hay fotos cargadas en el album</h4>
          <p class="mb-0"> Puede subir una nueva foto en el campo superior <i class="fas fa-arrow-up"></i></p>
        </div>
    </div>
  </div>
  @endforelse
  {{ $photos->links() }}
</section>

@endsection
