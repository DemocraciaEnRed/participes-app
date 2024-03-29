@extends('panel.master')

@section('panelContent')

<section>
<h3 class="is-700">Notificaciones</h3>
<ul class="list-group my-3">
 @if(count($notifications) > 0)
    @foreach($notifications as $notification)
    <notification-item form-url="{{ route('apiService.notification.mark.one',['id' => $notification->id])}}" :notification='@json($notification)'>
      @include('utils.notifications.notification',['notification' => $notification])
    </notification-item>
    @endforeach
  @else
   <li class="list-group-item">¡Ka-boom! ¡No tenes notificaciones!</li>
  @endif
</ul>
  {{ $notifications->links() }}
 @if(!$notifications->isEmpty())
  <hr>
  <div class="card">
    <div class="card-body d-flex justify-content-between">
      <div>
      <h5>¿Eliminar todas las notificaciones?</h5>
      <p class="mb-0"><i class="fas fa-info-circle"></i>&nbsp;Si desea, puede eliminar todas las notificaciones pendientes y leidas.</p>
      </div>
      <div class="ml-2 pt-2 text-center">
        <a class="is-clickable text-info" onclick="event.preventDefault();document.getElementById('checkAll').submit();"><i class="fas fa-trash fa-lg"></i></a>
        <form id="checkAll" action="{{route('panel.notifications.delete.all.form') }}" method="POST" style="display: none;">
            @csrf
        </form>
      </div>
    </div>
  </div>
  @endif
</section>

@endsection