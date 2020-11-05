@if(Auth::user())
  @if (Auth::user()->hasVerifiedEmail())
    @if(!$objective->isSubscriber(Auth::user()->id))
      <div class="card bg-primary border-0 mb-3">
        <div class="card-body d-flex justify-content-between align-items-center">      
          <i class="fas fa-bullhorn fa-2x text-white animate__animated animate__tada m-2 mr-3"></i>
          <div class="text-right">
            <h6 class="is-700 text-white">¡Recibí notificaciones del objetivo, las metas y los reportes!</h6>
            <form action="{{route('objectives.subscribers.form',['objectiveId' => $objective->id])}}" method="POST">
              @csrf
              <button class="btn btn-sm btn-info is-600"><i class="fas fa-plus fa-fw"></i><i class="fas fa-eye fa-fw"></i>&nbsp;Suscribirme</button>
            </form>
          </div>
        </div>
      </div>
    @else
      <div class="card bg-success border-0 mb-3">
        <div class="card-body d-flex justify-content-between align-items-center">      
          <i class="far fa-smile-wink fa-2x text-white animate__animated animate__pulse m-2 mr-3"></i>
          <div class="text-right">
            <h6 class="is-700 text-white">Estás suscripto al objetivo</h6>
            <form action="{{route('objectives.subscribers.form',['objectiveId' => $objective->id])}}" method="POST">
              @csrf
              <button class="btn btn-sm btn-dark is-600"><i class="fas fa-eye-slash fa-fw"></i>&nbsp;Quitar suscripción</button>
            </form>
          </div>
        </div>
      </div>
    @endif
  @else
  <div class="card bg-primary border-0 mb-3">
    <div class="card-body d-flex justify-content-between align-items-center">
      <i class="fas fa-exclamation-triangle fa-2x text-white animate__animated animate__tada m-2 mr-3"></i>
      <div class="text-right text-white">
        <h6 class="is-700">Para poder subscribirte a las novedades, debes verificar tu cuenta</h6>
        <span>Aún no has verificado tu cuenta. Para hacerlo, ingresar en tu <a href="/panel" class="text-white is-700">panel de control<i class="fas fa-arrow-right fa-fw"></i></a></span>
      </div>
    </div>
  </div>
  @endif
@else
<div class="card bg-primary border-0 mb-3">
    <div class="card-body d-flex justify-content-between align-items-center">      
      <i class="fas fa-bullhorn fa-2x text-white animate__animated animate__tada m-2 mr-3"></i>
      <div class="text-right">
        <h6 class="is-700 text-white">¡Recibí notificaciones del objetivo, las metas y los reportes!</h6>
        <a href="{{route('login')}}" class="btn btn-sm btn-info is-600"><i class="fas fa-plus fa-fw"></i><i class="fas fa-eye fa-fw"></i>&nbsp;Subscribirme</a>
      </div>
    </div>
  </div>
@endif