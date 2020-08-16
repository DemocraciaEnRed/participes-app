@php
  $currentRoute = Route::currentRouteName();
@endphp

  <a href="{{route('home')}}" class="category"><i class="fas fa-home fa-fw"></i>&nbsp;Volver al inicio</a>
  <a href="{{route('about.general')}}" class="category {{ $currentRoute == 'about.general' ? 'text-primary' : null }}"><i class="fas fa-eye fa-fw"></i>&nbsp;Acerca de</a>
  @if($currentRoute == 'about.general')
  <scrollactive class="menu-link" active-class="is-active">
    <a class="item-link scrollactive-item" href="#que-es">¿Qué es partícipes?</a>
    <a class="item-link scrollactive-item" href="#quienes-somos">¿Quienes somos Partícipes Rosario?</a>
    <a class="item-link scrollactive-item" href="#como-participo">¿Cómo participo?</a>
    <a class="item-link scrollactive-item" href="#mas-alla">Más allá de nuestra ciudad</a>
  </scrollactive>
  @else
  @endif
  <a href="{{route('about.faq')}}" class="category {{ $currentRoute == 'about.faq' ? 'text-primary' : null }}"><i class="fas fa-question fa-fw"></i>&nbsp;Ayuda</a>
  @if($currentRoute == 'about.faq')
  <scrollactive class="menu-link" active-class="is-active">
    <a class="item-link scrollactive-item" href="#preguntas" class="item-link scrollactive-item">Preguntas Frecuentes</a>
    <a class="item-link scrollactive-item" href="#manual" class="item-link scrollactive-item">Manual de usuario</a>
  </scrollactive>
  @else
  @endif
  <a href="{{route('about.legal')}}" class="category {{ $currentRoute == 'about.legal' ? 'text-primary' : null }}"><i class="fas fa-shield-alt fa-fw"></i>&nbsp;Información legal</a>
  @if($currentRoute == 'about.legal')
  <scrollactive class="menu-link" active-class="is-active">
    <a class="item-link scrollactive-item" href="#terminos">Términos y condiciones</a>
    <a class="item-link scrollactive-item" href="#privacidad">Pólitica de privacidad</a>
  </scrollactive>
  @endif
