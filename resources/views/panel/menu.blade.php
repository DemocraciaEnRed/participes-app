@php
$currentRoute = Route::currentRouteName();
$countUnreadNotifications = count(Auth::user()->unreadNotifications)   
@endphp


<ul class="list-unstyled">
<li><a href="{{route('panel.index') }}" class="text-dark {{ $currentRoute == 'panel.index'  ? 'font-weight-bold' : null }}">Inicio</a></li>
</ul>
<h6><b>Mis notificationes</b></h5>
<ul class="list-unstyled">
<li><a href="{{route('panel.notifications') }}" class="text-dark {{ $currentRoute == 'panel.notifications' ? 'font-weight-bold' : null }}">Todas</a></li>
<li><a href="{{route('panel.notifications.unread') }}" class="text-dark {{ $currentRoute == 'panel.notifications.unread' ? 'font-weight-bold' : null }}">Pendientes <span class="badge badge-primary badge-pill align-middle">{{$countUnreadNotifications}}</span></a></li>
</ul>
<h6><b>Mis objetivos</b></h5>
<ul class="list-unstyled">
<li><a href="{{route('panel.objectives') }}" class="text-dark {{ $currentRoute == 'panel.objectives' ? 'font-weight-bold' : null }}">Listar</a></li>
</ul>
<h6><b>Mis suscripciones</b></h5>
<ul class="list-unstyled">
<li><a href="{{route('panel.subscriptions') }}" class="text-dark {{ $currentRoute == 'panel.subscriptions' ? 'font-weight-bold' : null }}">Listar</a></li>
</ul>
<h6><b>Mi cuenta</b></h5>
<ul class="list-unstyled">
<li><a href="{{route('panel.account.avatar') }}" class="text-dark {{ $currentRoute == 'panel.account.avatar' ? 'font-weight-bold' : null }}">Cambiar mi avatar</a></li>
<li><a href="{{route('panel.account.email') }}" class="text-dark {{ $currentRoute == 'panel.account.email' ? 'font-weight-bold' : null }}">Cambiar mi email</a></li>
<li><a href="{{route('panel.account.access') }}" class="text-dark {{ $currentRoute == 'panel.account.access' ? 'font-weight-bold' : null }}">Cambiar contraseña</a></li>
<li><a href="{{route('panel.account.notifications') }}" class="text-dark {{ $currentRoute == 'panel.account.notifications' ? 'font-weight-bold' : null }}">Preferencias de envio</a></li>
</ul>