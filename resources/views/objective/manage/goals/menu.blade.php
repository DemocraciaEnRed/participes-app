@php
$currentRoute = Route::currentRouteName();
@endphp
<h6 class="text-secondary">
{{$objective->title}}
</h6>
<h5 class="font-weight-bold">
{{$goal->title}}
</h5>
<hr>
<ul class="list-unstyled">
<li><a href="{{ route('objective.manage.index', ['objId' => $objective->id]) }}" class="text-dark {{ $currentRoute == 'objective.manage.index'  ? 'font-weight-bold' : null }}"><i class="fas fa-arrow-left"></i>&nbsp;Volver al Objetivo</a></li>
<li><a href="{{ route('objective.manage.goals', ['objId' => $objective->id]) }}" class="text-dark {{ $currentRoute == 'objective.manage.goals'  ? 'font-weight-bold' : null }}"><i class="fas fa-arrow-left"></i>&nbsp;Volver a Metas</a></li>
</ul>
<hr>
<ul class="list-unstyled">
<li><a href="{{ route('objective.manage.goals.index', ['objId' => $objective->id, 'goalId' => $goal->id]) }}" class="text-dark {{ $currentRoute == 'objective.manage.goals.index'  ? 'font-weight-bold' : null }}">Acerca</a></li>
</ul>
<h6><b>Hitos</b></h6>
<ul class="list-unstyled">
<li><a href="{{ route('objective.manage.goals.milestones', ['objId' => $objective->id, 'goalId' => $goal->id]) }}" class="text-dark {{ $currentRoute == 'objective.manage.goals.milestones'  ? 'font-weight-bold' : null }}">Listar</a></li>
<li><a href="{{ route('objective.manage.goals.milestones.add', ['objId' => $objective->id, 'goalId' => $goal->id]) }}" class="text-dark {{ $currentRoute == 'objective.manage.goals.milestones.add'  ? 'font-weight-bold' : null }}"><i class="fas fa-plus"></i>&nbsp;Crear</a></li>
</ul>
<h6><b>Reportes</b></h6>
<ul class="list-unstyled">
<li><a href="{{ route('objective.manage.goals.reports', ['objId' => $objective->id, 'goalId' => $goal->id]) }}" class="text-dark {{ $currentRoute == 'objective.manage.goals.reports'  ? 'font-weight-bold' : null }}">Listar</a></li>
<li><a href="{{ route('objective.manage.goals.reports.add', ['objId' => $objective->id, 'goalId' => $goal->id ]) }}" class="text-dark {{ $currentRoute == 'objective.manage.goals.reports.add'  ? 'font-weight-bold' : null }}"><i class="fas fa-plus"></i>&nbsp;Nuevo</a></li>
</ul>