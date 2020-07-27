@extends('admin.master')

@section('adminContent')

<section>
  <h1 class="">Nuevo administrador</h1>
  <p>Para crear un nuevo administrador, completá los campos a continuación:<br><i>Nota: Recordá que el administrador podrá gestionar la totalidad de los objetivos, metas y reportes</i></p>
  <hr>
  <admin-search-user-new-admin fetch-url="{{ route('apiService.users') }}" form-url="{{ route('admin.administrators.add.form') }}" crsf-token="{{ csrf_token() }}"/>

</section>

@endsection