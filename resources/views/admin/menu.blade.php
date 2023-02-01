@php
$currentRoute = Route::currentRouteName();
@endphp

<a href="{{ route('admin.index') }}" class="category {{ $currentRoute == 'objective.manage.goals.reports.index'  ? 'is-active' : null }}"><i class="fas fa-tachometer-alt fa-fw"></i>&nbsp;Inicio</a>
<h6 class="category"><i class="fas fa-tags fa-fw"></i>&nbsp;Categorías</h6>
<div class="menu-link">
<a href="{{ route('admin.categories.create') }}" class="item-link {{ $currentRoute == 'admin.categories.create' ? 'is-active' : null }}"><i class="fas fa-plus"></i>&nbsp;Crear</a>
<a href="{{ route('admin.categories') }}" class="item-link {{ $currentRoute == 'admin.categories' ? 'is-active' : null }}">Listar</a>
</div>
<h6 class="category"><i class="far fa-building fa-fw"></i>&nbsp;Organizaciones</h6>
<div class="menu-link">
<a href="{{ route('admin.organizations.create') }}" class="item-link {{ $currentRoute == 'admin.organizations.create' ? 'is-active' : null }}"><i class="fas fa-plus"></i>&nbsp;Crear</a>
<a href="{{ route('admin.organizations') }}" class="item-link {{ $currentRoute == 'admin.organizations' ? 'is-active' : null }}">Listar</a>
</div>
<h6 class="category"><i class="fas fa-flag-checkered fa-fw"></i>&nbsp;Objetivos</h6>
<div class="menu-link">
<a href="{{ route('admin.objectives.create') }}" class="item-link {{ $currentRoute == 'admin.objectives.create' ? 'is-active' : null }}"><i class="fas fa-plus"></i>&nbsp;Crear</a>
<a href="{{ route('admin.objectives') }}" class="item-link {{ $currentRoute == 'admin.objectives' ? 'is-active' : null }}">Listar</a>
</div>
<h6 class="category"><i class="far fa-calendar-alt fa-fw"></i>&nbsp;Eventos</h6>
<div class="menu-link">
<a href="{{ route('admin.events.create') }}" class="item-link {{ $currentRoute == 'admin.events.create' ? 'is-active' : null }}"><i class="fas fa-plus"></i>&nbsp;Crear</a>
<a href="{{ route('admin.events') }}" class="item-link {{ $currentRoute == 'admin.events' ? 'is-active' : null }}">Próximos</a>
<a href="{{ route('admin.events.past') }}" class="item-link {{ $currentRoute == 'admin.events.past' ? 'is-active' : null }}">Celebrados</a>
</div>
<h6 class="category"><i class="fas fa-user-shield fa-fw"></i>&nbsp;Administradores</h6>
<div class="menu-link">
<a href="{{ route('admin.administrators.add') }}" class="item-link {{ $currentRoute == 'admin.administrators.add' ? 'is-active' : null }}"><i class="fas fa-plus"></i>&nbsp;Agregar</a>
  <a href="{{ route('admin.administrators') }}" class="item-link {{ $currentRoute == 'admin.administrators' ? 'is-active' : null }}">Listar</a>
</div>
<h6 class="category"><i class="fas fa-question-circle fa-fw"></i>&nbsp;Preguntas Frecuentes</h6>
<div class="menu-link">
<a href="{{ route('admin.faqs.create') }}" class="item-link {{ $currentRoute == 'admin.faqs.create' ? 'is-active' : null }}"><i class="fas fa-plus"></i>&nbsp;Agregar</a>
  <a href="{{ route('admin.faqs') }}" class="item-link {{ $currentRoute == 'admin.faqs' ? 'is-active' : null }}">Listar</a>
</div>
<h6 class="category"><i class="fas fa-cog fa-fw"></i>&nbsp;Administrar</h6>
<div class="menu-link">
  <a href="{{ route('admin.settings') }}" class="item-link {{ $currentRoute == 'admin.settings'  ? 'is-active' : null }}">Configuración general</a>
  <a href="{{ route('admin.settings.homepage') }}" class="item-link {{ $currentRoute == 'admin.settings.homepage'  ? 'is-active' : null }}">Personalizar Home</a>
  <a href="{{ route('admin.settings.seo') }}" class="item-link {{ $currentRoute == 'admin.settings.seo'  ? 'is-active' : null }}">SEO y Analytics</a>
  <a href="{{ route('admin.settings.map') }}" class="item-link {{ $currentRoute == 'admin.settings.map'  ? 'is-active' : null }}">Mapas y Georeferencia</a>
  <a href="{{ route('admin.logs') }}" class="item-link {{ $currentRoute == 'admin.logs'  ? 'is-active' : null }}">Bitacora de eventos</a>
</div>