@php
$currentRoute = Route::currentRouteName();
@endphp

<h5>Menu</h5>
<ul class="list-unstyled">
<li><a href="{{route('admin.index') }}" class="text-dark {{ $currentRoute == 'admin.index'  ? 'font-weight-bold' : null }}">Inicio</a></li>
</ul>
<h6><b>Categorias</b></h5>
<ul class="list-unstyled">
<li><a href="{{route('admin.categories') }}" class="text-dark {{ $currentRoute == 'admin.categories' ? 'font-weight-bold' : null }}">Listar</a></li>
<li><a href="{{route('admin.categories.create') }}" class="text-dark {{ $currentRoute == 'admin.categories.create' ? 'font-weight-bold' : null }}">Crear</a></li>
</ul>