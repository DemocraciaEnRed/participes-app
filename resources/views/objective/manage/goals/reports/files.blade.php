@extends('objective.manage.goals.reports.master')

@section('panelContent')

<section>
  <h3 class="is-700">Repositorio de archivos</h3>
  <p class="lead">Aquí podrás encontrar y cargar todos los archivos vinculados a el reporte</p>
   <hr>
  <h5 class="font-weight-bold"><i class="fas fa-upload"></i> Nuevo archivo</h5>
  <p>Cargue su archivo haciendo clic en el campo para poder seleccionar. Intente no subir archivos de mucho peso.</p>
  <form action="{{route('objectives.manage.goals.reports.files.form',['objectiveId' => $objective->id, 'goalId' => $goal->id, 'reportId' => $report->id])}}" method="POST" enctype="multipart/form-data">
    @csrf
    <input-file name="file"></input-file>
    <div class="form-group">
      <button class="btn btn-primary" type="submit">Subir archivo</button>
    </div>
  </form>
  <hr>
  @forelse($files as $file)
  <div class="card mb-2 shadow-sm">
    <div class="card-body p-2 pl-4 pr-4 d-flex">
        <div class="mr-3 mt-2">
          <i class="far fa-file fa-lg"></i>
        </div>
        <div class="flex-fill">
          <p class="mb-0 text-smaller">{{ $file->name }}</p>
          <p class="text-card text-smaller text-muted mb-0">{{ $file->mime }}</p>
        </div>
        <div class="ml-3 mt-2">
          <a href="{{ asset($file->path) }}" class="card-link text-smaller"><i class="fas fa-download fa-lg"></i></a>
        </div>
    </div>
  </div>
  @empty
  <div class="card mb-3 shadow-sm">
    <div class="card-body">
        <div class="text-center">
          <h6 class="card-title">No hay archivos cargados</h4>
          <p class="mb-0"> Puede subir archivos en el campo superior <i class="fas fa-arrow-up"></i></p>
        </div>
    </div>
  </div>
  @endforelse
  {{ $files->links() }}
</section>

@endsection
