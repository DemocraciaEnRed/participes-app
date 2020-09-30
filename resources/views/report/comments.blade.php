<div class="card shadow-sm mb-3" id="comentarios">
  <div class="card-body p-3 p-lg-5">
    <report-comments fetch-url="{{ route('apiService.reports.comments',['reportId' => $report->id]) }}"
      comment-url="{{ route('apiService.reports.comments.create',['reportId' => $report->id]) }}"
      :user="{{ Auth::user() ?  Auth::user()->load(['avatar']) : 'null' }}">
      @include('partials.loading')
    </report-comments>
  </div>
</div>