@if($report->type == 'progress')
  <div class="card shadow-sm my-3">
    <div class="card-body p-3 p-lg-5 d-flex justify-content-between align-items-center">
      <div class="align-self-center animate__animated animate__flipInX">
        <h4 class="is-700 m-0">Progreso declarado</h4>
        <p class="mb-0 mt-1">Unidad del indicador: {{$goal->indicator_unit}}</p>
      </div>
      <h3 class="is-700 text-info ml-2 mb-0 align-self-center animate__animated animate__bounceIn animate__delay-1s">{{$report->progress}}</h3>
    </div>
  </div>
@endif