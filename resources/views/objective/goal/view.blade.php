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
							<span class="text-{{$goal->status}}">Meta {{$goal->statusLabel()}}</span>
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
									<div class="progress-bar bg-{{$goal->status}}" role="progressbar" style="width: {{$goal->progressPercentage()}}%" aria-valuenow="{{$goal->progressPercentage()}}" aria-valuemin="0" aria-valuemax="100"></div>
								</div>
								<span class="goal-percentage text-smallest is-700 ml-1">{{$goal->progressPercentage()}}%</span>
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
          <div class="my-2">
					    <h6 class="is-700">Fuente</h6>
					    <p>{{$goal->source}}</p>
          </div>
 
          <hr>
							<collapse>
						<h5 slot="title" class="is-700 my-2">Hitos de la meta</h5>
						<div slot="content">
							@forelse ($goal->milestones as $milestone)
              <div class="card my-2 shadow-sm ">
                <div class="card-body p-3 d-flex justify-content-between align-items-center">
                <div>
                  <p class="m-0 text-smaller text-muted">Hito #{{$milestone->order}}</p>
                  <p class="m-0 is-600">{{$milestone->title}}</p>
                  @if(!is_null($milestone->completed))
										<p class="m-0 text-muted text-smallest">Fecha de completado: @justdate($milestone->completed) - <a href="{{route('reports.index',['reportId' => $milestone->report->id])}}">Ver el reporte<i class="fas fa-arrow-right fa-fw"></i></a></p>
									@endif
                </div>
                <div class="text-center" style="min-width: 100px">
                  @if(is_null($milestone->completed))
                  <i class="text-danger fas fa-times fa-lg"></i><br>
                  <span class="text-muted text-smaller">No completado</span>
                  @else
                  <i class="text-success fas fa-check fa-lg"></i><br>
                  <span class="text-muted text-smaller">Completado</span>
                  @endif
                </div>
                </div>
              </div>
							@empty
							<p class="my-2 text-muted">No hay hitos asociados</p>
							@endforelse
						</div>
					</collapse>
          <hr>
					<h5 class="is-700 mt-2 mb-4">Reportes</h5>
					<report-list fetch-url="{{route('apiService.goals.reports',['goalId'=> $goal->id, 'size' => 3, 'with' =>'report_goal,report_latest_comments,report_actions', 'detailed' => true, 'order_by'=>'created_at,DESC'])}}" login-url="{{route('login')}}">
						@include('partials.loading')
					</report-list>
				</div>
			</div>
		</div>
	</div>
</div>
@endsection