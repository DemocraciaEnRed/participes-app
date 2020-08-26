@extends('objective.manage.goals.reports.master')

@section('panelContent')

<section>
  <h3 class="is-700">Comentarios</h3>
  <hr>
  <report-comments fetch-url="{{ route('apiService.reports.comments',['reportId' => $report->id]) }}" comment-url="{{ route('apiService.reports.comments.create',['reportId' => $report->id]) }}" :user="{{ Auth::user() ?  Auth::user()->load(['avatar']) : null }}" />
</section>

@endsection
