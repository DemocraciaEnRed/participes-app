@extends('admin.master')

@section('adminContent')

<section>
  <h3 class="is-700">Crear pregunta frecuente</h3>
  <p class="lead">Para crear una pregunta frecuente, completá los campos a continuación:</p>
  @if ($errors->any())
    <div class="alert alert-danger">
        <ul class="mb-0">
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
  @endif
  <form method="POST" action="{{ route('admin.faqs.create.form') }}">
    @csrf
    <div class="form-group">
      <label><b>Título</b></label>
      <input type="text" class="form-control" name="title" placeholder="Ingrese aquí" maxlength="255" >
      <small class="form-text text-muted">Hasta 550 caracteres</small>
    </div>
     <div class="form-group">
      <label><b>Sección</b></label>
      <select class="custom-select" name="section">
        <option value="general">Acerca De</option>
        <option value="faq">Ayuda</option>
        <option value="legal">Información Legal</option>
      </select>
    </div>
    <div class="form-group">
      <label><b>Texto</b></label>
      <text-editor name="content" format="html"></text-editor>

    </div>
    <div class="text-right">
    <button type="submit" class="btn btn-primary"><i class="fas fa-plus"></i> Crear</button>
    </div>
  </form>
</section>

@endsection