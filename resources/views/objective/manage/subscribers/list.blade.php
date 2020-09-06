@extends('objective.manage.master')

@section('panelContent')

<section>
  <h3 class="is-700">Subscriptores</h3>
  <p class="lead">Aqui encontrará a los usuarios suscripto a las notificaciones del objetivo</p>
  @isManager($objective->id)
  @if(!$subscribers->isEmpty())
  <div class="my-3">
    <a href="{{route('objectives.manage.subscribers.download', ['objectiveId' => $objective->id])}}" class="btn btn-link btn-sm"><i class="fas fa-download fa-fw"></i><i class="far fa-file-excel fa-fw"></i>Descargar .xlsx</a>
  </div>
  @endif
  @endisManager
  @forelse($subscribers as $subscriber)
      <div class="card my-2 shadow-sm">
    <div class="card-body py-2 d-flex align-items-center">
      <div class="mr-3 text-center">
      @include('utils.avatar',['avatar' => $subscriber->avatar, 'size' => 36, 'thumbnail' => true])
      </div>
      <div class="w-100">
        <h6 class="is-600 m-0">{{$subscriber->surname}}, {{$subscriber->name}}</h6>
        <span class="text-smaller text-muted">
        @isManager($objective->id)
          Email: {{$subscriber->email}} - 
        @endisManager
          Suscripto el @datetime($subscriber->pivot->created_at)</span>
      </div>
    </div>
  </div>
  @empty
    <div class="card shadow-sm my-3">
      <div class="card-body text-center">
        <i class="far fa-surprise"></i>&nbsp;¡No hay suscriptores del objetivo!
      </div>
    </div>
  @endforelse
  {{ $subscribers->links() }}
</section>

@endsection
