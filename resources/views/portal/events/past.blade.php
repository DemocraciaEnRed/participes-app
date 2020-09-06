@extends('layouts.app')

@section('content')
@include('portal.events.header')
<div id="calendarList">
	@forelse($events as $event)
	@if($loop->odd)
	<div class="layout-one container">
		<div class="row justify-content-center align-items-center flex-column-reverse flex-md-row">
			<div class="col-md-7 column-text text-center text-md-left">
				<h5 class="text-muted my-2 is-700">@justdate($event->date) a las @justtime($event->date)</h3>
				<h4 class="my-2 is-600 mr-md-5 pr-md-5"><a href="{{route('events.index',['eventId' => $event->id])}}" class="text-dark">{{$event->title}}</a></h4>
				<div class="card shadow-sm my-4">
					<div class="card-body">
					<p class="text-muted">{{Str::limit($event->content, 150, $end=' [...]')}}</p>
					@if ($event->objectives->count() > 0)	
					<p class="text-info"><i class="fas fa-bullseye"></i>&nbsp;{{$event->objectives->count()}} objetivos estan relacionados con este evento</p>
					@endif
					<h6 class="text-dark mb-2 is-700"><i class="fas fa-calendar-alt"></i>&nbsp;{{$event->moment}}</h6>
					</div>
				</div>
					<a href="{{route('events.index',['eventId' => $event->id])}}" class="btn btn-light">Más información <i class="fas fa-arrow-right"></i></a>
				<br>
			</div>
			<div class="col-md-5 column-picture text-lg-right">
				@if ($event->photos->count() > 0)	
					<img src="{{asset($event->photos[0]->thumbnail_path)}}" class="image is-centered shadow custom-border">
				@else
					<img src="{{asset('img/event-default.png')}}" class="image is-centered shadow custom-border">
				@endif
			</div>
		</div>
	</div>
	@endif
	@if($loop->even)
	<div class="layout-two container">
		<div class="row justify-content-center align-items-center">
			<div class="col-lg-5 column-picture">
				@if ($event->photos->count() > 0)	
					<img src="{{asset($event->photos[0]->thumbnail_path)}}" class="image is-centered shadow custom-border">
				@else
					<img src="{{asset('img/event-default.png')}}" class="image is-centered shadow custom-border">
				@endif
			</div>
			<div class="col-lg-7 column-text text-center text-lg-right">
				<h5 class="text-muted my-2 is-700">@justdate($event->date) a las @justtime($event->date)</h3>
				<h4 class="my-2 is-600 ml-lg-5 pl-lg-5"><a href="{{route('events.index',['eventId' => $event->id])}}" class="text-dark">{{$event->title}}</a></h4>
				<div class="card shadow-sm my-4">
					<div class="card-body">
					<p class="text-muted">{{Str::limit($event->content, 150, $end=' [...]')}}</p>
					@if ($event->objectives->count() > 0)	
					<p class="text-info"><i class="fas fa-bullseye"></i>&nbsp;{{$event->objectives->count()}} objetivos estan relacionados con este evento</p>
					@endif
					<h6 class="text-dark mb-2 is-700"><i class="fas fa-calendar-alt"></i>&nbsp;{{$event->moment}}</h6>
					</div>
				</div>
					<a href="{{route('events.index',['eventId' => $event->id])}}" class="btn btn-light">Más información <i class="fas fa-arrow-right"></i></a>
				<br>
			</div>
		</div>
	</div>
	@endif
	@empty
	<div class="pt-5">
		<p class="text-center mb-1"><i class="far fa-surprise fa-2x"></i></p>
		<p class="text-center">Aún no se han celebrado eventos en el pasado</p>
	</div>
	@endforelse
</div>
<div class="container">
		{{$events->links()}}
</div>
@endsection