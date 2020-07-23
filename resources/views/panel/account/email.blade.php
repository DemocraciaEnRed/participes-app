@extends('panel.master')

@section('panelContent')

<section>
<h1 class="">Cambiar password</h1>
<p>Lorem ipsum dolor sit amet consectetur, adipisicing elit. In eius ad officia tempora, temporibus repudiandae id ipsum neque deserunt rerum esse delectus consectetur voluptates eveniet quaerat commodi ducimus mollitia dolorem.</p>
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
      <form action="{{ route('panel.account.email.form') }}" method="POST">
        @method('PUT')
        @csrf
        <div class="form-group">
          <label for="current_password">Nuevo email</label>
          <input type="email" class="form-control" name="email" id="current_password">
          <small class="form-text text-muted">La proxima vez que ingrese, debera verificar su cuenta.</small>
        </div>
        <button class="btn btn-primary">Guardar</button>
       </form>
    </div>
  </div>
</section>

@endsection