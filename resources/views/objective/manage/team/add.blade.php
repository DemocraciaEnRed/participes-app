@extends('objective.manage.master')

@section('panelContent')

<section>
  <h1 class="">Nuevo miembro</h1>
  <p>A continuación, podrás agregar nuevos miembros al equipo de coordinación y reportes del objetivo. Recordá que usuario con rol de coordinador puede agregar nuevas metas, editarlas y reportar, y usuario con rol de reportero solo podrá reportar</p>
  <hr>
  <objective-search-user-add-team fetch-url="{{ route('apiService.users') }}" form-url="{{ route('objectives.manage.team.add.form', ['objectiveId' => $objective->id]) }}" crsf-token="{{ csrf_token() }}"/>

</section>

@endsection