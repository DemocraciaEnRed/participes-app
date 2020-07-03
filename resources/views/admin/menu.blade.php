@php
$currentRoute = Route::currentRouteName();
@endphp

<h5>Menu</h5>
<ul class="list-unstyled">
<li><a href="{{ route('admin.index') }}" class="text-dark {{ $currentRoute == 'admin.index'  ? 'font-weight-bold' : null }}">Inicio</a></li>
</ul>
<h6><b>Categorias</b></h6>
<ul class="list-unstyled">
<li><a href="{{ route('admin.categories') }}" class="text-dark {{ $currentRoute == 'admin.categories' ? 'font-weight-bold' : null }}">Listar</a></li>
<li><a href="{{ route('admin.categories.create') }}" class="text-dark {{ $currentRoute == 'admin.categories.create' ? 'font-weight-bold' : null }}">Crear</a></li>
</ul>
<h6><b>Organizaciones</b></h6>
<ul class="list-unstyled">
<li><a href="{{ route('admin.organizations') }}" class="text-dark {{ $currentRoute == 'admin.organizations' ? 'font-weight-bold' : null }}">Listar</a></li>
<li><a href="{{ route('admin.organizations.create') }}" class="text-dark {{ $currentRoute == 'admin.organizations.create' ? 'font-weight-bold' : null }}">Crear</a></li>
</ul>
<h6><b>Administradores</b></h6>
<ul class="list-unstyled">
<li><a href="{{ route('admin.administrators') }}" class="text-dark {{ $currentRoute == 'admin.administrators' ? 'font-weight-bold' : null }}">Listar</a></li>
<li><a href="{{ route('admin.administrators.create') }}" class="text-dark {{ $currentRoute == 'admin.administrators.create' ? 'font-weight-bold' : null }}">Nuevo</a></li>
</ul>