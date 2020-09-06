@extends('objective.manage.goals.master')

@section('panelContent')

<section>
  <h3 class="is-700">Hitos de la meta</h3>
  <p class="lead">Un hito es un acontecimiento importante y necesario para el cumplimiento de la meta, sin embargo, no responde a un indicador concreto ni representa un avance en términos cuantitativos. Podrás hacer reportes para informar el cumplimiento  de estos hitos.</p>
  @foreach ($goal->milestones as $milestone)
  <div class="card mb-3 shadow-sm">
    <div class="card-body d-flex align-items-center">
    <div class="w-100">
    	<span class="text-muted text-smaller">Hito #{{$milestone->order}}</span><br><span class="is-700">{{$milestone->title}}</span><br/>
      <span class="text-muted text-smaller"> 
        @if(is_null($milestone->completed))
        <i class="text-danger fas fa-times fa-fw"></i>
        No completado
        @else
        <i class="text-success fas fa-check"></i>
        Completado - 
        <span class="">Fecha de completado: @justdate($milestone->completed) - <a href="{{route('reports.index',['reportId' => $milestone->report->id])}}">Ver el reporte<i class="fas fa-arrow-right fa-fw"></i></a></span>
        @endif
      </span>
    </div>
     <div class="text-right">
        <a href="{{ route('objectives.manage.goals.milestones.edit',['objectiveId' => $objective->id, 'goalId' => $goal->id, 'milestoneId' => $milestone->id]) }}" class="btn btn-link btn-sm"><i class="fas fa-pencil-alt fa-fw"></i>Editar</a>
        <a href="{{ route('objectives.manage.goals.milestones.delete',['objectiveId' => $objective->id, 'goalId' => $goal->id, 'milestoneId' => $milestone->id]) }}" class="btn btn-link btn-sm"><i class="fas fa-trash-alt fa-fw"></i>Eliminar</a>
      </div>
    </div>
  </div>
  @endforeach
   <a href="{{ route('objectives.manage.goals.milestones.add', ['objectiveId' => $objective->id, 'goalId' => $goal->id]) }}" class="btn btn-block btn-primary">Crear nuevo hito <i class="fas fa-plus"></i></a>
</section>

@endsection
