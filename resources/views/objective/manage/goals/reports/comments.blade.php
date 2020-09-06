@extends('objective.manage.goals.reports.master')

@section('panelContent')

<section>
  <h3 class="is-700">Comentarios</h3>
  @isManager($objective->id)
  <div class="my-3">
    <a href="{{route('objectives.manage.goals.reports.comments.download', ['objectiveId' => $objective->id, 'goalId' => $goal->id, 'reportId' => $report->id])}}" class="btn btn-link btn-sm"><i class="fas fa-download fa-fw"></i><i class="far fa-file-excel fa-fw"></i>Descargar .xlsx</a>
  </div>
  @endisManager
  <report-comments fetch-url="{{ route('apiService.reports.comments',['reportId' => $report->id]) }}"
    comment-url="{{ route('apiService.reports.comments.create',['reportId' => $report->id]) }}"
    :user="{{ Auth::user() ?  Auth::user()->load(['avatar']) : 'null' }}">
    @include('partials.loading')
  </report-comments>
</section>

@endsection
