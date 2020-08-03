@php
$currentRoute = Route::currentRouteName();
@endphp
<p class="text-smaller text-muted mb-0">Reporte</p>
<h5 class="font-weight-bold">
{{$report->title}}
</h5>
<p class="text-smaller text-muted mb-0">Meta</p>
<h6 class="font-weight-bold">
{{$goal->title}}
</h6>
<p class="text-smaller text-muted mb-0">Objetivo</p>
<h6 class="font-weight-bold text-smaller">
{{$objective->title}}
</h6>
<hr>
<ul class="list-unstyled">
<li><a href="{{ route('objective.manage.index', ['objectiveId' => $objective->id]) }}" class="text-dark {{ $currentRoute == 'objective.manage.index'  ? 'font-weight-bold' : null }}"><i class="fas fa-arrow-left"></i>&nbsp;Volver al objetivo</a></li>
<li><a href="{{ route('objective.manage.goals.index', ['objectiveId' => $objective->id, 'goalId' => $goal->id]) }}" class="text-dark {{ $currentRoute == 'objective.manage.goals'  ? 'font-weight-bold' : null }}"><i class="fas fa-arrow-left"></i>&nbsp;Volver a las meta</a></li>
<li><a href="{{ route('objective.manage.goals.reports', ['objectiveId' => $objective->id, 'goalId' => $goal->id]) }}" class="text-dark {{ $currentRoute == 'objective.manage.goals'  ? 'font-weight-bold' : null }}"><i class="fas fa-arrow-left"></i>&nbsp;Volver a los reportes</a></li>
</ul>
<hr>
<ul class="list-unstyled">
<li><a href="{{ route('objective.manage.goals.reports.index', ['objectiveId' => $objective->id, 'goalId' => $goal->id, 'reportId' => $report->id]) }}" class="text-dark {{ $currentRoute == 'objective.manage.goals.index'  ? 'font-weight-bold' : null }}">Dashboard</a></li>
</ul>
<h6><b>Administrar</b></h6>
<ul class="list-unstyled">
<li><a href="{{ route('objective.manage.goals.reports.comments', ['objectiveId' => $objective->id, 'goalId' => $goal->id, 'reportId' => $report->id]) }}" class="text-dark {{ $currentRoute == 'objective.manage.goals.reports.comments'  ? 'font-weight-bold' : null }}">Comentarios</a></li>
<li><a href="{{ route('objective.manage.goals.reports.album', ['objectiveId' => $objective->id, 'goalId' => $goal->id, 'reportId' => $report->id]) }}" class="text-dark {{ $currentRoute == 'objective.manage.goals.reports.album'  ? 'font-weight-bold' : null }}">Album de fotos</a></li>
<li><a href="{{ route('objective.manage.goals.reports.files', ['objectiveId' => $objective->id, 'goalId' => $goal->id, 'reportId' => $report->id]) }}" class="text-dark {{ $currentRoute == 'objective.manage.goals.reports.files'  ? 'font-weight-bold' : null }}">Repositorio de archivos</a></li>
<li><a href="{{ route('objective.manage.goals.reports.map', ['objectiveId' => $objective->id, 'goalId' => $goal->id, 'reportId' => $report->id]) }}" class="text-dark {{ $currentRoute == 'objective.manage.goals.reports.map'  ? 'font-weight-bold' : null }}">Mapa</a></li>
</ul>
</ul>