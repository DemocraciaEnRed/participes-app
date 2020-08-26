@extends('objective.manage.goals.reports.master')

@section('panelContent')

<section>
  <h3 class="is-700">Editar reporte</h3>
  <p class="lead">Para editar el reporte, complete los siguientes campos</p>
  @if ($errors->any())
  <div class="alert alert-danger">
      <ul class="mb-0">
          @foreach ($errors->all() as $error)
              <li>{{ $error }}</li>
          @endforeach
      </ul>
  </div>
  @endif
  <div class="alert alert-warning">
    <h6 class="is-700"><i class="fas fa-exclamation-triangle"></i> Importante</h6>
    El objetivo es un objetivo de avance. Si usted modifica las cantidades, considere que puede afectar la cronologia de otros reportes, y los datos de la misma meta. De ser asi, considere modificar la meta y otros reportes para mantener consistencia en la información.
  </div>
  <ul class="nav nav-tabs justify-content-center mb-3">
    <li class="nav-item">
      <a class="nav-link {{$report->type == 'post' ? 'font-primary active font-weight-bold' : 'text-muted'}}" ><i class="fas fa-bullhorn"></i>&nbsp;&nbsp;Novedad</a>
    </li>
    <li class="nav-item">
      <a class="nav-link {{$report->type == 'progress' ? 'font-primary active font-weight-bold' : 'text-muted'}}" ><i class="fas fa-fast-forward"></i>&nbsp;&nbsp;Avance</a>
    </li>
    <li class="nav-item">
      <a class="nav-link {{$report->type == 'milestone' ? 'font-primary active font-weight-bold' : 'text-muted'}}" ><i class="fas fa-medal"></i>&nbsp;&nbsp;Hito</a>
    </li>
  </ul>
  <form action="{{route('objectives.manage.goals.reports.edit.form',['objectiveId' => $objective->id, 'goalId' => $goal->id, 'reportId' => $report->id])}}" method="POST" enctype="multipart/form-data">
    @method('PUT')
    @csrf
    <div class="form-group">
      <label>Titulo del reporte</label>
      <input type="text" name="title" class="form-control" value="{{$report->title}}" />
    </div>
    <div class="form-group">
      <label>Descripción del reporte</label>
      <textarea name="content" class="form-control" rows="4">{{$report->content}}</textarea>
    </div>
    <div class="form-group">
      <label>Tags del reporte</label>
      <input-tags name="tags" :tags='@json($report->tags)'></input-tags>
    </div>
     <div class="form-group">
      <label>Fecha del reporte</label>
      <input name="date" type="date" value="@dateInputFormat($report->date)" class="form-control" />
      <small class="form-text text-muted">Fecha en que ocurre el reporte.</small>
    </div>
    <div class="form-row">
      <div class="col">
        <div class="form-group">
          <label>Estado de la meta previo al reporte</label>
            <div class="form-group">
              <select class="custom-select" name="previous_status">
                  <option value="ongoing" {{$report->previous_status == 'ongoing' ? 'selected' : null}}>En progreso</option>
                  <option value="delayed" {{$report->previous_status == 'delayed' ? 'selected' : null}}>No cumplida</option>
                  <option value="inactive" {{$report->previous_status == 'inactive' ? 'selected' : null}}>Inactiva</option>
                  <option value="reached" {{$report->previous_status == 'reached' ? 'selected' : null}} >Alcanzada</option>
              </select>
            <small class="form-text text-muted">Si el reporte indica un nuevo estado de la meta, puede definirlo aqui, si la meta no cambia su estado, puede dejarlo en "Mantener el estado"</small>
            </div>
          <small class="form-text text-muted"></small>
        </div>
      </div>
      <div class="col">
        <div class="form-group">
          <label>Estado de la meta luego del reporte</label>
            <div class="form-group">
              <select class="custom-select" name="status">
                  <option value="" {{$report->status ?: 'selected'}}>- Mantener el estado ({{$report->previous_status_label}}) -</option>
                  <option value="ongoing" {{$report->status == 'ongoing' ? 'selected' : null}}>En progreso</option>
                  <option value="delayed" {{$report->status == 'delayed' ? 'selected' : null}}>No cumplida</option>
                  <option value="inactive" {{$report->status == 'inactive' ? 'selected' : null}}>Inactiva</option>
                  <option value="reached" {{$report->status == 'reached' ? 'selected' : null}}>Alcanzada</option>
              </select>
            <small class="form-text text-muted">Si el reporte indica un nuevo estado de la meta, puede definirlo aqui, si la meta no cambia su estado, puede dejarlo en "Mantener el estado"</small>
            </div>
          <small class="form-text text-muted"></small>
        </div>
      </div>
    </div>
    @if($report->type == 'milestone')
    <div class="form-group">
      <label>¿En que fecha se alcanzó el hito?</label>
      <input name="milestone_date" type="date" value="@dateInputFormat($report->milestone->completed)" class="form-control" />
      <small class="form-text text-muted">Si la fecha en que el hito se alcanzó es distinta a la fecha del reporte, por favor, ingrese la fecha aquí. De no definirla, se define la fecha de hito alcanzado la misma fecha que el reporte.</small>
    </div>
    <div class="form-group">
      <label>Hito que se ha alcanzado</label>
      @foreach($goal->milestones as $milestone)
      <div class="custom-control custom-radio">
        <input type="radio" id="radio{{$milestone->id}}" name="milestone" value="{{$milestone->id}}" class="custom-control-input" {{$report->milestone->id == $milestone->id ? 'checked' : null}} {{ $report->milestone->id != $milestone->id && !is_null($milestone->completed) ? 'disabled' : null }}>
        <label class="custom-control-label" for="radio{{$milestone->id}}">Hito #{{$milestone->order}}: {{$milestone->title}} @if(!is_null($milestone->completed))<small class="text-success">(Completado)</small>@endif</label>
      </div>
      @endforeach
    </div>
    @endif
    @if($report->type == 'progress')
    <div class="alert alert-warning">
      <h6 class="is-700"><i class="fas fa-exclamation-triangle"></i> Importante</h6>
      Corrobore que, si cuenta con reportes de <i class="fas fa-fast-forward"></i> <b>avance</b> previos, y modifica el "Progreso de la meta antes del reporte" debe hacer las modificaciones pertinentes sobre reportes previos de avance, y sobre el valor de la meta en si. 
    </div>
    <div class="form-row">
      <div class="col">
        <div class="form-group">
          <label>Progreso de la meta antes del reporte</label>
          <div class="form-group">
          <input type="number" min="0" value="{{$report->previous_progress}}" name="previous_progress" class="form-control">
          <small class="form-text text-muted">Este es el valor que la meta se entcontraba previo al reporte del avante</small>
          </div>       
        </div>
      </div>
      <div class="col">
        <div class="form-group">
          <label>Progreso que anuncia el reporte</label>
          <div class="form-group">
          <input type="number" min="0" value="{{$report->progress}}" name="progress" class="form-control">
          <small class="form-text text-muted">El número de {{$goal->indicator_unit}} que el reporte anuncia</small>
          </div>
        </div>
      </div>
    </div>
    @endif
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
      <small class="form-text text-muted">Se le enviará una notificación por email (si lo tienen habilitado) y por sistema, de que el reporte ha sido editado invitandolos a verla.</small>
    </div>
    <br>
    <button type="submit" class="btn btn-primary">Editar</button>
  </form>
  
  
</section>

@endsection
