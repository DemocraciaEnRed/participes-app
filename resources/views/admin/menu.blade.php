@php
$currentRoute = Route::currentRouteName();
@endphp

<a href="{{ route('admin.index') }}" class="category {{ $currentRoute == 'objective.manage.goals.reports.index'  ? 'is-active' : null }}"><i class="fas fa-tachometer-alt fa-fw"></i>&nbsp;Dashboard</a>
<h6 class="category"><i class="fas fa-tags fa-fw"></i>&nbsp;Categorias</h6>
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
<h6 class="category"><i class="fas fa-user-shield fa-fw"></i>&nbsp;Administradores</h6>
<div class="menu-link">
<a href="{{ route('admin.administrators.add') }}" class="item-link {{ $currentRoute == 'admin.administrators.add' ? 'is-active' : null }}"><i class="fas fa-plus"></i>&nbsp;Agregar</a>
  <a href="{{ route('admin.administrators') }}" class="item-link {{ $currentRoute == 'admin.administrators' ? 'is-active' : null }}">Listar</a>
</div>