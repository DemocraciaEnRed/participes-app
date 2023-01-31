@php
$currentRoute = Route::currentRouteName();
@endphp
<p class="text-smaller text-muted mb-0">Objetivo</p>
<h6 class="font-weight-bold">
<a href="{{route('objectives.index',['objectiveId' => $objective->id])}}">
  {{$objective->title}}
  </a>
</h6>
@hasRole('admin')
<ul class="list-unstyled mb-0">
<li><a href="{{ route('admin.objectives') }}" class="text-smaller text-dark"><i class="fas fa-arrow-left"></i>&nbsp;Volver a los objetivos</a></li>
</ul>
@endhasRole
<hr>
<a href="{{route('objectives.manage.index', ['objectiveId' => $objective->id]) }}" class="category {{ $currentRoute == 'objectives.manage.index'  ? 'is-active' : null }}"><i class="fas fa-tachometer-alt fa-fw"></i>&nbsp;Inicio</a>
<h6 class="category"><i class="fas fa-medal fa-fw"></i>&nbsp;Metas del objetivo</h6>
<div class="menu-link">
@isManager($objective->id)
<a href="{{ route('objectives.manage.goals.add', ['objectiveId' => $objective->id]) }}" class="item-link {{ $currentRoute == 'objectives.manage.goals.add' ? 'is-active' : null }}"><i class="fas fa-plus fa-fw"></i>&nbsp;Nuevo</a>
@endisManager
<a href="{{ route('objectives.manage.goals', ['objectiveId' => $objective->id]) }}" class="item-link {{ $currentRoute == 'objectives.manage.goals' ? 'is-active' : null }}">Listar</a>
</div>
<h6 class="category"><i class="fas fa-icons fa-fw"></i>&nbsp;Comunidades</h6>
<div class="menu-link">
@isManager($objective->id)
<a href="{{ route('objectives.manage.communities.add', ['objectiveId' => $objective->id]) }}" class="item-link {{ $currentRoute == 'objectives.manage.communities.add' ? 'is-active' : null }}"><i class="fas fa-plus fa-fw"></i>&nbsp;Nuevo</a>
@endisManager
<a href="{{ route('objectives.manage.communities', ['objectiveId' => $objective->id]) }}" class="item-link {{ $currentRoute == 'objectives.manage.communities' ? 'is-active' : null }}">Listar</a>
</div>

<h6 class="category"><i class="fas fa-users fa-fw"></i>&nbsp;Equipo del equipo</h6>
<div class="menu-link">
@isManager($objective->id)
<a href="{{ route('objectives.manage.team.add', ['objectiveId' => $objective->id]) }}" class="item-link {{ $currentRoute == 'objectives.manage.team.add' ? 'is-active' : null }}"><i class="fas fa-plus fa-fw"></i>&nbsp;Agregar</a>
@endisManager
<a href="{{ route('objectives.manage.team', ['objectiveId' => $objective->id]) }}" class="item-link {{ $currentRoute == 'objectives.manage.team' ? 'is-active' : null }}">Ver miembros</a>
</div>
<h6 class="category"><i class="fas fa-user-tag fa-fw"></i>&nbsp;Suscriptores</h6>
<div class="menu-link">
<a href="{{route('objectives.manage.subscribers', ['objectiveId' => $objective->id]) }}" class="item-link {{ $currentRoute == 'objectives.manage.subscribers'  ? 'is-active' : null }}">Listar</a>
</div>

@isManager($objective->id)
<h6 class="category"><i class="fas fa-cog fa-fw"></i>&nbsp;Administrar</h6>
<div class="menu-link">
<a href="{{route('objectives.manage.edit', ['objectiveId' => $objective->id]) }}" class="item-link {{ $currentRoute == 'objectives.manage.edit'  ? 'is-active' : null }}">Editar objetivo</a>
<a href="{{route('objectives.manage.cover', ['objectiveId' => $objective->id]) }}" class="item-link {{ $currentRoute == 'objectives.manage.cover'  ? 'is-active' : null }}">Imagen de portada</a>
<a href="{{route('objectives.manage.files', ['objectiveId' => $objective->id]) }}" class="item-link {{ $currentRoute == 'objectives.manage.files'  ? 'is-active' : null }}">Repositorio de archivos</a>
@if(app_setting('app_map_enabled'))
<a href="{{route('objectives.manage.map', ['objectiveId' => $objective->id]) }}" class="item-link {{ $currentRoute == 'objectives.manage.map'  ? 'is-active' : null }}">Mapa de reportes</a>
@endif
<a href="{{route('objectives.manage.configuration', ['objectiveId' => $objective->id]) }}" class="item-link {{ $currentRoute == 'objectives.manage.configuration'  ? 'is-active' : null }}">Configuración</a>
<a href="{{route('objectives.manage.logs', ['objectiveId' => $objective->id]) }}" class="item-link {{ $currentRoute == 'objectives.manage.logs'  ? 'is-active' : null }}">Bitacora de eventos</a>
</div>
@endisManager
