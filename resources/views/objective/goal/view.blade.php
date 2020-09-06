@php
	if(is_null($objective->cover)){
		$hideHeader = true;
	}
	$urlHeader = !is_null($objective->cover) ? $objective->cover->thumbnail_path : null;
	$heightHeader = !is_null($objective->cover) ? 400 : null;
@endphp

@section('metatags')
  @include('objective.goal.metatags')
@endsection

@extends('layouts.app')

@section('content')
<div class="container {{ is_null($objective->cover) ? 'py-5' : null }}" style="{{ !is_null($objective->cover) ? 'margin-top: -350px;' : null}}" >
	<div class="row justify-content-center">
		<div class="col-md-4">
			@include('objective.menu')
		</div>
		<div class="col-md-8">
			@include('objective.subscribe')
			<div class="card shadow-sm mb-3">
				<div class="card-body p-3">
					<div class="d-flex align-items-center mb-3">
						<div class="mr-3 category-icon-container">
							<i class="far fa-2x fa-fw fa-dot-circle text-{{$goal->status}}"></i>
						</div>
						<div class="w-100">
							<span class="text-{{$goal->status}}">Meta {{$goal->status_label}}</span>
							<h4 class="is-700 m-0">
								{{$goal->title}}
							</h4>
						</div>
					</div>
          <div class="row my-2">
            <div class="col-md-6">
					    <h6 class="is-700">Calculo del indicador</h6>
					    <p>{{$goal->indicator}}</p>
            </div>
            <div class="col-md-6">
					    <h6 class="is-700">Progreso</h6>
					   <div class="my-1 d-flex justify-content-between align-items-center goal-container">
								<div class="progress my-0 mx-1 w-100" style="height: 10px;">
									<div class="progress-bar bg-{{$goal->status}}" role="progressbar" style="width: {{$goal->progress_percentage}}%" aria-valuenow="{{$goal->progress_percentage}}" aria-valuemin="0" aria-valuemax="100"></div>
								</div>
								<span class="goal-percentage text-smallest is-700 ml-1">{{$goal->progress_percentage}}%</span>
							</div>
            </div>
          </div>
          <div class="row my-2">
            <div class="col-md-6">
					    <h6 class="is-700">Unidad del indicador</h6>
					    <p>{{$goal->indicator_unit}}</p>
            </div>
            <div class="col-md-6">
					    <h6 class="is-700">Frecuencia del indicador</h6>
					    <p>{{$goal->indicator_frequency}}</p>
            </div>
          </div>
          <div class="row my-2">
            <div class="col-md-6">
					    <h6 class="is-700">Valor a alcanzar</h6>
					    <p>{{$goal->indicator_goal}}</p>
            </div>
            <div class="col-md-6">
					    <h6 class="is-700">Valor actual</h6>
					    <p>{{$goal->indicator_progress}}</p>
            </div>
          </div>
					@if($goal->source)
          <div class="my-2">
					    <h6 class="is-700">Fuente</h6>
					    <p>{{$goal->source}}</p>
          </div>
					@endif
          <hr>
					<div class="clearfix is-clickable" data-toggle="collapse" data-target="#collapseMilestones">
						<h5 class="is-700 h5 text-body my-2 float-left">Hitos de la meta</h5>
						<h5 class="is-700 h5 text-body my-2 float-right"><i class="fas fa-angle-down"></i></h5>
					</div>
					<div id="collapseMilestones" class="collapse">
						@forelse ($goal->milestones as $milestone)
							<p>
								<span class="text-muted">Hito #{{$milestone->order}} - </span><span class="is-700">{{$milestone->title}}</span><br/>
								<span class="text-smallest text-muted"> 
								 	@if(is_null($milestone->completed))
                  <i class="text-danger fas fa-times fa-fw"></i>
                  No completado
                  @else
                  <i class="text-success fas fa-check"></i>
                  Completado - 
									<span class="text-muted">Fecha de completado: @justdate($milestone->completed) - <a href="{{route('reports.index',['reportId' => $milestone->report->id])}}">Ver el reporte<i class="fas fa-arrow-right fa-fw"></i></a></span>
                  @endif
								</span>
							</p>
							@empty
							<p class="my-2 text-muted">No hay hitos asociados</p>
							@endforelse
					</div>
          <hr>
					<div class="clearfix mt-2 mb-4">
						<h5 class="is-700 float-left">Reportes</h5>
						@isMember($objective->id)
					    <a href="{{route('objectives.manage.goals.reports.add',['objectiveId'=> $objective->id, 'goalId' => $goal->id])}}" class="btn btn-primary btn-sm float-right"><i class="fas fa-plus"></i> Nuevo reporte</a>
						@endisMember
					</div>
					<report-list fetch-url="{{route('apiService.goals.reports',['goalId'=> $goal->id, 'size' => 3, 'with' =>'report_goal,report_latest_comments,report_actions', 'detailed' => true, 'order_by'=>'date,DESC'])}}" login-url="{{route('login')}}">
						@include('partials.loading')
					</report-list>
				</div>
			</div>
		</div>
	</div>
</div>
@endsection