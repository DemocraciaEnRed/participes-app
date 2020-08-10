@extends('panel.master')

@section('panelContent')

<section>
<h1 class="">Notificaciones pendientes</h1>
{{-- <p>Lorem ipsum dolor sit amet consectetur, adipisicing elit. In eius ad officia tempora, temporibus repudiandae id ipsum neque deserunt rerum esse delectus consectetur voluptates eveniet quaerat commodi ducimus mollitia dolorem.</p> --}}
<ul class="list-group">
 @if(count($notifications) > 0)
    @foreach($notifications as $notification)
    <notification-item form-url="{{ route('apiService.notification.mark.one',['id' => $notification->id])}}" :notification='@json($notification)'>
      @include('utils.notifications.notification',['notification' => $notification])
    </notification-item>
    @endforeach
  @else
   <li class="list-group-item">¡Ka-boom! ¡No tenes notificaciones sin leer!</li>
  @endif
</ul>
<br>
  {{ $notifications->links() }}
   @if(count($notifications) > 0)

  <hr>
  <div class="card">
    <div class="card-body d-flex justify-content-between">
      <div>
      <h5>¿Marcar todas las notificaciones como leidas?</h5>
      <p class="mb-0"><i class="fas fa-info-circle"></i>&nbsp;Si desea, puede marcar todas las notificaciones como leidas.</p>
      </div>
      <div class="ml-2 pt-2 text-center">
        <a class="is-clickable text-info" onclick="event.preventDefault();document.getElementById('checkAll').submit();"><i class="fas fa-check-double fa-lg"></i></a>
        <form id="checkAll" action="{{route('panel.notifications.mark.all.form') }}" method="POST" style="display: none;">
            @csrf
        </form>
      </div>
    </div>
  </div>
  @endif

</section>

@endsection