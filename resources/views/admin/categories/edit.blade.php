@extends('admin.master')

@section('adminContent')

<section>
<h1 class="">Editar categoria <small class="text-muted">{{$category->title}}</small></h1>
<p>Lorem ipsum dolor sit amet consectetur, adipisicing elit. In eius ad officia tempora, temporibus repudiandae id ipsum neque deserunt rerum esse delectus consectetur voluptates eveniet quaerat commodi ducimus mollitia dolorem.</p>
<hr>
<p>-- FORM editar categoria</p>
{{ $category }}

</section>

@endsection