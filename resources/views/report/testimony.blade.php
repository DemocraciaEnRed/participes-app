@if(Auth::user())
  @if (Auth::user()->hasVerifiedEmail())
    @if(!is_null($testimony))
    <div class="card bg-success border-0 shadow-sm">
      <div class="card-body p-3 px-lg-5 d-flex justify-content-between align-items-center my-3">      
        <i class="far fa-smile-wink fa-2x text-white animate__animated animate__pulse animate__infinite m-2 mr-3"></i>
        <div class="text-right">
          <h5 class="is-700 text-white">¡Gracias por dejarnos tu feedback!</h5>
            <form action="{{route('reports.testimonies.form',['reportId' => $report->id])}}" method="POST">
            @csrf
            <button class="btn btn-dark is-700"><i class="fas fa-times"></i> Quitar mi feedback</button>
            <a href="#comentarios" class="btn btn-light is-700"><i class="far fa-comment"></i> Dejar un comentario</a>
          </form>
        </div>
      </div>
    </div>
    @else
    <div class="card bg-primary border-0 shadow-sm">
      <div class="card-body p-3 px-lg-5 d-flex justify-content-between align-items-center my-3">      
        <i class="fas fa-bullhorn fa-2x text-white animate__animated animate__tada animate__infinite m-2 mr-3"></i>
        <div class="text-right">
          <h5 class="is-700 text-white">Si te gustó el reporte, ¡Dejanos tu feedback!</h5>
          <form action="{{route('reports.testimonies.form',['reportId' => $report->id])}}" method="POST">
            @csrf
            <button class="btn btn-success is-700"><i class="fas fa-check"></i> ¡Estoy de acuerdo!</button>
            <a href="#comentarios" class="btn btn-light is-700"><i class="far fa-comment"></i> Dejar un comentario</a>
          </form>
        </div>
      </div>
    </div>
    @endif
  @else
  <div class="card bg-primary border-0 shadow-sm">
    <div class="card-body p-3 px-lg-5  d-flex justify-content-between align-items-center my-3">
      <i class="fas fa-exclamation-triangle fa-2x text-white animate__animated animate__tada animate__infinite m-2 mr-3"></i>
      <div class="text-right text-white">
        <h5 class="is-700">¡Debe verificar su cuenta para poder compartir su feedback!</h5>
      <span>Aún no has verificado tu cuenta. Para hacerlo, ingresar en tu <a href="/panel" class="text-white is-700">panel de control<i class="fas fa-arrow-right fa-fw"></i></a></span>
      </div>
    </div>
  </div>
  @endif
@else
<div class="card bg-primary border-0 shadow-sm">
  <div class="card-body p-3 px-lg-5 d-flex justify-content-between align-items-center my-3">      
    <i class="fas fa-bullhorn fa-2x text-white animate__animated animate__tada animate__infinite m-2 mr-3"></i>
    <div class="text-right">
      <h5 class="is-700 text-white">Si te gustó el reporte, ¡Dejanos tu feedback!</h5>
      <a href="{{route('login')}}" class="btn btn-success is-700"><i class="fas fa-check"></i> ¡Estoy de acuerdo!</a>
      <a href="{{route('login')}}" class="btn btn-light is-700"><i class="far fa-comment"></i> Dejar un comentario</a>
    </div>
  </div>
</div>
@endif