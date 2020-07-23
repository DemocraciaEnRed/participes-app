@extends('objective.manage.goals.master')

@section('panelContent')

<section>
  <h1 class="">Nuevo reporte</h1>
  <p>Lorem ipsum dolor sit amet consectetur, adipisicing elit. In eius ad officia tempora, temporibus repudiandae id ipsum neque deserunt rerum esse delectus consectetur voluptates eveniet quaerat commodi ducimus mollitia dolorem.</p>
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

  
  <form-new-report form-url="{{ route('objective.manage.goals.reports.add.form',['objId' => $objective->id, 'goalId' => $goal->id])}}" crsf-token="{{ csrf_token() }}" :goal='@json($goal)' :milestones='@json($goal->milestones)'>
    <div class="alert alert-light text-center">
      <p class="m-0"><i class="fas fa-sync fa-spin"></i>&nbsp;Cargando</p>
      <span class="text-smaller font-italic">Si no carga, intente recargar la pagina</span>
    </div>
  </form-new-report>
</section>

@endsection