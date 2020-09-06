<h5 class="mb-2 is-700"><i class="fas fa-medal fa-fw"></i><i class="fas fa-plus fa-fw"></i> Nueva meta</h5>
<p class="my-1 text-smaller">Han editado la meta <b>"{{$notification->data['goal']['title']}}"</b>. Te invitamos a leer la meta editada haciendo <a href="{{route('goals.index', ['goalId' => $notification->data['goal']['id']])}}" >click aquí</a></p>
<p class="my-1 text-smallest text-muted">
Notificado el @datetime($notification->created_at) - <a
  href="{{route('goals.index', ['goalId' => $notification->data['goal']['id']])}}" title="{{$notification->data['goal']['title']}}">Ver meta</a>
- 
<a
  href="{{route('objectives.index', ['objectiveId' => $notification->data['objective']['id']])}}" title="{{$notification->data['objective']['title']}}">Ver objetivo</a>
</p>