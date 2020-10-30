@extends('objective.manage.master')

@section('panelContent')

<section>
  <h3 class="is-700">Editar objetivo</h3>
  <p class="lead">Completá los campos a continuación:</p>
  @if ($errors->any())
    <div class="alert alert-danger">
        <ul class="mb-0">
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
  @endif
  @if($objective->has('goals'))
  <div class="alert alert-warning">
    <h6 class="is-700"><i class="fas fa-exclamation-triangle"></i> Importante</h6>
    El objetivo cuenta con metas. Si alguno de los campos compromete alguna información con respecto a las metas, recuerde hacer las ediciones correspondientes en las mismas.
  </div>
  @endif
  @if (count($categories) > 0)
  <form method="POST" action="{{ route('objectives.manage.edit.form',['objectiveId' => $objective->id]) }}">
    @method('PUT')
    @csrf
    <div class="form-group">
      <label>Titulo del objetivo</label>
      <input type="text" class="form-control" name="title" value="{{$objective->title}}" placeholder="Ingrese un nombre">
    </div>
    <div class="form-group">
      <label>Descripción del objetivo</label>
      <textarea name="content" class="form-control" rows="4">{{$objective->content}}</textarea>
    </div>
    <div class="form-group">
      <label>Categoria del objetivo</label>
      <select class="custom-select" name="category">
        @foreach ($categories as $category)
        <option value="{{$category->id}}" {{$category->id == $objective->category->id ? 'selected' : null}}>{{$category->title}}</option>
        @endforeach
      </select>
    </div>
    <div class="form-group">
      <label>Tags</label>
      <input-tags name="tags" :tags='@json($objective->tags)'></input-tags>
    </div>
    <div class="form-group">
      <label>Organizaciones relacionadas con el objetivo</label>
      <div>
        @foreach($organizations as $organization)
          <div class="custom-control custom-checkbox form-check-inline">
            <input class="custom-control-input" type="checkbox" name="organizations[]" id="org{{$organization->id}}" {{$objective->hasOrganization($organization->id) ? 'checked' : null}} :value="{{$organization->id}}">
            <label class="custom-control-label" for="org{{$organization->id}}">{{$organization->name}}</label>
          </div>
        @endforeach
      </div>
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
      <small class="form-text text-muted">Se le enviará una notificación por sistema, de que el objetivo ha sido editado, invitandolos a verlo.</small>
    </div>
    <br>
    <button type="submit" class="btn btn-primary">Editar</button>
  </form>
  @else
  <div class="alert alert-warning" role="alert">
    No puede crear objetivos sin categorías. Debe ir al panel de <a href="{{ route('admin.categories') }}">Categorías</a>
  </div>
  @endif
</section>

@endsection