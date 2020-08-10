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
					<p class="text-smaller text-muted mb-0">Objetivo</p>
					<h5 class="is-700">
						{{$objective->title}}
					</h5>
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
						@forelse ($objective->goals as $goal)
            <li class="list-item my-1"><a href="{{route('goals.index',['goalId' => $goal->id])}}" class="text-primary">{{$goal->title}}</a></li>
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
					<div class="my-4">

					<portal-objective-stats fetch-url="{{route('apiService.objectives.stats',['objectiveId' => $objective->id])}}">
            @include('partials.loading')
					</portal-objective-stats>
					</div>
					<hr>
					<h5 class="is-600">Archivos</h5>
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
					<hr>
					<h5 class="is-600">Metas del objetivo</h5>
					@forelse ($objective->goals as $goal)
						<div class="my-4 d-flex justify-content-between align-items-center">
							<div>
								<h6 class="is-600 mb-0"><a href="{{ route('goals.index', ['goalId' => $goal->id]) }}" class="text-primary">{{$goal->title}}</a></h6>
								<h6 class="text-muted text-smaller">Indicador: {{$goal->indicator}}</h6>
							</div>
							<div class="text-right">
								<h6 class="text-info is-600 mb-1">{{$goal->progressPercentage()}}%</h6>
								{{-- <h6 class="text-muted text-smaller mt-0">Progreso</h6> --}}
								<div class="progress mb-0'" style="height:2px; width: 60px">
									<div class="progress-bar bg-info" role="progressbar" style="width:{{$goal->progressPercentage()}}%" aria-valuenow="{{$goal->progressPercentage()}}" aria-valuemin="0" aria-valuemax="100"></div>
								</div>
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