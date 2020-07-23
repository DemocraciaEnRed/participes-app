@php
$currentRoute = Route::currentRouteName();
@endphp
<p class="text-smaller text-muted mb-0">Objetivo</p>
<h6 class="font-weight-bold">
{{$objective->title}}
</h6>
<div>
@if($objective->hidden)
  <span class="badge badge-dark"><i class="fas fa-eye-slash"></i>&nbsp;Oculto</span>
@endif
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
@isManager($objective->id)
<h6><b>Administrar</b></h6>
<ul class="list-unstyled">
<li><a href="{{ route('objective.manage.configuration', ['objId' => $objective->id]) }}" class="text-dark {{ $currentRoute == 'objective.manage.configuration' ? 'font-weight-bold' : null }}">Configuración</a></li>
<li><a href="{{ route('objective.manage.cover', ['objId' => $objective->id]) }}" class="text-dark {{ $currentRoute == 'objective.manage.cover' ? 'font-weight-bold' : null }}">Imagen de portada</a></li>
<li><a href="{{ route('objective.manage.files', ['objId' => $objective->id]) }}" class="text-dark {{ $currentRoute == 'objective.manage.files' ? 'font-weight-bold' : null }}">Repositorio de archivos</a></li>
<li><a href="{{ route('objective.manage.album', ['objId' => $objective->id]) }}" class="text-dark {{ $currentRoute == 'objective.manage.album' ? 'font-weight-bold' : null }}">Album de fotos</a></li>
<li><a href="{{ route('objective.manage.map', ['objId' => $objective->id]) }}" class="text-dark {{ $currentRoute == 'objective.manage.map' ? 'font-weight-bold' : null }}">Mapa de reportes</a></li>
</ul>
@endisManager
