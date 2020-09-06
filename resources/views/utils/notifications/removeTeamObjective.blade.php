<h5 class="mb-2 is-700"><i class="fas fa-bullseye fa-fw"></i><i class="fas fa-user-minus fa-fw"></i> Te han quitado de un equipo</h5>
<p class="my-1 text-smaller">Te informamos que has sido removido del equipo del objetivo <b>"{{$notification->data['objective']['title']}}"</b> como <b>{{ $notification->data['objective']['title'] == 'manager' ? 'Coordinador/a' : 'Reportero/a'}}</b>.</p>
<p class="my-1 text-smaller">Seguirás suscripto a las notificaciones del objetivo (Si es que aun no te has desuscripto del mismo).</p>
<p class="my-1 text-smallest text-muted">
Notificado el @datetime($notification->created_at) - 
<a
  href="{{route('objectives.index', ['objectiveId' => $notification->data['objective']['id']])}}" title="{{$notification->data['objective']['title']}}">Ver objetivo</a>
</p>