@if(!is_null($report->status))
  <div class="card shadow-sm my-3">
    <div class="card-body p-3 p-lg-5 d-flex justify-content-between align-items-center">
      <div class="align-self-center animate__animated animate__flipInX">
        <h4 class="is-700 m-0">Cambio de estado</h4>
        <p class="mb-0 mt-1">El reporte ha cambiado el estado de la meta de <span class="is-600 text-{{$report->previous_status}}"><i class="far fa-dot-circle"></i>&nbsp;{{$report->previousstatus_label}}</span> a <span class="is-600 text-{{$report->status}}"><i class="far fa-dot-circle"></i>&nbsp;{{$report->status_label}}</span></p>
      </div>
      <h5 class="is-700 text-{{$report->status}} text-center ml-2 mb-0 align-self-center animate__animated animate__bounceIn animate__delay-1s"><i class="far fa-dot-circle fa-lg fa-fw"></i><br>{{$report->status_label}}</h5>
    </div>
  </div>
@endif