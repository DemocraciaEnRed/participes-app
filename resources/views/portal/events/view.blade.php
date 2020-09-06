@php
    $hideHeader = true;
    $titleEncode = urlencode($event->title);
    $descriptionEncode = urlencode('Mas información: ' . route('events.index',['eventId' => $event->id]));
    $locationEncode = urlencode($event->address);
    $start = urlencode($event->date->format('Ymd\THis'));
    $end = urlencode($event->date->addHour()->format('Ymd\THis'));
    $ctz = urlencode('America/Argentina/Buenos_Aires');
@endphp

@extends('layouts.app')

@section('metatags')
  @include('portal.events.metatags')
@endsection

@section('content')
	@if ($event->photos->count() > 0)	
  <div class="app-portal-header has-background-image" style="background-image: url('{{asset($event->photos[0]->path)}}')">
  @else
  <div class="app-portal-header">
  @endif
    <div class="app-portal-header-overlay py-5" style="height:auto">
      <div class="container py-5 text-center">
        <span class="text-primary h4 bg-white is-400">
          {{$event->moment}}
        </span>
        <br>
        <span class="text-white h2 is-700 mb-0">
          {{$event->title}}
        </span>
        @hasRole('admin')
        <div class="mt-3">
          <a href="{{route('admin.events.edit',['eventId'=> $event->id])}}" class="btn btn-secondary"><i class="fas fa-edit"></i> Editar</a>
        </div>
        @endhasRole
      </div>
    </div>
  </div>
  <div class="container" style="margin-top: -50px;">
  <div class="row justify-content-center">
    <div class="col-12 col-md-8">
      <div class="card my-3 p-4">
        <div class="card-body">
          <p>{!! nl2br(e($event->content)) !!}<p>
          
          <h5 class="is-700 my-4">Links</h5>
          @if($event->urls)
          @foreach ($event->urls as $label => $url)              
          <span class="py-1 px-3 bg-primary rounded mr-2 mb-1 d-inline-block"><i class="fas fa-link text-white"></i>&nbsp;<a href="{{$url}}" target="_blank" class="text-white is-600">{{$label}}</a></span>
          @endforeach
          @else
          <span class="text-muted">No se han previsto links acerca del evento</span>
          @endif
        </div>
      </div>
      <div class="card my-3 p-4">
        <div class="card-body">
          <div class="row mb-3">
            <div class="col">
              <h5 class="is-700">Fecha</h5>
              <h3 class="text-primary is-400">@justdate($event->date)</h3>
            </div>
            <div class="col">
              <h5 class="is-700">Hora</h5>
              <h3 class="text-primary is-400">@justtime($event->date)</h3>
            </div>
          </div>
          <div class="">
          <h5 class="is-700">Dirección</h5>
              <h5 class="text-primary is-400">{{$event->address}}</h5>
          </div>
        </div>
      </div>
          <a class="btn btn-block btn-primary btn-lg my-3" target="_blank" href="https://calendar.google.com/calendar/r/eventedit?action=TEMPLATE&text={{$titleEncode}}&details={{$descriptionEncode}}&location={{$locationEncode}}&dates={{$start}}/{{$end}}&ctz={{$ctz}}">
          <i class="fab fa-google fa-fw"></i><i class="fas fa-calendar-plus fa-fw"></i> Agregar a Google Calendar</a>
      @include('portal.events.album')
      @include('portal.events.objectives')
    </div>
  </div>
  </div>
@endsection