@extends('admin.master')

@section('adminContent')

<section>
  <h3 class="is-700">Eventos celebrados</h1>
  <p class="lead">Acá encontrarás los eventos celebrados que podés administrar</p>
  @include('admin.events.list')
</section>

@endsection
