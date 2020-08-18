<h5 class="mb-2"><i class="fas fa-bullhorn fa-fw"></i> Meta editada</h5>
  <p class="mb-1 text-smaller">Han editado la meta "{{$notification->data['goal']['title']}}". Te invitamos a leer la meta editada haciendo <a href="{{route('goals.index', ['goalId' => $notification->data['goal']['id']])}}" >click aquí</a></p>
  <p class="mb-0 text-smallest text-muted">
    Notificado el @datetime($notification->created_at) - <a
      href="{{route('goals.index', ['goalId' => $notification->data['goal']['id']])}}" title="{{$notification->data['goal']['title']}}">Ver meta</a>
    - 
    <a
      href="{{route('objectives.index', ['objectiveId' => $notification->data['objective']['id']])}}" title="{{$notification->data['objective']['title']}}">Ver objetivo</a>
    </p>