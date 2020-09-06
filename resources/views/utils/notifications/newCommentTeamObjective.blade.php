<h5 class="mb-2 is-700"><i class="fas fa-plus fa-fw"></i><i class="fas fa-comments fa-fw"></i> Nuevo comentario en un reporte</h5>
<p class="my-1 text-smaller">Han hecho un nuevo comentario en el reporte de {{$notification->data['report']['label']}} <b>"{{$notification->data['report']['title']}}"</b>.</p>
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