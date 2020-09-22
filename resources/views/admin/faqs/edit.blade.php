@extends('admin.master')

@section('adminContent')

<section>
  <h3 class="is-700">Editar pregunta frecuente</h3>
  <p class="lead">Para edutar una pregunta frecuente, completá los campos a continuación:</p>
  @if ($errors->any())
    <div class="alert alert-danger">
        <ul class="mb-0">
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
  @endif
  <form method="POST" action="{{ route('admin.faqs.edit.form',['faqId' => $faq->id]) }}">
    @method('PUT')
    @csrf
    <div class="form-group">
      <label><b>Título</b></label>
      <input type="text" class="form-control" name="title" placeholder="Ingrese aquí" maxlength="550" value="{{$faq->title}}">
      <small class="form-text text-muted">Hasta 550 caracteres</small>
    </div>
     <div class="form-row">
      <div class="col">
        <div class="form-group">
          <label><b>Sección</b></label>
          <select class="custom-select" name="section">
            <option value="general" {{$faq->section == 'general' ? 'selected' : null}}>Acerca De</option>
            <option value="faq" {{$faq->section == 'faq' ? 'selected' : null}}>Ayuda</option>
            <option value="legal" {{$faq->section == 'legal' ? 'selected' : null}}>Información Legal</option>
          </select>
        </div>
      </div>
      <div class="col">
        <div class="form-group">
          <label><b>Orden</b></label>
          <input type="number" class="form-control" name="order" value="{{$faq->order}}" placeholder="Ingrese aquí la posición (Desde 1 para arriba)" min="0" max="100">
        </div>
      </div>
    </div>
    <div class="form-group">
      <label><b>Texto</b></label>
      <text-editor name="content" format="html" content="{{$faq->content}}"></text-editor>
    </div>
    <div class="text-right">
    <button type="submit" class="btn btn-primary"><i class="fas fa-edit"></i> Editar</button>
    </div>
  </form>
</section>

@endsection