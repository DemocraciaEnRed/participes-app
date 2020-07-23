@php
$currentRoute = Route::currentRouteName();
@endphp
<p class="text-smaller text-muted mb-0">Objetivo</p>
<h6 class="font-weight-bold">
{{$objective->title}}
</h6>
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
@isManager($objective->id)
<li><a href="{{ route('objective.manage.goals.add', ['objId' => $objective->id]) }}" class="text-dark {{ $currentRoute == 'objective.manage.goals.add' ? 'font-weight-bold' : null }}"><i class="fas fa-plus"></i>&nbsp;Nuevo</a></li>
@endisManager
</ul>
<h6><b>Miembros del equipo</b></h6>
<ul class="list-unstyled">
<li><a href="{{ route('objective.manage.team', ['objId' => $objective->id]) }}" class="text-dark {{ $currentRoute == 'objective.manage.team' ? 'font-weight-bold' : null }}">Listar miembros</a></li>
@isManager($objective->id)
<li><a href="{{ route('objective.manage.team.add', ['objId' => $objective->id]) }}" class="text-dark {{ $currentRoute == 'objective.manage.team.add' ? 'font-weight-bold' : null }}"><i class="fas fa-plus"></i>&nbsp;Nuevo</a></li>
@endisManager
</ul>
<h6><b>Suscriptores</b></h6>
<ul class="list-unstyled">
<li><a href="{{ route('objective.manage.subscribers', ['objId' => $objective->id]) }}" class="text-dark {{ $currentRoute == 'objective.manage.subscribers' ? 'font-weight-bold' : null }}">Listar</a></li>
</ul>
<h6><b>El objetivo</b></h6>
<ul class="list-unstyled">
<li><a href="{{ route('objective.manage.team', ['objId' => $objective->id]) }}" class="text-dark {{ $currentRoute == 'objective.manage.team' ? 'font-weight-bold' : null }}"><i class="fas fa-plus"></i>&nbsp;Imagen de cover</a></li>
</ul>
<h6><b>Bolsa de archivos</b></h6>
<ul class="list-unstyled">
<li><a href="{{ route('objective.manage.team', ['objId' => $objective->id]) }}" class="text-dark {{ $currentRoute == 'objective.manage.team' ? 'font-weight-bold' : null }}"><i class="fas fa-plus"></i>&nbsp;Crear</a></li>
</ul>
