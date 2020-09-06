<h5 class="mb-2 is-700"><i class="{{$notification->data['report']['icon']}} fa-fw"></i><i class="fas fa-times fa-fw"></i> Reporte eliminado</h5>
<p class="my-1 text-smaller">Han eliminado el reporte de {{$notification->data['report']['label']}} <b>"{{$notification->data['report']['title']}}"</b>.</p>
<p class="my-1 text-smallest text-muted">
Notificado el @datetime($notification->created_at) - <a
  href="{{route('goals.index', ['goalId' => $notification->data['goal']['id']])}}" title="{{$notification->data['goal']['title']}}">Ver meta</a>
- <a
  href="{{route('objectives.index', ['objectiveId' => $notification->data['objective']['id']])}}" title="{{$notification->data['objective']['title']}}">Ver objetivo</a>
</p>