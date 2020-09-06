@php
	if(is_null($objective->cover)){
		$hideHeader = true;
	}
	$urlHeader = !is_null($objective->cover) ? $objective->cover->thumbnail_path : null;
	$heightHeader = !is_null($objective->cover) ? 400 : null;
	$currentRoute = Route::currentRouteName();
@endphp

@section('metatags')
  @include('objective.metatags')
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
			<div class="card shadow-sm">
				<div class="card-body">
					<div class="d-flex align-items-center mb-3">
						<div class="mr-3 category-icon-container" style="background-color: {{$objective->category->background_color}}">
							<i class="fa-2x fa-fw {{$objective->category->icon}}" style="color: {{$objective->category->color}}"></i>
						</div>
						<div class="w-100">
							<span class="" style="color:{{$objective->category->color}}">{{$objective->category->title}}</span>
							<h4 class="is-700 m-0">
								{{$objective->title}}
							</h4>
						</div>
					</div>
						<div class="card border-light mb-3">
							<div class="card-body py-4">
								<portal-objective-stats fetch-url="{{route('apiService.objectives.stats',['objectiveId' => $objective->id])}}">
									@include('partials.loading')
								</portal-objective-stats>
							</div>
						</div>
					<p>{!! nl2br(e($objective->content)) !!}</p>
					<hr>
					<div class="my-3">
						<div class="clearfix is-clickable" data-toggle="collapse" data-target="#collapseGoalStatus">
						<h5 class="is-700 h5 text-body my-2 float-left">Estados de las metas</h5>
						<h5 class="is-700 h5 text-body my-2 float-right"><i class="fas fa-angle-down fa-lg"></i></h5>
						</div>
						<div id="collapseGoalStatus" class="collapse">
							@forelse ($objective->goals as $goal)
							<div slot="content">
								<div class="my-1 d-flex justify-content-between align-items-center goal-container">
									<span class="text-truncate w-100">{{$goal->title}}</span>
									<div class="progress my-0 mx-1" style="height: 10px; width: 150px">
										<div class="progress-bar bg-{{$goal->status}}" role="progressbar" style="width: {{$goal->progress_percentage}}%" aria-valuenow="{{$goal->progress_percentage}}" aria-valuemin="0" aria-valuemax="100"></div>
									</div>
									<span class="goal-percentage text-smallest is-700 ml-1">{{$goal->progress_percentage}}%</span>
								</div>
							</div>
							@empty
								<p slot="content" class="text-muted">No hay metas del objetivo</p>
							@endforelse
						</div>
					</div>
					@if(!$objective->organizations->isEmpty())
					<hr>
					<div class="clearfix is-clickable" data-toggle="collapse" data-target="#collapseOrganizations">
						<h5 class="is-700 h5 text-body my-2 float-left">Organizaciones</h5>
						<h5 class="is-700 h5 text-body my-2 float-right"><i class="fas fa-angle-down fa-lg"></i></h5>
					</div>
					<div id="collapseOrganizations" class="collapse show">
						<objective-organizations-carrousel :slides='@json($objective->organizations)'>	
						</objective-organizations-carrousel>
					</div>
					@endif
					@if(!empty($objective->members))
					<hr>
					<div class="clearfix is-clickable" data-toggle="collapse" data-target="#collapseMembers">
						<h5 class="is-700 h5 text-body my-2 float-left">Miembros del equipo</h5>
						<h5 class="is-700 h5 text-body my-2 float-right"><i class="fas fa-angle-down fa-lg"></i></h5>
					</div>
					<div id="collapseMembers" class="collapse">
						<div class="my-1 row justify-content-center">
								@foreach ($objective->members as $member)
								<div class="col-6 col-sm-4 col-md-3 text-center py-1">
									<p class="mb-1">@include('utils.avatar',['avatar' => $member->avatar, 'size' => 50, 'thumbnail' => true])</p>
									<span class="is-700 text-smaller">{{$member->name}} {{$member->surname}}</span>
									<br><span class="text-smaller text-muted">{{$member->pivot->role == 'reporter' ? 'Reporta' : 'Coordina'}}</span>
								</div>
								@endforeach
							</div>
					</div>
					@endif
					<hr>
					<div class="clearfix is-clickable" data-toggle="collapse" data-target="#collapseFiles">
						<h5 class="is-700 h5 text-body my-2 float-left">Archivos</h5>
						<h5 class="is-700 h5 text-body my-2 float-right"><i class="fas fa-angle-down fa-lg"></i></h5>
					</div>
					<div id="collapseFiles" class="collapse">
							@forelse ($objective->files as $file)
							<div class="card my-2 shadow-sm">
								<div class="card-body p-2 pl-4 pr-4 d-flex">
									<div class="mr-3 mt-2">
										<i class="far fa-file fa-lg"></i>
									</div>
									<div class="flex-fill">
										<p class="mb-0 text-smaller word-wrap-anywhere">{{ $file->name }}</p>
										<p class="text-card text-smaller text-muted mb-0">{{ $file->mime }}</p>
									</div>
									<div class="ml-3 mt-2">
										<a href="{{ asset($file->path) }}" class="card-link text-smaller"><i class="fas fa-download fa-lg"></i></a>
									</div>
								</div>
							</div>
							@empty
							<p class="my-2 text-muted">No hay archivos adjuntos al objetivo</p>
							@endforelse
					</div>
					<hr>
					<h5 class="is-700 mt-2 mb-4">Reportes</h5>
					<report-list fetch-url="{{route('apiService.objectives.reports',['objectiveId'=> $objective->id, 'size' => 3, 'with' =>'report_goal,report_latest_comments,report_actions', 'detailed' => true,  'order_by'=>'date,DESC'])}}" login-url="{{route('login')}}">
						@include('partials.loading')
					</report-list>
				</div>
			</div>
		</div>
	</div>
</div>
@endsection