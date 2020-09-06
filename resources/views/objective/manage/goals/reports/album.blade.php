@extends('objective.manage.goals.reports.master')

@section('panelContent')

<section>
  <h3 class="is-700">Album de fotos</h3>
  <p class="lead">Lorem ipsum dolor sit amet consectetur adipisicing elit. Saepe culpa odio cumque eaque fuga dolor beatae ullam, voluptate corrupti quam facere quisquam a dolore rerum atque molestiae qui minus nam!</p>
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
 @forelse($report->photos as $photo)
  <div class="d-inline-block mr-2 my-1">
    <a href="{{asset($photo->path)}}" target="_blank"><img src="{{asset($photo->thumbnail_path)}}" height="80" class="img rounded mb-1 align-top" alt=""></a> 
    <a class="is-clickable text-danger" onclick="event.preventDefault();document.getElementById('delete-photo-{{$photo->id}}').submit();"><i class="fas fa-times fa-lg fa-fw"></i></a>
    <form id="delete-photo-{{$photo->id}}" action="{{route('objectives.manage.goals.reports.album.delete.form',['objectiveId' => $objective->id, 'goalId' => $goal->id, 'reportId' => $report->id, 'pictureId' => $photo->id]) }}" method="POST" style="display: none;">
        @method('DELETE')
        @csrf
    </form>
  </div>
  @empty
  <p class="text-muted">No hay fotos cargadas en el evento</p>
  @endforelse
  {{ $photos->links() }}
</section>

@endsection
