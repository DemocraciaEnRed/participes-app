@extends('panel.master')

@section('panelContent')

<section>
  <h1 class="">Cambiar avatar</h1>
  <p>Lorem ipsum dolor sit amet consectetur, adipisicing elit. In eius ad officia tempora, temporibus repudiandae id
    ipsum neque deserunt rerum esse delectus consectetur voluptates eveniet quaerat commodi ducimus mollitia dolorem.
  </p>
  <input-user-avatar form-url="{{ route('panel.account.avatar.form') }}" crsf-token="{{ csrf_token() }}" />

</section>

@endsection