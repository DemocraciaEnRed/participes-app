@if(count($events) > 0)
@foreach($events as $event)
<div class="card my-3 shadow-sm">
  <div class="card-body d-flex align-items-start">
    <div class="mr-3">
      <i class="fas fa-calendar-alt fa-2x fa-fw"></i>
    </div>
    <div class="w-100">
      <span class="text-muted">{{$event->moment}}</span>
      <h4 class="is-700 my-1">
        <a href="{{route('events.index',['eventId' => $event->id])}}"
          class="text-dark">{{$event->title}}</a>
      </h4>
      <p class="text-muted text-smaller my-1">{{Str::limit($event->content, 200, $end=' [...]')}}</p>
      <div class="text-right">
      <a href="{{route('admin.events.edit',['eventId' => $event->id])}}" class="btn btn-link btn-sm"><i class="fas fa-edit fa-fw"></i>Editar</a>
      <a href="{{route('admin.events.delete',['eventId' => $event->id])}}" class="btn btn-link btn-sm"><i class="fas fa-trash fa-fw"></i>Eliminar</a>
      </div>
    </div>
  </div>
</div>
@endforeach
@else
<div class="card mb-3 shadow-sm">
  <div class="card-body">
    <h6 class="card-title font-weight-bold m-0">No hay eventos creados</h6>
  </div>
</div>
@endif
{{ $events->links() }}