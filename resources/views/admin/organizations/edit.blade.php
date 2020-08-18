@extends('admin.master')

@section('adminContent')

<section>
<h3 class="is-700">Editar organización <small class="text-muted">{{$organization->title}}</small></h3>
<p class="lead">Lorem ipsum dolor sit amet consectetur, adipisicing elit. In eius ad officia tempora, temporibus repudiandae id ipsum neque deserunt rerum esse delectus consectetur voluptates eveniet quaerat commodi ducimus mollitia dolorem.</p>
<hr>
<p>-- FORM editar categoria</p>
{{ $organization }}

</section>

@endsection