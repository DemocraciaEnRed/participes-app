@extends('admin.master')

@section('adminContent')

<section>
  <h3 class="is-700">Eliminar pregunta frecuente</h3>
  <h5 class="text-muted is-700">{{$faq->title}}</h5>
  @if ($errors->any())
    <div class="alert alert-danger">
        <ul class="mb-0">
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
  @endif
  <form action="{{ route('admin.faqs.delete.form',['faqId' => $faq->id]) }}" method="POST">
    @method('DELETE')
    @csrf
    <p>Al eliminar la pregunta frecuente, tenga en cuenta que no se podrá recuperar.</p>
    <button type="submit" class="btn btn-danger">Eliminar</button>
  </form>
</section>

@endsection