@extends('objective.manage.master')

@section('panelContent')

<section>
  <h1 class="">Nuevo hito</h1>
  <p>Para sumar un nuevo hito a la meta, completá el siguiente campo</p>
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
  <form method="POST" action="{{ route('objectives.manage.goals.milestones.add.form',['objectiveId' => $objective->id, 'goalId' => $goal->id]) }}">
    @csrf
    <div class="form-group">
      <label>Defina el hito</label>
      <input type="text" class="form-control" name="title" placeholder="Escriba aquí">
    </div>
    <button type="submit" class="btn btn-primary">Crear</button>
  </form>
</section>

@endsection