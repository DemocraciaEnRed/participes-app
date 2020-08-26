@extends('admin.master')

@section('adminContent')

<section>
  <h3 class="is-700">Próximos eventos</h1>
  <p class="lead">Acá encontrarás los proximos eventos que podés administrar</p>
  @include('admin.events.list')
</section>

@endsection
