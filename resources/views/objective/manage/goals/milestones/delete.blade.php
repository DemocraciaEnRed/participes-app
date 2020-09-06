@extends('objective.manage.goals.master')

@section('panelContent')

<section>
  <h3 class="is-700">Eliminar el hito</h3>
  @if ($errors->any())
    <div class="alert alert-danger">
        <ul class="mb-0">
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
  @endif
  <p>Al eliminar el reporte, tenga en cuenta lo siguiente</p>
  <ul>
    <li>Debe asegurarse que el orden # de los hitos restantes tengan coherencia.</li>
  </ul>
  <form action="{{ route('objectives.manage.goals.milestones.delete.form',['objectiveId' => $objective->id, 'goalId' => $goal->id, 'milestoneId' => $milestone->id]) }}" method="POST">
    @method('DELETE')
    @csrf
    <div class="form-group">
      <label>Ingrese su contraseña</label>
      <input type="password" class="form-control" name="password">
      <small class="form-text text-muted">Para poder eliminar el reporte, ingrese su contraseña para confirmar.</small>
    </div>
    <button type="submit" class="btn btn-danger">Eliminar</button>
  </form>
</section>

@endsection