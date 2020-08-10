@php
	if(is_null($objective->cover)){
		$hideHeader = true;
	}
	$urlHeader = !is_null($objective->cover) ? $objective->cover->thumbnail_path : null;
	$heightHeader = !is_null($objective->cover) ? 400 : null;
@endphp

@extends('layouts.app')

@section('content')
<div class="container {{ is_null($objective->cover) ? 'py-5' : null }}" style="{{ !is_null($objective->cover) ? 'margin-top: -350px;' : null}}" >
	<div class="row justify-content-center">
		<div class="col-md-4">
			<div class="card shadow-sm rounded">
				@if(!is_null($objective->cover))
				  <div class="card-img-top has-background-image" alt="Card image cap" style="height:200px; background-image:url('{{$objective->cover->thumbnail_path}}')"></div>
				@endif
				<div class="card-body">
					<p class="text-smaller text-muted mb-0">Meta</p>
					<h5 class="is-700">
						{{$goal->title}}
					</h5>
					<p class="text-smaller text-muted mb-0">Objetivo</p>
					<h6 class="is-500">
						<a href="{{route('objectives.index',['objectiveId' => $objective->id])}}" class="text-dark">{{$objective->title}}</a>
					</h6>
					<ul class="list-inline mb-0">
            @forelse ($objective->tags as $tag)
            <li class="list-inline-item"><span class="text-muted">{{$tag}}</span></li>
            @empty
            <li class="list-inline-item text-muted">No hay tags</li>
            @endforelse
          </ul>
					<hr>
					<h5 class="is-600">Metas</h5>
					<ul class="list-unstyled">
						@forelse ($objective->goals as $auxGoal)
            <li class="list-item my-1"><a href="{{route('goals.index',['goalId' => $auxGoal->id])}}" class="text-primary">{{$auxGoal->title}}</a></li>
            @empty
            <li class="list-item my-1 text-muted">No hay metas</li>
            @endforelse
					</ul>
				</div>
			</div>
		</div>
		<div class="col-md-8">
			<div class="card shadow-sm mb-3">
				<div class="card-body p-3">
          <div class="row my-4">
            <div class="col-md-6 text-center">
					    <h5 class="is-700">Estado de la meta</h5>
					    <h3 class="is-500 text-primary">{{$goal->statusLabel()}}</h3>
            </div>
            <div class="col-md-6 text-center">
					    <h5 class="is-700">Hitos</h5>
					    <h3 class="is-500 text-primary">{{$goal->milestones->count()}}</h3>
            </div>
          </div>
          <hr>
					<h5 class="is-600">Hitos</h5>
            @foreach ($goal->milestones as $milestone)
              <div class="card mb-3 shadow-sm">
                <div class="card-body d-flex justify-content-between">
                <div>
                  <h6 class="card-subtitle text-muted m-0">Hito #{{$milestone->order}}</h6>
                  <h6 class="card-title font-weight-bold m-0">{{$milestone->title}}</h6>
                </div>
                <div class="text-center" style="min-width: 100px">
                  @if(is_null($milestone->completed))
                  <h6 class="text-danger font-weight-bold m-0"><i class="fas fa-times fa-lg"></i></h6>
                  <p class="text-muted text-smaller m-0">No completado</p>
                  @else
                  <h6 class="text-success font-weight-bold m-0"><i class="fas fa-check fa-lg"></i></h6>
                  <p class="text-muted text-smaller m-0">Completado</p>
                  @endif
                </div>
                </div>
              </div>
              @endforeach
          <hr>
					<h5 class="is-600">Reportes</h5>
					@forelse ($goal->reports as $report)
						<div class="my-4 d-flex justify-content-between align-items-center">
							<div>
								<h6 class="is-600 mb-0"><a href="{{ route('reports.index', ['reportId' => $report->id]) }}" class="text-primary">{{$report->title}}</a></h6>
								<h6 class="text-muted text-smaller">Publicado el @datetime($report->created_at) - Fecha reporte: @datetime($report->date)</h6>
							</div>
						  <div class="text-center" style="min-width: 70px">
								@if($report->type == "post")
								<h6 class="text-secondary m-0"><i class="fas fa-bullhorn fa-lg"></i></h6>
								<p class="text-secondary text-smaller m-0">Novedad</p>
								@elseif($report->type == "progress")
								<h6 class="text-secondary m-0"><i class="fas fa-fast-forward fa-lg"></i></h6>
								<p class="text-secondary text-smaller m-0">Avance</p>
								@elseif($report->type == "milestone")
								<h6 class="text-secondary m-0"><i class="fas fa-medal fa-lg"></i></h6>
								<p class="text-secondary text-smaller m-0">Hito</p>
								@endif
							</div>
						</div>
						@empty
						<div class="my-4">
							<span class="text-muted">No hay metas del objetivo</span>
						</div>
						@endforelse
				</div>
			</div>
		</div>
	</div>
</div>
@endsection