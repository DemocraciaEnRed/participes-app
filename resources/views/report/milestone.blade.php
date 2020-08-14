@if($report->type == 'milestone')
  <div class="card shadow-sm my-3">
    <div class="card-body p-3 p-lg-5 d-flex justify-content-between align-items-center">
      <div class="align-self-center animate__animated animate__flipInX">
        <h4 class="is-700 m-0">Hito completado</h4>
        <p class="my-1">Hito #{{$report->milestone->order}} - {{$report->milestone->title}}</p>
        <p class="my-1">Fecha de completado: @justdate($report->milestone->completed)</p>
      </div>
      <h3
        class="is-700 text-info ml-2 mb-0 align-self-center animate__animated animate__bounceIn animate__delay-1s">
        <i class="fas fa-medal fa-lg fa-fw"></i></h3>
    </div>
  </div>
@endif