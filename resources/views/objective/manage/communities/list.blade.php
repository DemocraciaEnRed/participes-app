@extends('objective.manage.master')

@section('panelContent')

<section>
  <h1 class="">Comunidades</h1>
  <p>Las comunidades de los objetivos son puntos de acceso para que los ciudadanos puedan interactuar en otros. Estos son los "Botones" para invitar a ser parte de la comunidad</p>
  {{$objective->communities}}
</section>

@endsection
