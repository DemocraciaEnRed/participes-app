@php
$currentRoute = Route::currentRouteName();
@endphp
<p class="text-smaller text-muted mb-0">Reporte</p>
<h6 class="font-weight-bold">
  <a href="{{route('reports.index',['reportId' => $report->id])}}">
{{$report->title}}
  </a>
</h6>
<p class="text-smaller text-muted mb-0">Meta</p>
<h6 class="font-weight-bold text-smaller">
  <a href="{{route('goals.index',['goalId' => $goal->id])}}">
  {{$goal->title}}
  </a>
</h6>
<p class="text-smaller text-muted mb-0">Objetivo</p>
<h6 class="font-weight-bold text-smaller">
<a href="{{route('objectives.index',['objectiveId' => $objective->id])}}">
  {{$objective->title}}
  </a>
</h6>
<ul class="list-unstyled mb-0">
<li><a href="{{ route('objectives.manage.goals.reports', ['objectiveId' => $objective->id, 'goalId' => $goal->id]) }}" class="text-smaller text-dark"><i class="fas fa-arrow-left"></i>&nbsp;Volver a los reportes</a></li>
<li><a href="{{ route('objectives.manage.goals.index', ['objectiveId' => $objective->id, 'goalId' => $goal->id]) }}" class="text-smaller text-dark"><i class="fas fa-arrow-left"></i>&nbsp;Volver a las meta</a></li>
<li><a href="{{ route('objectives.manage.index', ['objectiveId' => $objective->id]) }}" class="text-smaller text-dark"><i class="fas fa-arrow-left"></i>&nbsp;Volver al objetivo</a></li>
</ul>
<hr>
<a href="{{ route('objectives.manage.goals.reports.index', ['objectiveId' => $objective->id, 'goalId' => $goal->id, 'reportId' => $report->id]) }}" class="category {{ $currentRoute == 'objective.manage.goals.reports.index'  ? 'is-active' : null }}"><i class="fas fa-tachometer-alt fa-fw"></i>&nbsp;Inicio</a>
<h6 class="category"><i class="fas fa-cog fa-fw"></i>&nbsp;Administrar</h6>
<div class="menu-link">
<a href="{{ route('objectives.manage.goals.reports.edit', ['objectiveId' => $objective->id, 'goalId' => $goal->id, 'reportId' => $report->id]) }}" class="item-link {{ $currentRoute == 'objectives.manage.goals.reports.edit'  ? 'is-active' : null }}">Editar reporte</a>
<a href="{{ route('objectives.manage.goals.reports.configuration', ['objectiveId' => $objective->id, 'goalId' => $goal->id, 'reportId' => $report->id]) }}" class="item-link {{ $currentRoute == 'objectives.manage.goals.reports.configuration'  ? 'is-active' : null }}">Configuración</a>
<a href="{{ route('objectives.manage.goals.reports.comments', ['objectiveId' => $objective->id, 'goalId' => $goal->id, 'reportId' => $report->id]) }}" class="item-link {{ $currentRoute == 'objectives.manage.goals.reports.comments'  ? 'is-active' : null }}">Comentarios</a>
<a href="{{ route('objectives.manage.goals.reports.testimonies', ['objectiveId' => $objective->id, 'goalId' => $goal->id, 'reportId' => $report->id]) }}" class="item-link {{ $currentRoute == 'objectives.manage.goals.reports.testimonies'  ? 'is-active' : null }}">Feedbacks</a>
<a href="{{ route('objectives.manage.goals.reports.album', ['objectiveId' => $objective->id, 'goalId' => $goal->id, 'reportId' => $report->id]) }}" class="item-link {{ $currentRoute == 'objectives.manage.goals.reports.album'  ? 'is-active' : null }}">Album de fotos</a>
<a href="{{ route('objectives.manage.goals.reports.files', ['objectiveId' => $objective->id, 'goalId' => $goal->id, 'reportId' => $report->id]) }}" class="item-link {{ $currentRoute == 'objectives.manage.goals.reports.files'  ? 'is-active' : null }}">Repositorio de archivos</a>
<a href="{{ route('objectives.manage.goals.reports.map', ['objectiveId' => $objective->id, 'goalId' => $goal->id, 'reportId' => $report->id]) }}" class="item-link {{ $currentRoute == 'objectives.manage.goals.reports.map'  ? 'is-active' : null }}">Mapa</a>
</div>