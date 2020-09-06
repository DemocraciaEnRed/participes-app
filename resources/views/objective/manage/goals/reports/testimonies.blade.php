@extends('objective.manage.goals.reports.master')

@section('panelContent')

<section>
  <h3 class="is-700">Feedbacks</h3>
  @isManager($objective->id)
  @if(!$testimonies->isEmpty())
  <div class="my-3">
    <a href="{{route('objectives.manage.goals.reports.testimonies.download', ['objectiveId' => $objective->id, 'goalId' => $goal->id, 'reportId' => $report->id])}}" class="btn btn-link btn-sm"><i class="fas fa-download fa-fw"></i><i class="far fa-file-excel fa-fw"></i>Descargar .xlsx</a>
  </div>
  @endif
  @endisManager
  @forelse($testimonies as $testimony)
      <div class="card my-2 shadow-sm">
    <div class="card-body py-2 d-flex align-items-center">
      <div class="mr-3 text-center">
      @include('utils.avatar',['avatar' => $testimony->user->avatar, 'size' => 36, 'thumbnail' => true])
      </div>
      <div class="w-100">
        <h6 class="is-600 m-0">{{$testimony->user->surname}}, {{$testimony->user->name}}</h6>
        <span class="text-smaller text-muted">
        @isManager($objective->id)
          Email: {{$testimony->user->email}}
        @endisManager
      </div>
      <div>
        <i class="fas fa-lg fa-thumbs-up"></i>
      </div>
    </div>
  </div>
  @empty
    <div class="card shadow-sm my-3">
      <div class="card-body text-center">
        <i class="far fa-surprise"></i>&nbsp;¡No hay feedbacks del reporte!
      </div>
    </div>
  @endforelse
  {{ $testimonies->links() }}
  
</section>

@endsection
