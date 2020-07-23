<h5 class="mb-2"><i class="fas fa-bullhorn fa-fw"></i> ¡Nuevo reporte!</h5>
  <p class="mb-1 text-smaller">Podes leer el nuevo reporte haciendo <a href="/reporte/{{$notification->data['report']['id']}}" >click aquí</a></p>
  <p class="mb-0 text-smallest text-muted">
    Notificado el @datetime($notification->created_at) - <a
      href="/objetivo/{{$notification->data['objective']['id']}}/meta/{{$notification->data['goal']['id']}}" title="{{$notification->data['goal']['title']}}">Ver meta</a>
    - 
    <a
      href="/objetivo/{{$notification->data['objective']['id']}}" title="{{$notification->data['objective']['title']}}">Ver objetivo</a>
    </p>