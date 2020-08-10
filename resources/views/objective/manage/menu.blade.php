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
<a href="{{route('objectives.manage.index', ['objectiveId' => $objective->id]) }}" class="category {{ $currentRoute == 'objective.manage.index'  ? 'is-active' : null }}"><i class="fas fa-tachometer-alt fa-fw"></i>&nbsp;Dashboard</a>

<h6 class="category"><i class="fas fa-medal fa-fw"></i>&nbsp;Metas del objetivo</h6>
<div class="menu-link">
@isManager($objective->id)
<a href="{{ route('objectives.manage.goals.add', ['objectiveId' => $objective->id]) }}" class="item-link {{ $currentRoute == 'objective.manage.goals.add' ? 'is-active' : null }}"><i class="fas fa-plus fa-fw"></i>&nbsp;Nuevo</a>
@endisManager
<a href="{{ route('objectives.manage.goals', ['objectiveId' => $objective->id]) }}" class="item-link {{ $currentRoute == 'objective.manage.goals' ? 'is-active' : null }}">Listar</a>
</div>

<h6 class="category"><i class="fas fa-users fa-fw"></i>&nbsp;Miembros del equipo</h6>
<div class="menu-link">
@isManager($objective->id)
<a href="{{ route('objectives.manage.team.add', ['objectiveId' => $objective->id]) }}" class="item-link {{ $currentRoute == 'objective.manage.team.add' ? 'is-active' : null }}"><i class="fas fa-plus fa-fw"></i>&nbsp;Nuevo</a>
@endisManager
<a href="{{ route('objectives.manage.team', ['objectiveId' => $objective->id]) }}" class="item-link {{ $currentRoute == 'objective.manage.team' ? 'is-active' : null }}">Listar</a>
</div>
<a href="{{route('objectives.manage.subscribers', ['objectiveId' => $objective->id]) }}" class="category {{ $currentRoute == 'objective.manage.subscribers'  ? 'is-active' : null }}"><i class="fas fa-user-tag fa-fw"></i>&nbsp;Suscriptores</a>

@isManager($objective->id)
<h6 class="category"><i class="fas fa-cog fa-fw"></i>&nbsp;Administrar</h6>
<div class="menu-link">
<a href="{{route('objectives.manage.configuration', ['objectiveId' => $objective->id]) }}" class="item-link {{ $currentRoute == 'objective.manage.configuration'  ? 'is-active' : null }}">Configuración</a>
<a href="{{route('objectives.manage.cover', ['objectiveId' => $objective->id]) }}" class="item-link {{ $currentRoute == 'objective.manage.cover'  ? 'is-active' : null }}">Imagen de portada</a>
<a href="{{route('objectives.manage.files', ['objectiveId' => $objective->id]) }}" class="item-link {{ $currentRoute == 'objective.manage.files'  ? 'is-active' : null }}">Repositorio de archivos</a>
<a href="{{route('objectives.manage.album', ['objectiveId' => $objective->id]) }}" class="item-link {{ $currentRoute == 'objective.manage.album'  ? 'is-active' : null }}">Album de fotos</a>
<a href="{{route('objectives.manage.map', ['objectiveId' => $objective->id]) }}" class="item-link {{ $currentRoute == 'objective.manage.map'  ? 'is-active' : null }}">Mapa de reportes</a>
</div>
@endisManager
