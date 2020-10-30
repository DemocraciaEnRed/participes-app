@extends('objective.manage.master')

@section('panelContent')

<section>
  <h3 class="is-700">Nueva meta del objetivo</h3>
  <p class="lead">Para sumar una nueva meta a tu objetivo, completá los campos a continuación:</p>
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
      <label><b>Título de la meta</b><span class="text-danger">*</span></label>
      <input type="text" class="form-control" name="title" placeholder="Escriba aquí">
    </div>
    <div class="form-group">
      <label><b>Indicador</b><span class="text-danger">*</span></label>
      <input type="text" class="form-control" name="indicator" placeholder="Escriba aquí">
      <small class="form-text text-muted">Solo puede haber un indicador por Meta. El indicador tiene ser mensurable, específico, asociado a un plazo de tiempo y lugar</small>
    </div>
    <div class="form-row">
      <div class="col">
        <div class="form-group">
          <label><b>Valor de meta (100%) del indicador</b><span class="text-danger">*</span></label>
          <input type="number" class="form-control" min="1" name="indicator_goal" placeholder="Ej: 100">
          <small class="form-text text-muted">¿A que valor hay que llegar? Este es valor que representa que se llego a completar la meta al 100%.</small>
        </div>

      </div>
      <div class="col">
        <div class="form-group">
          <label><b>Valor inicial del indicador</b><span class="text-danger">*</span></label>
          <input type="number" class="form-control" min="0" name="indicator_progress" value="0" placeholder="Ej: 0">
          <small class="form-text text-muted">Es el valor con la que comenzará la meta. Los reportes de actualización irán agregando (o restando). El campo vacio será considerado como 0 </small>
        </div>
      </div>
    </div>
    <div class="form-row">
      <div class="col">
        <div class="form-group">
          <label><b>Unidad del indicador</b><span class="text-danger">*</span></label>
          <input type="text" class="form-control" name="indicator_unit" placeholder="Ej: Porcentaje, Tasa de Variación, Promedio, Número Índice">
          <small class="form-text text-muted">Unidad de calculo, es la forma en la que vamos a medir nuestro indicador: Porcentaje, Variación, Promedio, Número Índice. Ej: KMs, Metros, Arboles plantados, Etc.</small>
        </div>
      </div>
      <div class="col">
        <div class="form-group">
          <label><b>Frecuencia de monitoreo</b><small class="text-info">Opcional</small></label>
          <input type="text" class="form-control" name="indicator_frequency" placeholder="Ej: Semanal, mensual, semestral, anual, etc">
          <small class="form-text text-muted">Espacio temporal en el que vamos a medir nuestro indicador : Semanal, mensual, semestral, anual, etc.</small>
        </div>
      </div>
    </div>
    <div class="form-group">
      <label><b>Estado inicial de la meta</b><span class="text-danger">*</span></label>
      <select class="custom-select" name="status">
        <option value="ongoing" selected>En progreso</option>
        <option value="delayed" >No cumplida</option>
        <option value="inactive" >Inactiva</option>
        <option value="reached" disabled>Alcanzada</option>
      </select>
      <small class="form-text text-muted">Nota: No puede crear una meta con estado "Alcanzado"</small>
    </div>
    <div class="form-group">
      <label><b>Fuente de los datos</b> <small class="text-info">Opcional</small></label>
      <input type="text" class="form-control" name="source" placeholder="Escriba aquí">
      <small class="form-text text-muted">Es importante que la fuente de datos sean accesibles y oficiales para hacer transparente la medición</small>
    </div>
    <div class="form-group">
      <label><b>Hitos</b> <small class="text-info">Opcional</small></label>
      <input-add-milestones-create-goal name="milestones">
    </div>
    <div class="border border-light rounded p-3">
      <label class="is-700 "><i class="fas fa-paper-plane"></i>&nbsp;Enviar notificacion a suscriptores</label>
      @if(!$objective->hidden)
      <div class="custom-control custom-switch">
        <input type="checkbox" class="custom-control-input" name="notify" id="notify" value="true">
        <label class="custom-control-label is-clickable" for="notify">Notificar a los suscriptores</label>
      </div>
      @else
      <div class="alert alert-warning">
        <i class="fas fa-exclamation-triangle"></i>&nbsp;El objetivo se encuentra <i class="fas fa-eye-slash"></i> oculto, no se enviarán notificaciones a los usuarios.
      </div>
      @endif
      <small class="form-text text-muted">Se le enviará una notificación por email (si lo tienen habilitado) y por sistema, de que hay una nueva meta invitandolos a verla.</small>
    </div>
    <br>
    <button type="submit" class="btn btn-primary">Crear</button>
  </form>
</section>

@endsection