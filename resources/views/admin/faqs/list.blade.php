@extends('admin.master')

@section('adminContent')

<section>
  <h3 class="is-700">Preguntas Frecuentes</h3>
  <p class="lead">En esta sección se podrán contenido para la seccion de Preguntas Frecuentes de la plataforma.</p>
  @forelse($faqs as $faq)
  <div class="card mb-3 shadow-sm">
    <div class="card-body d-flex align-items-start">
        {{-- <div class="mr-4">
          @if($organization->logo)
          <img src="{{ asset($organization->logo->path) }}" class="rounded" width="75" alt="Logo {{$organization->name}}" title="{{$organization->name}}" />
          @else
          <img src="{{ asset('img/default-background.png') }}" class="rounded" width="75" alt="Logo {{$organization->name}}" title="{{$organization->name}}" />
          @endif
        </div> --}}
        <div class="w-100">
          <h5 class="is-700">{{ $faq->title }}</h5>
          <span class="text-smaller text-muted">Sección: {{ $faq->section_label }}</span>
        </div>
        <div class="text-right">
          <a href="{{ route('admin.faqs.edit', ['faqId' => $faq->id]) }}" class="btn btn-link btn-sm"><i class="fas fa-pencil-alt fa-fw"></i>Editar</a>
          <a href="{{ route('admin.faqs.delete', ['faqId' => $faq->id]) }}" class="btn btn-link btn-sm"><i class="fas fa-trash fa-fw"></i>Eliminar</a>
        </div>
    </div>
  </div>
  @empty
  <div class="card my-3 shadow-sm">
      <div class="card-body text-center">
        <h6>No hay titulos de preguntas frecuentes creados</h6>
      </div>
    </div>
  @endforelse
  {{ $faqs->links() }}

</section>

@endsection
