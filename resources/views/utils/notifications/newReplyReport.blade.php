<h5 class="mb-2 is-700"><i class="fas fa-reply fa-fw"></i><i class="fas fa-comments fa-fw"></i> Te han respondido a un comentario</h5>
<p class="my-1 text-smaller">Han respondido a un comentario tuyo hecho en el reporte de <i class="{{$notification->data['report']['icon']}} fa-fw"></i> {{$notification->data['report']['label']}} <b>"{{$notification->data['report']['title']}}"</b>.</p>
<p class="my-3 ml-3 text-smallest bg-light p-3 rounded">
  <b>{{$notification->data['comment']['author']}}</b><br/>{{$notification->data['comment']['content']}}
</p>
<p class="my-1 text-smallest text-muted">
Notificado el @datetime($notification->created_at) - <a
  href="{{route('reports.index', ['reportId' => $notification->data['report']['id']])}}" title="{{$notification->data['report']['title']}}">Ver reporte</a>
- <a
  href="{{route('goals.index', ['goalId' => $notification->data['goal']['id']])}}" title="{{$notification->data['goal']['title']}}">Ver meta</a>
- <a
  href="{{route('objectives.index', ['objectiveId' => $notification->data['objective']['id']])}}" title="{{$notification->data['objective']['title']}}">Ver objetivo</a>
</p>