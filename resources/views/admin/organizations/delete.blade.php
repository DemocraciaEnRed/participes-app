@extends('admin.master')

@section('adminContent')

<section>
<h3 class="is-700">Eliminar organización</small></h3>
<p class="lead">Complete los siguientes campos para eliminar una categoria:</p>
  @if ($errors->any())
    <div class="alert alert-danger">
        <ul class="mb-0">
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
  @endif
  <form action="{{ route('admin.organizations.delete.form',['organizationId' => $organization->id]) }}" method="POST">
    @method('DELETE')
    @csrf
    <p>Eliminar una organización no tiene grandes impactos.</p>
    <div class="form-group">
      <label><b>Ingrese su contraseña</b><span class="text-danger">*</span></label>
      <input type="password" class="form-control" name="password">
      <small class="form-text text-muted">Para poder eliminar la organización, ingrese su contraseña para confirmar.</small>
    </div>
    <button type="submit" class="btn btn-danger">Eliminar</button>
  </form>

</section>

@endsection