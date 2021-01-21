@extends('admin.master')

@section('adminContent')

<section>
  <div>

  <h1><i class="fas fa-cog fa-fw fa-spin"></i> Administración</h1>
  <p class="lead">Este es el panel de administración de la plataforma Partícipes.</p>
  <hr class="my-4">
  <div class="card border-light my-3 text-center">
    <div class="card-body py-4 row justify-content-between">
      <div class="col text-center">
        <h6 class="font-weight-bold">Verificados</h6>
        <span class="h5"><i class="fas fa-users fa-fw"></i> {{$users_registered_count}}</span>
      </div>
      <div class="col text-center">
        <h6 class="font-weight-bold">No verificados</h6>
        <span class="h5"><i class="fas fa-users fa-fw"></i> {{$users_unverified_count}}</span>
      </div>
      <div class="col text-center">
        <h6 class="font-weight-bold">Metas</h6>
        <span class="h5"><i class="fas fa-bullseye fa-fw"></i> {{$objectives_count}}</span>
      </div>
      <div class="col text-center">
        <h6 class="font-weight-bold">Proyectos</h6>
        <span class="h5"><i class="fas fa-medal fa-fw"></i> {{$goals_count}}</span>
      </div>
      <div class="col text-center">
        <h6 class="font-weight-bold">Reportes</h6>
        <span class="h5"><i class="far fa-copy fa-fw"></i> {{$reports_count}}</span>
      </div>
    </div>
  </div>
  <hr>
  <h5><b>Ultimos 15 eventos en la bitácora</b></h5>
  @foreach($logs as $log)
  <div class="text-smaller">
  <p class="mb-1"><b>@datetime($log->record_datetime)</b> - {{$log->message}} <a data-toggle="collapse" href="#collapse{{$log->id}}" role="button" aria-expanded="false"><i class="fas fa-code fa-fw"></i></a></p>
  <p id="collapse{{$log->id}}" class="collapse"><code>{{$log->context}}</code></p>
  </div>
  @endforeach
  </div>
</section>

@endsection
