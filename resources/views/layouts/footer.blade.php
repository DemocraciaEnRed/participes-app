<div id="footer">
<div class="container">
  <div class="row text-smaller text-center text-lg-left">
    <div class="col-lg-4 mb-2 mb-lg-0">
      <img src="{{asset(app_setting('app_logo_footer','img/default-logo-color.svg'))}}" class="footer-logo" alt="">
      <p class="">
       {!! nl2br(e(app_setting('app_footer_description'))) !!}
      </p>
    </div>
    <div class="col-lg-3 mb-2 mb-lg-0">
      <p class="mb-1 mb-lg-2"><b>Sobre partícipes</b></p>
      <p class="mb-1"><a href="{{route('about.general')}}">Acerca de Partipes</a></p>
      <p class="mb-1"><a href="{{route('about.faq')}}">Preguntas frecuentes</a></p>
      <p class="mb-1"><a href="{{route('about.legal')}}#términos">Legales</a></p>
    </div>
    <div class="col-lg-3 mb-2 mb-lg-0">
      <p class="mb-lg-2"><b>Contactenos</b></p>
      <p>{!! nl2br(e(app_setting('app_footer_contact_info'))) !!}</p>
    </div>
    <div class="col-lg-2 mb-0">
      Desarrollado con <i class="far fa-heart text-danger"></i> por Democracia en Red
    </div>
  </div>
</div>
</div>