@section('metatags')
  @include('report.metatags')
@endsection

@section('stylesheets')
<link href='https://api.mapbox.com/mapbox-gl-js/v1.11.1/mapbox-gl.css' rel='stylesheet' />
@endsection

@section('headscripts')
<script src='https://api.mapbox.com/mapbox-gl-js/v1.11.1/mapbox-gl.js'></script>
@endsection

@extends('layouts.app')

@section('content')
<div class="container push-to-header">
  <div class="card shadow-sm mb-3">
    <div class="card-body p-3 p-lg-5">
      <div class="d-flex justify-content-between d-column">
        <h5 class="text-muted align-self-end mb-2"><i class="{{$report->type_icon}} fa-lg text-primary"></i>&nbsp;&nbsp;Reporte de
          {{$report->type_label}}</h5>
        @isMember($objective->id)
        <a href="{{route('objectives.manage.goals.reports.index',['objectiveId' => $objective->id, 'goalId' => $goal->id, 'reportId' => $report->id])}}"
          class="ml-2 mb-3 btn btn-sm btn-primary"><i class="fas fa-edit"></i>&nbsp;Editar</a>
        @endisMember
      </div>
      <h2 class="is-600 my-2">{{$report->title}}</h2>
      <h6 class="text-muted my-2">Fecha del reporte: @justdate($report->date)</h6>
      <h6 class="text-muted my-2">Publicado el @datetime($report->created_at)</h6>

      <div class="is-size-5 my-5">
        {!! nl2br(e($report->content)) !!}
      </div>

      <div class="row mb-2">
        <div class="col-md-4 my-2">
          <h5 class="is-700">Tags del reporte</h5>
          <ul class="list-inline mb-0">
            @forelse ($report->tags ?: [] as $tag)
            <li class="list-inline-item">{{$tag}}</li>
            @empty
            <li class="list-inline-item text-muted">No hay tags</li>
            @endforelse
          </ul>
        </div>
        <div class="col-md-4 my-2 text-left text-md-center">
          <h5 class="is-700">Autor del reporte</h5>
          @include('utils.avatar',['avatar' => $report->author->avatar, 'size' => 32, 'thumbnail' => true])
          {{$report->author->name}} {{$report->author->surname}}
        </div>
        <div class="col-md-4 my-2 text-left text-md-right">
          <h5 class="is-700">Feedbacks</h5>
          {{$report->positive_testimonies}} <i class="far fa-thumbs-up"></i>
        </div>
      </div>
    </div>
  </div>
  @include('report.testimony')
  @include('report.progress')
  @include('report.milestone')
  @include('report.status')
  @include('report.data')
  @include('report.files')
  @include('report.album')
  @include('report.map')
  <div class="card shadow-sm mb-3" id="comentarios">
    <div class="card-body p-3 p-lg-5">
      <report-comments fetch-url="{{ route('apiService.reports.comments',['reportId' => $report->id]) }}"
        comment-url="{{ route('apiService.reports.comments.create',['reportId' => $report->id]) }}"
        :user="{{ Auth::user() ?  Auth::user()->load(['avatar']) : 'null' }}">
        @include('partials.loading')
      </report-comments>
    </div>
  </div>
  @if(!empty($objective->communities()))
   <div class="card shadow-sm text-center my-3">
     <div class="card-body p-3 p-lg-5">
      <h4 class="is-700 mb-2">¡Seguí acompañandonos en nuestra comunidad!</h4>
      @foreach($objective->communities as $community)
        <a href="{{$community->url}}" target="_blank" class="py-2 px-3 rounded d-inline-block my-1 mb-1" style="border: 2px solid {{$community->color}}; color: {{$community->color}}"><i class="{{$community->icon}}"></i>&nbsp;{{$community->label}}</a>
      @endforeach
     </div>
   </div>
  @endif
</div>
@endsection