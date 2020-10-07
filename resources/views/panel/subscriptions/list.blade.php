@extends('panel.master')

@section('panelContent')

<section>
<h3 class="is-700">Mis suscripciones</h3>
<p class="lead">A continuación, podrás ver el listado de objetivos que estás monitoreando actualmente</p>
 @if(count($subscriptions) > 0)
    @foreach($subscriptions as $objective)
    <div class="card my-3 shadow-sm">
      <div class="card-body d-flex align-items-start">
          <div class="mr-3 category-icon-container" style="background-color: {{$objective->category->background_color}}">
            <i class="fa-2x fa-fw {{$objective->category->icon}}" style="color: {{$objective->category->color}}"></i>
          </div>
          <div class="w-100">
            <span class="" style="color:{{$objective->category->color}}">{{$objective->category->title}}</span>
            <h4 class="is-700 my-1">
              <a href="{{route('objectives.index',['objectiveId' => $objective->id])}}" class="text-dark">{{$objective->title}}</a>
            </h4>
            <p class="text-muted text-smaller my-1">{{Str::limit($objective->content, 200, $end=' [...]')}}</p> 
            <p class="text-muted text-smaller mb-0">Suscripto el @datetime($objective->pivot->created_at)</p>
          </div>
          <div class="ml-3 text-center">
            <a onclick="event.preventDefault();document.getElementById('unsub{{$objective->id}}').submit();" class="text-dark is-clickable"><i class="fas fa-times fa-circle fa-2x"></i></a>
            <span class="text-smallest">Desuscribirse</span>
            <form id="unsub{{$objective->id}}" action="{{route('panel.subscriptions.unsubscribe.form',['objectiveId' => $objective->id]) }}" method="POST" style="display: none;">
              @csrf
            </form>
          </div>
      </div>
    </div>
    @endforeach
  @else
    <div class="card mb-3 shadow-sm">
      <div class="card-body text-center">
        <h6 class="card-title mb-2"><i class="far fa-surprise"></i>&nbsp;No estás suscripto a ningun objetivo</h6>
        <p class="text-smaller mb-0">¡Suscribite a tus objetivos favoritos y recibi notificaciones!</p>
      </div>
    </div>
  @endif
  {{ $subscriptions->links() }}

</section>

@endsection