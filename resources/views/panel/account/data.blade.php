@extends('panel.master')

@section('panelContent')

<section>
  <h3 class="is-700">Cambiar mis datos</h3>
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
      <form action="{{ route('panel.account.data.form') }}" method="POST">
        @method('PUT')
        @csrf
        <div class="form-group">
          <label for="current_password"><b>Organización</b></label>
          <input type="text" class="form-control" name="organization" value="{{Auth::user()->organization}}">
          <small class="form-text text-muted"><span class="text-info">(Opcional)</span> Si desea, puede escribir a que organización pertenece</small>
        </div>
        <button class="btn btn-primary">Guardar</button>
       </form>
    </div>
  </div>
</section>

@endsection