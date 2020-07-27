@extends('panel.master')

@section('panelContent')

<section>
  <h1 class="">Cambiar avatar</h1>
  <p>Para cambiar tu imagen de perfil, podés cargar alguna desde el archivo de tu computadora:</p>
  <input-user-avatar form-url="{{ route('panel.account.avatar.form') }}" crsf-token="{{ csrf_token() }}" />

</section>

@endsection