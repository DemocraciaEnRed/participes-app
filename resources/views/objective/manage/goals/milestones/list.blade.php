@extends('objective.manage.goals.master')

@section('panelContent')

<section>
  <h1 class="">Hitos de la meta</h1>
  <h6 class="text-muted">Meta: {{$goal->title}}</h6>
  <p>Lorem ipsum dolor sit amet consectetur, adipisicing elit. In eius ad officia tempora, temporibus repudiandae id
    ipsum neque deserunt rerum esse delectus consectetur voluptates eveniet quaerat commodi ducimus mollitia dolorem.
  </p>
  @foreach ($goal->milestones as $milestone)
  <div class="card mb-3 shadow-sm">
    <div class="card-body d-flex justify-content-between">
    <div>
      <h6 class="card-subtitle text-muted m-0">Hito #{{$milestone->order}}</h6>
      <h6 class="card-title font-weight-bold m-0">{{$milestone->title}}</h6>
    </div>
    <div class="text-center" style="min-width: 100px">
      @if(is_null($milestone->completed))
      <h6 class="text-danger font-weight-bold m-0"><i class="fas fa-times fa-lg"></i></h6>
      <p class="text-muted text-smaller m-0">No completado</p>
      @else
      <h6 class="text-success font-weight-bold m-0"><i class="fas fa-check fa-lg"></i></h6>
      <p class="text-muted text-smaller m-0">Completado</p>
      @endif
    </div>
    </div>
  </div>
  @endforeach
   <div class="card mb-3 shadow-sm">
    <div class="card-body">
      <h6 class="card-title font-weight-bold m-0"><a href="{{ route('objective.manage.goals.milestones.add', ['objId' => $objective->id, 'goalId' => $goal->id]) }}">Crear nuevo hito <i class="fas fa-arrow-right"></i></a></h6>
    </div>
  </div>
</section>

@endsection
