@extends('objective.manage.master')

@section('panelContent')

<section>
  <h1 class="">Nuevo miembro</h1>
  <p>Lorem ipsum dolor sit amet consectetur, adipisicing elit. In eius ad officia tempora, temporibus repudiandae id ipsum neque deserunt rerum esse delectus consectetur voluptates eveniet quaerat commodi ducimus mollitia dolorem.</p>
  <hr>
  <objective-search-user-add-team fetch-url="{{ route('apiService.users') }}" form-url="{{ route('objective.manage.team.add.form', ['objId' => $objective->id]) }}" crsf-token="{{ csrf_token() }}"/>

</section>

@endsection