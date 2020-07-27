@extends('objective.manage.master')

@section('panelContent')

<section>
  <h1 class="">Nuevo hito</h1>
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
  <form method="POST" action="{{ route('objective.manage.goals.milestones.add.form',['objectiveId' => $objective->id, 'goalId' => $goal->id]) }}">
    @csrf
    <div class="form-group">
      <label>Defina el hito</label>
      <input type="text" class="form-control" name="title" placeholder="Escriba aquí">
    </div>
    <button type="submit" class="btn btn-primary">Crear</button>
  </form>
</section>

@endsection