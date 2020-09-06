@extends('objective.manage.goals.master')

@section('panelContent')

<section>
  <h3 class="is-700">Editar un hito</h3>
  <p class="lead">Para editar el hito de la meta, completá el siguiente campo</p>
  @if ($errors->any())
  <div class="alert alert-danger">
    <ul class="mb-0">
      @foreach ($errors->all() as $error)
      <li>{{ $error }}</li>
      @endforeach
    </ul>
  </div>
  @endif
  <form action="{{ route('objectives.manage.goals.milestones.edit.form',['objectiveId' => $objective->id, 'goalId' => $goal->id, 'milestoneId' => $milestone->id]) }}" method="POST" enctype="multipart/form-data">
    @method('PUT')
    @csrf
    <div class="form-group">
      <label><b>Título del hito</b></label>
      <input type="text" class="form-control" name="title" placeholder="Escriba aquí" maxlength="550" value="{{$milestone->title}}">
    </div>
    <div class="form-group">
      <label><b>Orden # del hito</b></label>
      <input type="number" min="1" class="form-control" name="order" placeholder="Ingrese el #" value="{{$milestone->order}}">
    </div>
    <button type="submit" class="btn btn-primary">Editar</button>
  </form>  
</section>

@endsection
