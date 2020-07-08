@extends('objective.manage.goals.master')

@section('panelContent')

<section>
  <h1 class="">Hitos del objetivo</h1>
  <h6 class="text-muted">{{$goal->title}}</h6>
  <p>Lorem ipsum dolor sit amet consectetur, adipisicing elit. In eius ad officia tempora, temporibus repudiandae id
    ipsum neque deserunt rerum esse delectus consectetur voluptates eveniet quaerat commodi ducimus mollitia dolorem.
  </p>
  @foreach ($goal->milestones as $milestone)
  <div class="card mb-2">
    <div class="card-body d-flex justify-content-between">
    <div>
      <h6 class="card-subtitle text-muted m-0">Hito #{{$milestone->order}}</h6>
      <h6 class="card-title font-weight-bold m-0">{{$milestone->title}}</h6>
    </div>
    <div class="text-center" style="min-width: 120px">
      @if(is_null($milestone->completed))
      <h6 class="text-danger font-weight-bold mb-0"><i class="fas fa-times fa-lg"></i></h6>
      <h6 class="text-muted mt-0">No completado</h6>
      @else
      <h6 class="text-success font-weight-bold mb-0"><i class="fas fa-check fa-lg"></i></h6>
      <h6 class="text-muted mt-0">Completado</h6>
      @endif
    </div>
    </div>
  </div>
  @endforeach
   <div class="card mb-2">
    <div class="card-body">
      <h6 class="card-title font-weight-bold m-0"><a href="{{ route('objective.manage.goals.milestones.add', ['objId' => $objective->id, 'goalId' => $goal->id]) }}">Crear nuevo hito <i class="fas fa-arrow-right"></i></a></h6>
    </div>
  </div>
</section>

@endsection
