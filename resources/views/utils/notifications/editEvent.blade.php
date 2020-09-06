<h5 class="mb-2 is-700"><i class="fas fa-calendar-alt fa-fw"></i><i class="fas fa-pencil-alt fa-fw"></i> Han editado un evento</h5>
<p class="my-1 text-smaller">Han editado el evento <b>{{$notification->data['event']['title']}}</b>, te notificamos porque el evento está relacionado con un objetivo al que estas suscripto. Podes ver mas acerca del evento haciendo <a href="{{route('events.index', ['eventId' => $notification->data['event']['id']])}}" >click aquí</a></p>
<p class="my-1 text-smallest text-muted">
Notificado el @datetime($notification->created_at) - <a
  href="{{route('events.index', ['eventId' => $notification->data['event']['id']])}}" title="{{$notification->data['event']['title']}}">Ver evento</a>
</p>