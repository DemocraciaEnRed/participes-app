@php
$currentRoute = Route::currentRouteName();
@endphp

<h5>Panel de Admin</h5>
<ul class="list-unstyled">
<li><a href="{{ route('admin.index') }}" class="text-dark {{ $currentRoute == 'admin.index'  ? 'font-weight-bold' : null }}">Dashboard</a></li>
</ul>
<h6><b>Categorias</b></h6>
<ul class="list-unstyled">
<li><a href="{{ route('admin.categories') }}" class="text-dark {{ $currentRoute == 'admin.categories' ? 'font-weight-bold' : null }}">Listar</a></li>
<li><a href="{{ route('admin.categories.create') }}" class="text-dark {{ $currentRoute == 'admin.categories.create' ? 'font-weight-bold' : null }}"><i class="fas fa-plus"></i>&nbsp;Crear</a></li>
</ul>
<h6><b>Organizaciones</b></h6>
<ul class="list-unstyled">
<li><a href="{{ route('admin.organizations') }}" class="text-dark {{ $currentRoute == 'admin.organizations' ? 'font-weight-bold' : null }}">Listar</a></li>
<li><a href="{{ route('admin.organizations.create') }}" class="text-dark {{ $currentRoute == 'admin.organizations.create' ? 'font-weight-bold' : null }}"><i class="fas fa-plus"></i>&nbsp;Crear</a></li>
</ul>
<h6><b>Objetivos</b></h6>
<ul class="list-unstyled">
<li><a href="{{ route('admin.objectives') }}" class="text-dark {{ $currentRoute == 'admin.objectives' ? 'font-weight-bold' : null }}">Listar</a></li>
<li><a href="{{ route('admin.objectives.create') }}" class="text-dark {{ $currentRoute == 'admin.objectives.create' ? 'font-weight-bold' : null }}"><i class="fas fa-plus"></i>&nbsp;Crear</a></li>
</ul>
<h6><b>Administradores</b></h6>
<ul class="list-unstyled">
<li><a href="{{ route('admin.administrators') }}" class="text-dark {{ $currentRoute == 'admin.administrators' ? 'font-weight-bold' : null }}">Listar</a></li>
<li><a href="{{ route('admin.administrators.add') }}" class="text-dark {{ $currentRoute == 'admin.administrators.create' ? 'font-weight-bold' : null }}"><i class="fas fa-plus"></i>&nbsp;Agregar</a></li>
</ul>