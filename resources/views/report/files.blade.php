@if(!$report->photos->isEmpty())
  <div class="card shadow-sm my-3">
    <div class="card-body p-3 p-lg-5">
      <h3 class="is-600 mb-3">Archivos adjuntos</h3>
      @forelse ($report->files as $file)
      <div class="card my-2 shadow-sm">
        <div class="card-body p-2 pl-4 pr-4 d-flex">
          <div class="mr-3 mt-2">
            <i class="far fa-file fa-lg"></i>
          </div>
          <div class="flex-fill">
            <p class="mb-0 text-smaller word-wrap-anywhere">{{ $file->name }}</p>
            <p class="text-card text-smaller text-muted mb-0">{{ $file->mime }}</p>
          </div>
          <div class="ml-3 mt-2">
            <a href="{{ asset($file->path) }}" class="card-link text-smaller"><i class="fas fa-download fa-lg"></i></a>
          </div>
        </div>
      </div>
      @empty
      <p class="my-2 text-muted">No hay archivos adjuntos al reporte</p>
      @endforelse
    </div>
  </div>
  @endif