<h5 class="mb-2 is-700"><i class="fas fa-bullseye fa-fw"></i><i class="fas fa-user-plus fa-fw"></i> ¡Te han agregado a un equipo!</h5>
<p class="my-1 text-smaller">¡Felicidades! Te han agregado al equipo del objetivo <b>"{{$notification->data['objective']['title']}}"</b> como <b>{{ $notification->data['objective']['title'] == 'manager' ? 'Coordinador/a' : 'Reportero/a'}}</b>. Podes ingresar al panel del objetivo haciendo <a href="{{route('objectives.manage.index', ['objectiveId' => $notification->data['objective']['id']])}}" >click aquí</a>.</p> 
<p class="my-1 text-smaller">Automaticamente has sido suscripto a las notificaciones del objetivo (Puedes desuscribirte si lo deseas).</p>
<p class="my-1 text-smallest text-muted">
Notificado el @datetime($notification->created_at) - 
<a
  href="{{route('objectives.index', ['objectiveId' => $notification->data['objective']['id']])}}" title="{{$notification->data['objective']['title']}}">Ver objetivo</a>
</p>