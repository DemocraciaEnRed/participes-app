@extends('admin.master')

@section('adminContent')

<section>
  <h3 class="is-700">Nuevo administrador</h3>
  <p class="lead">Para crear un nuevo administrador, completá los campos a continuación:<br><i>Nota: Recordá que el administrador podrá gestionar la totalidad de los objetivos, metas y reportes</i></p>
  <admin-search-user-new-admin fetch-url="{{ route('apiService.users',['with' => 'user_email']) }}" form-url="{{ route('admin.administrators.add.form') }}" crsf-token="{{ csrf_token() }}"/>

</section>

@endsection