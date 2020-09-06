@extends('objective.manage.goals.master')

@section('panelContent')

<section>
  <h3 class="is-700">Editar meta del objetivo</h3>
  <p class="lead">Podes editar la meta del objetivo aqui. Completá los campos a continuación:</p>
  @if ($errors->any())
  <div class="alert alert-danger">
      <ul class="mb-0">
          @foreach ($errors->all() as $error)
              <li>{{ $error }}</li>
          @endforeach
      </ul>
  </div>
  @endif
  @if($goal->has('reports'))
  <div class="alert alert-warning">
    <h6 class="is-700"><i class="fas fa-exclamation-triangle"></i> Importante</h6>
    El objetivo cuenta con reportes. Si alguno de los campos compromete alguna información con respecto a los reportes, recuerde hacer las ediciones correspondientes en los mismos.
  </div>
  @endif
  <form method="POST" action="{{ route('objectives.manage.goals.edit.form',['objectiveId' => $objective->id, 'goalId' => $goal->id]) }}">
    @method('PUT')
    @csrf
    <div class="form-group">
      <label>Título de la meta</label>
      <input type="text" class="form-control" name="title" placeholder="Escriba aquí" value="{{$goal->title}}">
    </div>
    <div class="form-group">
      <label>Indicador</label>
      <input type="text" class="form-control" name="indicator" placeholder="Escriba aquí" value="{{$goal->indicator}}">
      <small class="form-text text-muted">Solo puede haber un indicador por Meta. El indicador tiene ser mensurable, específico, asociado a un plazo de tiempo y lugar</small>
    </div>
    <div class="form-row">
      <div class="col">
        <div class="form-group">
          <label>Valor de meta (100%) del indicador</label>
          <input type="number" class="form-control" min="1" name="indicator_goal" placeholder="Ej: 100" value="{{$goal->indicator_goal}}">
          <small class="form-text text-muted">¿A que valor hay que llegar? Este es valor que representa que se llego a completar la meta al 100%.</small>
        </div>

      </div>
      <div class="col">
        <div class="form-group">
          <label>Valor inicial del indicador <small class="text-info">Opcional</small></label>
          <input type="number" class="form-control" min="0" name="indicator_progress" placeholder="Ej: 0" value="{{$goal->indicator_progress}}">
          <small class="form-text text-muted">Es el valor con la que comenzará la meta. Los reportes de actualización irán agregando (o restando). El campo vacio será considerado como 0 </small>
        </div>
      </div>
    </div>
    <div class="form-row">
      <div class="col">
        <div class="form-group">
          <label>Unidad del indicador</label>
          <input type="text" class="form-control" name="indicator_unit" placeholder="Ej: Porcentaje, Tasa de Variación, Promedio, Número Índice" value="{{$goal->indicator_unit}}">
          <small class="form-text text-muted">Unidad de calculo, es la forma en la que vamos a medir nuestro indicador: Porcentaje, Variación, Promedio, Número Índice. Ej: KMs, Metros, Arboles plantados, Etc.</small>
        </div>
      </div>
      <div class="col">
        <div class="form-group">
          <label>Frecuencia de monitoreo <small class="text-info">Opcional</small></label>
          <input type="text" class="form-control" name="indicator_frequency" placeholder="Ej: Semanal, mensual, semestral, anual, etc" value="{{$goal->indicator_frequency}}">
          <small class="form-text text-muted">Espacio temporal en el que vamos a medir nuestro indicador : Semanal, mensual, semestral, anual, etc.</small>
        </div>
      </div>
    </div>
    <div class="form-group">
      <label>Estado inicial de la meta</label>
      <select class="custom-select" name="status">
        <option value="ongoing" {{ $goal->status == 'ongoing' ? 'selected' : null}}>En progreso</option>
        <option value="delayed" {{ $goal->status == 'delayed' ? 'selected' : null}}>No cumplida</option>
        <option value="inactive" {{ $goal->status == 'inactive' ? 'selected' : null}}>Inactiva</option>
        <option value="reached" {{ $goal->status == 'reached' ? 'selected' : null}}>Alcanzada</option>
      </select>
    </div>
    <div class="form-group">
      <label>Fuente de los datos <small class="text-info">Opcional</small></label>
      <input type="text" class="form-control" name="source" placeholder="Escriba aquí" value="{{$goal->source}}">
      <small class="form-text text-muted">Es importante que la fuente de datos sean accesibles y oficiales para hacer transparente la medición</small>
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
      <small class="form-text text-muted">Se le enviará una notificación por email (si lo tienen habilitado) y por sistema, de que la meta ha sido editada invitandolos a verla.</small>
    </div>
    <br>
    <button type="submit" class="btn btn-primary">Editar</button>
  </form>
</section>

@endsection