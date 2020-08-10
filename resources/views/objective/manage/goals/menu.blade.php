@php
$currentRoute = Route::currentRouteName();
@endphp
<p class="text-smaller text-muted mb-0">Meta</p>
<h6 class="font-weight-bold">
{{$goal->title}}
</h6>
<p class="text-smaller text-muted mb-0">Objetivo</p>
<h6 class="font-weight-bold text-smaller">
{{$objective->title}}
</h6>
<ul class="list-unstyled mb-0">
<li><a href="{{ route('objectives.manage.index', ['objectiveId' => $objective->id]) }}" class="text-smaller text-dark"><i class="fas fa-arrow-left"></i>&nbsp;Volver al objetivo</a></li>
<li><a href="{{ route('objectives.manage.goals', ['objectiveId' => $objective->id]) }}" class="text-smaller text-dark"><i class="fas fa-arrow-left"></i>&nbsp;Volver a las metas</a></li>
</ul>
<hr>
<a href="{{ route('objectives.manage.goals.index', ['objectiveId' => $objective->id, 'goalId' => $goal->id]) }}" class="category {{ $currentRoute == 'objective.manage.goals.index'  ? 'is-active' : null }}"><i class="fas fa-tachometer-alt fa-fw"></i>&nbsp;Dashboard</a>
<h6 class="category"><i class="far fa-file-alt fa-fw"></i>&nbsp;Reportes</h6>
<div class="menu-link">
<a href="{{ route('objectives.manage.goals.reports.add', ['objectiveId' => $objective->id, 'goalId' => $goal->id ]) }}" class="item-link {{ $currentRoute == 'objective.manage.goals.reports.add'  ? 'is-active' : null }}"><i class="fas fa-plus fa-fw"></i>&nbsp;Nuevo</a>
<a href="{{ route('objectives.manage.goals.reports', ['objectiveId' => $objective->id, 'goalId' => $goal->id]) }}" class="item-link {{ $currentRoute == 'objective.manage.goals.reports'  ? 'is-active' : null }}">Listar</a>
</div>
<h6 class="category"><i class="fas fa-star fa-fw"></i>&nbsp;Hitos</h6>
<div class="menu-link">
@isManager($objective->id)
<a href="{{ route('objectives.manage.goals.milestones.add', ['objectiveId' => $objective->id, 'goalId' => $goal->id]) }}" class="item-link {{ $currentRoute == 'objective.manage.goals.milestones.add'  ? 'is-active' : null }}"><i class="fas fa-plus fa-fw"></i>&nbsp;Crear</a>
@endisManager
<a href="{{ route('objectives.manage.goals.milestones', ['objectiveId' => $objective->id, 'goalId' => $goal->id]) }}" class="item-link {{ $currentRoute == 'objective.manage.goals.milestones'  ? 'is-active' : null }}">Listar</a>
</div>