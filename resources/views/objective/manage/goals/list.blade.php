@extends('objective.manage.master')

@section('panelContent')

<section>
  <h1 class="">Metas del objetivo</h1>
  <p>A continuación, encontrarás todas las metas asociadas a tu objetivo</p>
  @foreach ($objective->goals as $goal)
  <div class="card mb-3 shadow-sm">
    <div class="card-body d-flex justify-content-between align-items-center">
    <div>
      <h5 class="card-title font-weight-bold"><a href="{{ route('objectives.manage.goals.index', ['objectiveId' => $objective->id,'goalId' => $goal->id]) }}" class="text-primary">{{$goal->title}}</a></h5>
      <h6 class="card-subtitle text-muted">{{$goal->indicator}}</h6>
    </div>
    <div class="text-center">
      <h4 class="text-info font-weight-bold mb-0">{{round( ($goal->indicator_progress / $goal->indicator_goal)*100 )}}%</h4>
      <h6 class="text-muted mt-0">Progreso</h6>
    </div>
    </div>
  </div>
  @endforeach
</section>

@endsection
