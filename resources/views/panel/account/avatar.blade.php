@extends('panel.master')

@section('panelContent')

<section>
  <h3 class="is-700">Cambiar avatar</h3>
  <p class="lead">Para cambiar tu imagen de perfil, podés cargar alguna desde el archivo de tu computadora:</p>
  <input-user-avatar form-url="{{ route('panel.account.avatar.form') }}" crsf-token="{{ csrf_token() }}" />

</section>

@endsection