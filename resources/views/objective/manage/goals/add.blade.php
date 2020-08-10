@extends('objective.manage.master')

@section('panelContent')

<section>
  <h1 class="">Nueva meta del objetivo</h1>
  <p>Para sumar una nueva a tu objetivo, completá los campos a continuación:</p>
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
  <form method="POST" action="{{ route('objectives.manage.goals.add.form',['objectiveId' => $objective->id]) }}">
    @csrf
    <div class="form-group">
      <label>Meta</label>
      <input type="text" class="form-control" name="title" placeholder="Escriba aquí">
    </div>
    <div class="form-group">
      <label>Indicador</label>
      <input type="text" class="form-control" name="indicator" placeholder="Escriba aquí">
      <small class="form-text text-muted">Solo puede haber un indicador por Meta. El indicador tiene ser mensurable, específico, asociado a un plazo de tiempo y lugar</small>
    </div>
    <div class="form-row">
      <div class="col">
        <div class="form-group">
          <label>Valor de meta (100%) del indicador</label>
          <input type="number" class="form-control" name="indicator_goal" placeholder="Ej: 100">
          <small class="form-text text-muted">¿A que valor hay que llegar? Este es valor que representa que se llego a completar la meta al 100%.</small>
        </div>

      </div>
      <div class="col">
        <div class="form-group">
          <label>Valor inicial del indicador <small class="text-info">Opcional</small></label>
          <input type="number" class="form-control" name="indicator_progress" placeholder="Ej: 0">
          <small class="form-text text-muted">Es el valor con la que comenzará la meta. Los reportes de actualización irán agregando (o restando). El campo vacio sera 0 </small>
        </div>
      </div>
    </div>
    <div class="form-row">
      <div class="col">
        <div class="form-group">
          <label>Unidad del indicador</label>
          <input type="text" class="form-control" name="indicator_unit" placeholder="Ej: Porcentaje, Tasa de Variación, Promedio, Número Índice">
          <small class="form-text text-muted">Unidad de calculo, es la forma en la que vamos a medir nuestro indicador: Porcentaje, Variación, Promedio, Número Índice. Ej: KMs, Metros, Arboles plantados, Etc.</small>
        </div>
      </div>
      <div class="col">
        <div class="form-group">
          <label>Frecuencia de monitoreo <small class="text-info">Opcional</small></label>
          <input type="text" class="form-control" name="indicator_frequency" placeholder="Ej: Semanal, mensual, semestral, anual, etc">
          <small class="form-text text-muted">Espacio temporal en el que vamos a medir nuestro indicador : Semanal, mensual, semestral, anual, etc.</small>
        </div>
      </div>
    </div>
    <div class="form-group">
      <label>Estado inicial de la meta</label>
      <select class="custom-select" name="status">
        <option value="ongoing" selected>En progreso</option>
        <option value="delayed" >Demorada</option>
        <option value="inactive" >Inactiva</option>
        <option value="reached" disabled>Alcanzada</option>
      </select>
      <small class="form-text text-muted">Nota: No puede crear una meta con estado "Alcanzado"</small>
    </div>
    <div class="form-group">
      <label>Fuente de los datos <small class="text-info">Opcional</small></label>
      <input type="text" class="form-control" name="source" placeholder="Escriba aquí">
      <small class="form-text text-muted">Es importante que la fuente de datos sean accesibles y oficiales para hacer transparente la medición</small>
    </div>
    <div class="form-group">
      <label>Hitos <small class="text-info">Opcional</small></label>
      <input-add-milestones-create-goal name="milestones">
    </div>
    <button type="submit" class="btn btn-primary">Crear</button>
  </form>
</section>

@endsection