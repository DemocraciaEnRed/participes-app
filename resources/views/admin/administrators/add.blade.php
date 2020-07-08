@extends('admin.master')

@section('adminContent')

<section>
  <h1 class="">Nuevo administrador</h1>
  <p>Lorem ipsum dolor sit amet consectetur, adipisicing elit. In eius ad officia tempora, temporibus repudiandae id ipsum neque deserunt rerum esse delectus consectetur voluptates eveniet quaerat commodi ducimus mollitia dolorem.</p>
  <hr>
  <admin-search-user-new-admin fetch-url="{{ route('apiService.users') }}" form-url="{{ route('admin.administrators.add.form') }}" crsf-token="{{ csrf_token() }}"/>

</section>

@endsection