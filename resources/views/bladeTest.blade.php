@extends('layouts.panel')

@section('content')

<div class="container">
    <h5>&#64;role('user')</h5>
    <div>
    @role(['user','admin'])
      <p>Si ves este mensaje, es proque <b>tenes</b> el rol de <code>user</code>!<p>
    @else
      <p>Si ves este mensaje, es porque no tenes el rol de <code>user</code>!<p>
    @endrole
  </div>

@endsection
