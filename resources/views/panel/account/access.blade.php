@extends('panel.master')

@section('panelContent')

<section>
  <h1 class="">Cambiar contraseña</h1>
  <p></p>
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
  <div class="row">
    <div class="col col-md-8">
      <form action="{{ route('panel.account.access.form') }}" method="POST">
        @method('PUT')
        @csrf
        <div class="form-group">
          <label for="current_password">Contraseña actual</label>
          <input type="password" class="form-control" name="current_password" id="current_password">
          <small class="form-text text-muted">Say goodbye to your old password...</small>
        </div>
        <div class="form-group">
          <label for="new_password">Nueva contraseña</label>
          <input type="password" class="form-control" name="new_password" id="new_password">
        </div>
        <div class="form-group">
          <label for="repeat_password">Repita la nueva contraseña</label>
          <input type="password" class="form-control" name="repeat_password" id="repeat_password">
        </div>
        <button class="btn btn-primary">Guardar</button>
       </form>
    </div>
  </div>
</section>

@endsection