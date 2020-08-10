@extends('panel.master')

@section('panelContent')

<section>
<h1 class="">Notificaciones</h1>
{{-- <p>Lorem ipsum dolor sit amet consectetur, adipisicing elit. In eius ad officia tempora, temporibus repudiandae id ipsum neque deserunt rerum esse delectus consectetur voluptates eveniet quaerat commodi ducimus mollitia dolorem.</p> --}}
<ul class="list-group">
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
<br>
  {{ $notifications->links() }}


</section>

@endsection