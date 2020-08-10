@extends('objective.manage.goals.master')

@section('panelContent')

<section>
  <h1 class="">Nuevo reporte</h1>
  <p>Podés hacer reportes sobre la meta. Tené en cuenta que existen tres tipos: el de avance (implica un aumento en el valor del indicador), el de hito (implica el cumplimiento de un acontecimiento importante) y el de novedad (utilizado para contar noticias generales,  relacionadas a la meta)</p>
  <hr>
  @if ($errors->any())
    <div class="alert alert-danger">
        <ul class="mb-0">
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
  @endif

  
  <form-new-report form-url="{{ route('objectives.manage.goals.reports.add.form',['objectiveId' => $objective->id, 'goalId' => $goal->id])}}" crsf-token="{{ csrf_token() }}" :goal='@json($goal)' :milestones='@json($goal->milestones)'>
    <div class="alert alert-light text-center">
      <p class="m-0"><i class="fas fa-sync fa-spin"></i>&nbsp;Cargando</p>
      <span class="text-smaller font-italic">Si no carga, intente recargar la pagina</span>
    </div>
  </form-new-report>
</section>

@endsection