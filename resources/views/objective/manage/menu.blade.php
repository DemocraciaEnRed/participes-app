@php
$currentRoute = Route::currentRouteName();
@endphp
<h5 class="font-weight-bold">
{{$objective->title}}
</h5>
<div>
  <span class="badge badge-dark"><i class="fas fa-eye-slash"></i>&nbsp;Oculto</span>
</div>
<hr>
@yield('theMenu')
<ul class="list-unstyled">
<li><a href="{{ route('objective.manage.index', ['objId' => $objective->id]) }}" class="text-dark {{ $currentRoute == 'admin.index'  ? 'font-weight-bold' : null }}">Dashboard</a></li>
</ul>
<h6><b>Metas del objetivo</b></h6>
<ul class="list-unstyled">
<li><a href="{{ route('objective.manage.goals', ['objId' => $objective->id]) }}" class="text-dark {{ $currentRoute == 'objective.manage.goals' ? 'font-weight-bold' : null }}">Listar</a></li>
<li><a href="{{ route('objective.manage.goals.add', ['objId' => $objective->id]) }}" class="text-dark {{ $currentRoute == 'objective.manage.goals.add' ? 'font-weight-bold' : null }}"><i class="fas fa-plus"></i>&nbsp;Nuevo</a></li>
</ul>
<h6><b>Miembros del equipo</b></h6>
<ul class="list-unstyled">
<li><a href="{{ route('objective.manage.team', ['objId' => $objective->id]) }}" class="text-dark {{ $currentRoute == 'objective.manage.team' ? 'font-weight-bold' : null }}">Listar miembros</a></li>
<li><a href="{{ route('objective.manage.team.add', ['objId' => $objective->id]) }}" class="text-dark {{ $currentRoute == 'objective.manage.team.add' ? 'font-weight-bold' : null }}"><i class="fas fa-plus"></i>&nbsp;Nuevo</a></li>
</ul>
{{-- <h6><b>Reportes</b></h6>
<ul class="list-unstyled">
<li><a href="{{ route('objective.manage.reports.create', ['objId' => $objective->id]) }}" class="text-dark {{ $currentRoute == 'objective.manage.reports.create' ? 'font-weight-bold' : null }}"><i class="fas fa-plus"></i>&nbsp;Crear</a></li>
</ul> --}}
