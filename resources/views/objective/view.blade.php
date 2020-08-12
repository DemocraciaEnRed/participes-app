@php
	if(is_null($objective->cover)){
		$hideHeader = true;
	}
	$urlHeader = !is_null($objective->cover) ? $objective->cover->thumbnail_path : null;
	$heightHeader = !is_null($objective->cover) ? 400 : null;
	$currentRoute = Route::currentRouteName();
@endphp

@extends('layouts.app')

@section('content')
<div class="container {{ is_null($objective->cover) ? 'py-5' : null }}" style="{{ !is_null($objective->cover) ? 'margin-top: -350px;' : null}}" >
	<div class="row justify-content-center">
		<div class="col-md-4">
			@include('objective.menu')
		</div>
		<div class="col-md-8">
			{{-- <div class="rounded shadow-sm p-3 bg-primary mb-3 text-white">
				<h5 class="is-700 mb-0">Monitorea de cerca el objetivo!</h5>
				<p class="mb-0">Recibí notificaciones del objetivo y enterate de las ultimas</p>
			</div> --}}
			<div class="card shadow-sm">
				<div class="card-body">
					<div class="row my-4">
							<div class="col-sm-6">
								<collapse>
									<h5 slot="title" class="is-700 my-2">Descripción del objetivo</h5>
									<p slot="content" class="text-smaller">{{nl2br(e($objective->content))}}</p>
								</collapse>
							</div>
							@if(!empty($objective->organizations))
									<div class="col-sm-6">
								<collapse>
										<h5 slot="title" class="is-700 my-2">Organizaciones</h5>
										<div slot="content">
											<objective-organizations-carrousel :slides='@json($objective->organizations)'>	
											</objective-organizations-carrousel>
										</div>
								</collapse>
									</div>
							@endif
					</div>
					<hr>
					<div class="mb-4">
						<div class="clearfix mb-3">
							<a href="#" class="btn  my-1 ml-1 btn-sm btn-outline-primary is-600 float-right"><i class="fas fa-eye"></i>&nbsp;Monitorear</a>
				    	<h5 class="is-700 my-2 float-left">Estado de las metas</h5>
						</div>
						<portal-objective-stats fetch-url="{{route('apiService.objectives.stats',['objectiveId' => $objective->id])}}">
							@include('partials.loading')
						</portal-objective-stats>
					</div>
					<hr>
					<h5 class="is-700 mt-2 mb-4">Reportes</h5>
					@forelse ($reports as $report)
					<div class="card my-4 ml-lg-5 shadow-sm border-secondary">
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
					<p class="my-2 text-muted">No hay reportesdel objetivo</p>
					@endforelse
					<div class="text-center">
						{{$reports->links()}}
					</div>
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