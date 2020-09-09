@php
$currentRoute = Route::currentRouteName();
$countUnreadNotifications = count(Auth::user()->unreadNotifications)   
@endphp

<a href="{{route('panel.index') }}" class="category {{ $currentRoute == 'panel.index'  ? 'is-active' : null }}"><i class="fas fa-tachometer-alt fa-fw"></i>&nbsp;Mi panel</a></li>
<h6 class="category"><i class="fas fa-bell fa-fw"></i>&nbsp;Mis notificationes</h6>
<div class="menu-link">
<a href="{{route('panel.notifications.unread') }}" class="item-link {{ $currentRoute == 'panel.notifications.unread' ? 'is-active' : null }}">Pendientes <span class="badge badge-primary badge-pill align-middle {{$countUnreadNotifications > 0 ?: 'd-none'}}" >{{$countUnreadNotifications}}</span></a>
<a href="{{route('panel.notifications') }}" class="item-link {{ $currentRoute == 'panel.notifications' ? 'is-active' : null }}">Todas</a>
</div>
<h6 class="category"><i class="fas fa-marker fa-fw"></i>&nbsp;Mis objetivos</h6>
<div class="menu-link">
<a href="{{route('panel.objectives') }}" class="item-link {{ $currentRoute == 'panel.objectives' ? 'is-active' : null }}">Listar</a>
</div>
<h6 class="category"><i class="fas fa-envelope fa-fw"></i>&nbsp;Mis suscripciones</h6>
<div class="menu-link">
<a href="{{route('panel.subscriptions') }}" class="item-link {{ $currentRoute == 'panel.subscriptions' ? 'is-active' : null }}">Listar</a>
</div>
<h6 class="category"><i class="fas fa-user fa-fw"></i>&nbsp;Mi cuenta</h6>
<div class="menu-link">
<a href="{{route('panel.account.data') }}" class="item-link {{ $currentRoute == 'panel.account.data' ? 'is-active' : null }}">Cambiar mis datos</a>
<a href="{{route('panel.account.email') }}" class="item-link {{ $currentRoute == 'panel.account.email' ? 'is-active' : null }}">Cambiar mi email</a>
<a href="{{route('panel.account.avatar') }}" class="item-link {{ $currentRoute == 'panel.account.avatar' ? 'is-active' : null }}">Cambiar mi avatar</a>
<a href="{{route('panel.account.access') }}" class="item-link {{ $currentRoute == 'panel.account.access' ? 'is-active' : null }}">Cambiar contraseña</a>
<a href="{{route('panel.account.notifications') }}" class="item-link {{ $currentRoute == 'panel.account.notifications' ? 'is-active' : null }}">Preferencias de envío</a>
</div>
