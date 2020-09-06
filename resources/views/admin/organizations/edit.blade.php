@extends('admin.master')

@section('adminContent')

<section>
<h3 class="is-700">Editar organización</h3>
 <p class="lead">Para editar los datos de la organización, agrupación conformada por ciudadanos independientes o bien algún sector encargado de un objetivo, completa los siguientes campos:</p>
  @if ($errors->any())
    <div class="alert alert-danger">
        <ul class="mb-0">
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
  @endif
  <form method="POST" action="{{ route('admin.organizations.edit.form',['organizationId' => $organization->id]) }}" enctype="multipart/form-data">
    @method('PUT')
    @csrf
    <div class="form-group">
      <label><b>Nombre</b> <small class="text-danger">*</small></label>
      <input type="text" class="form-control" name="name" placeholder="Ingrese un nombre" value="{{$organization->name}}" maxlength="255">
      <small class="text-muted">Hasta 225 caracteres.</small>
    </div>
    <div class="form-group">
      <label><b>Descripción</b> <small class="text-danger">*</small></label>
      <textarea name="description" class="form-control" rows="4" maxlength="550">{{$organization->description}}</textarea>
      <small class="text-muted">Hasta 550 caracteres.</small>
    </div>
    <div class="form-group">
      <label><b>Logo</b> <small class="text-info">Opcional</small></label>
      <input-file name="logo" accept="image/*"></input-file>
      <small class="text-muted">Se recomienda que no exceda 2MB y que sea PNG con fondo transparente.</small>
    </div>
    <button type="submit" class="btn btn-primary">Editar</button>
  </form>

</section>

@endsection