<h5 class="mb-2 is-700"><i class="fas fa-medal fa-fw"></i><i class="fas fa-trash-alt fa-fw"></i> Han eliminado una meta</h5>
<p class="my-1 text-smaller">Han eliminado la meta <b>"{{$notification->data['goal']['title']}}"</b> del objetivo <b>"{{$notification->data['objective']['title']}}"</b> al que estas suscripto.</p>
<p class="my-1 text-smallest text-muted">
Notificado el @datetime($notification->created_at) - <a
  href="{{route('objectives.index', ['objectiveId' => $notification->data['objective']['id']])}}" title="{{$notification->data['objective']['title']}}">Ver objetivo</a>
</p>