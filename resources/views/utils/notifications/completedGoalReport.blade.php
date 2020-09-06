<h5 class="mb-2 is-700"><i class="fas fa-medal fa-fw"></i><i class="far fa-laugh-beam fa-fw"></i> ¡Una meta llegó a su 100%!</h5>
<p class="my-1 text-smaller">¡Estamos celebrando porque la meta <b>"{{$notification->data['goal']['title']}}"</b> llegó a su 100%! Podes leer el nuevo reporte de {{$notification->data['report']['label']}} <b>"{{$notification->data['report']['title']}}"</b> haciendo <a href="{{route('reports.index', ['reportId' => $notification->data['report']['id']])}}" >click aquí</a></p>
<p class="my-1 text-smallest text-muted">
Notificado el @datetime($notification->created_at) - <a
  href="{{route('reports.index', ['reportId' => $notification->data['report']['id']])}}" title="{{$notification->data['report']['title']}}">Ver reporte</a>
- 
<a
  href="{{route('goals.index', ['goalId' => $notification->data['goal']['id']])}}" title="{{$notification->data['goal']['title']}}">Ver meta</a>
- 
<a
  href="{{route('objectives.index', ['objectiveId' => $notification->data['objective']['id']])}}" title="{{$notification->data['objective']['title']}}">Ver objetivo</a>
</p>