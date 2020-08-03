@extends('objective.manage.goals.reports.master')

@section('panelContent')

<section>
  <h1 class="">Comentarios</h1>
  <p>Los comentarios</p>
   <hr>
  <report-comments fetch-url="{{ route('apiService.reports.comments',['reportId' => $report->id]) }}" comment-url="{{ route('apiService.reports.comments.create',['reportId' => $report->id]) }}" :user="{{ Auth::user() ?  Auth::user()->load(['avatar']) : null }}" />
</section>

@endsection
