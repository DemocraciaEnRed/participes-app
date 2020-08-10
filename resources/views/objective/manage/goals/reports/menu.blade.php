@php
$currentRoute = Route::currentRouteName();
@endphp
<p class="text-smaller text-muted mb-0">Reporte</p>
<h6 class="font-weight-bold">
{{$report->title}}
</h6>
<p class="text-smaller text-muted mb-0">Meta</p>
<h6 class="font-weight-bold text-smaller">
{{$goal->title}}
</h6>
<p class="text-smaller text-muted mb-0">Objetivo</p>
<h6 class="font-weight-bold text-smaller">
{{$objective->title}}
</h6>
<ul class="list-unstyled mb-0">
<li><a href="{{ route('objectives.manage.index', ['objectiveId' => $objective->id]) }}" class="text-smaller text-dark"><i class="fas fa-arrow-left"></i>&nbsp;Volver al objetivo</a></li>
<li><a href="{{ route('objectives.manage.goals.index', ['objectiveId' => $objective->id, 'goalId' => $goal->id]) }}" class="text-smaller text-dark"><i class="fas fa-arrow-left"></i>&nbsp;Volver a las metas</a></li>
<li><a href="{{ route('objectives.manage.goals.reports', ['objectiveId' => $objective->id, 'goalId' => $goal->id]) }}" class="text-smaller text-dark"><i class="fas fa-arrow-left"></i>&nbsp;Volver a los reportes</a></li>
</ul>
<hr>
<a href="{{ route('objectives.manage.goals.reports.index', ['objectiveId' => $objective->id, 'goalId' => $goal->id, 'reportId' => $report->id]) }}" class="category {{ $currentRoute == 'objective.manage.goals.reports.index'  ? 'is-active' : null }}"><i class="fas fa-tachometer-alt fa-fw"></i>&nbsp;Dashboard</a>
<h6 class="category"><i class="fas fa-cog fa-fw"></i>&nbsp;Administrar</h6>
<div class="menu-link">
<a href="{{ route('objectives.manage.goals.reports.comments', ['objectiveId' => $objective->id, 'goalId' => $goal->id, 'reportId' => $report->id]) }}" class="item-link {{ $currentRoute == 'objective.manage.goals.reports.comments'  ? 'is-active' : null }}">Comentarios</a>
<a href="{{ route('objectives.manage.goals.reports.album', ['objectiveId' => $objective->id, 'goalId' => $goal->id, 'reportId' => $report->id]) }}" class="item-link {{ $currentRoute == 'objective.manage.goals.reports.album'  ? 'is-active' : null }}">Album de fotos</a>
<a href="{{ route('objectives.manage.goals.reports.files', ['objectiveId' => $objective->id, 'goalId' => $goal->id, 'reportId' => $report->id]) }}" class="item-link {{ $currentRoute == 'objective.manage.goals.reports.files'  ? 'is-active' : null }}">Repositorio de archivos</a>
<a href="{{ route('objectives.manage.goals.reports.map', ['objectiveId' => $objective->id, 'goalId' => $goal->id, 'reportId' => $report->id]) }}" class="item-link {{ $currentRoute == 'objective.manage.goals.reports.map'  ? 'is-active' : null }}">Mapa</a>
</div>