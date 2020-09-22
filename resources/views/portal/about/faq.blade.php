@extends('portal.about.master')

@section('aboutContent')
@forelse ($questions as $question)
<section id="{{$question->section}}{{$question->id}}" class="py-4">
<h3 class="is-700 mb-4">{{$question->title}}</h3>
{!! $question->content !!}
<p class="text-smaller text-muted">Ultima actualización: @datetime($question->updated_at)</p>
</section>
@if(!$loop->last)
<hr>
@endif
@empty
  <h6 class="text-center">No hay preguntas frencuentes en esta sección</h6>
@endforelse
@endsection