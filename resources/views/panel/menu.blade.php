@php
$currentRoute = Route::currentRouteName();
@endphp

<h5>Menu</h5>
<ul class="list-unstyled">
<li><a href="{{route('panel.index') }}" class="text-dark {{ $currentRoute == 'panel.index'  ? 'font-weight-bold' : null }}">Inicio</a></li>
</ul>
<h6><b>Acceso</b></h5>
<ul class="list-unstyled">
<li><a href="{{route('panel.password.change') }}" class="text-dark {{ $currentRoute == 'panel.password.change' ? 'font-weight-bold' : null }}">Cambiar contraseña</a></li>
</ul>