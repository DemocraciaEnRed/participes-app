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
						<div class="mr-3 category-icon-container" style="background-color: {{$objective->category->backgroundColor()}}">
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
					<p>{{nl2br(e($objective->content))}}</p>
					<hr>
					<div class="my-3">
						<collapse>
							<h5 slot="title" class="is-700 my-2">Estados de las metas</h5>
								@forelse ($objective->goals as $goal)
								<div slot="content">
									<div class="my-1 d-flex justify-content-between align-items-center goal-container">
										<span class="text-truncate w-100">{{$goal->title}}</span>
										<div class="progress my-0 mx-1" style="height: 10px; width: 150px">
											<div class="progress-bar bg-{{$goal->status}}" role="progressbar" style="width: {{$goal->progressPercentage()}}%" aria-valuenow="{{$goal->progressPercentage()}}" aria-valuemin="0" aria-valuemax="100"></div>
										</div>
										<span class="goal-percentage text-smallest is-700 ml-1">{{$goal->progressPercentage()}}%</span>
									</div>
								</div>
								@empty
									<p slot="content" class="text-muted">No hay metas del objetivo</p>
								@endforelse
						</collapse>
					</div>
					@if(!empty($objective->organizations))
					<hr>
						<collapse>
								<h5 slot="title" class="is-700 my-2">Organizaciones</h5>
								<div slot="content">
									<objective-organizations-carrousel :slides='@json($objective->organizations)'>	
									</objective-organizations-carrousel>
								</div>
						</collapse>
					@endif
					@if(!empty($objective->members))
					<hr>
						<collapse>
								<h5 slot="title" class="is-700 my-2">Miembros del equipo</h5>
								<div slot="content">
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
						</collapse>
					@endif
					<hr>
					<collapse>
						<h5 slot="title" class="is-700 my-2">Archivos</h5>
						<div slot="content">
							@forelse ($objective->files as $file)
							<div class="card mb-2 shadow-sm">
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
					</collapse>
					<hr>
					<h5 class="is-700 mt-2 mb-4">Reportes</h5>
					<report-list fetch-url="{{route('apiService.objectives.reports',['objectiveId'=> $objective->id, 'size' => 3, 'with' =>'report_goal,report_latest_comments,report_actions', 'detailed' => true,  'order_by'=>'created_at,DESC'])}}" login-url="{{route('login')}}">
						@include('partials.loading')
					</report-list>
					{{-- @forelse ($reports as $report)
					<div class="card my-4 shadow-sm border-secondary">
						<div class="card-body text-secondary">
								<p class="mb-3 float-lg-right ml-lg-4  text-secondary text-right"><i class="{{$report->typeIcon()}} text-primary"></i>&nbsp;{{$report->typeLabel()}}</p>
								<h5 class="is-700 my-2"><a href="{{route('reports.index',['reportId' => $report->id])}}"class="text-secondary">{{$report->title}}</a></h5>
								<p class="text-smaller mb-0">{{nl2br(e(Str::limit($objective->content, 280, $end=' [...]')))}}</p>
								<p class="text-muted text-smaller my-2">Publicado {{$report->created_at->diffForHumans()}} por {{$report->author->name}} {{$report->author->surname}}</p>
								<div class="div d-flex justify-content-between mt-4">
									<div class="div">
										<a href="#" class="btn btn-outline-success btn-sm is-600">Estoy de acuerdo&nbsp;<i class="fas fa-check"></i>&nbsp;<span class="text-secondary is-700">{{$report->testimonies->count()}}</span></a>
										<a href="#" class="btn btn-outline-info btn-sm is-600">Quiero sumar información&nbsp;<i class="far fa-comment"></i>&nbsp;<span class="text-secondary is-700">{{$report->comments->count()}}</span></a>
									</div>
									<div>
										<a href="{{route('reports.index',['reportId' => $report->id])}}" class="btn btn-outline-primary btn-sm">Detalles&nbsp;<i class="fas fa-arrow-right"></i></a>
									</div>
								</div>
						</div>
					</div>
					@empty
					<p class="my-2 text-muted">No hay reportes del objetivo</p>
					@endforelse
					<div class="text-center">
						{{$reports->links()}}
					</div> --}}
					{{-- @forelse ($objective->files as $file)
					<div class="card mb-2 shadow-sm">
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
					@endforelse --}}

				</div>
			</div>
		</div>
	</div>
</div>
@endsection