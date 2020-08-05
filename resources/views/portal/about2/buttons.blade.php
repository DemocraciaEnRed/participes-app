@php
$currentRoute = Route::currentRouteName();
@endphp

<div id="portal-sections-buttons">
  <div class="container">
    <div class="row justify-content-center">
      <div class="col-9 col-sm-12 col-md-10 col-lg-8 buttons-container">
        <div class="card shadow rounded">
          <div class="card-body">
            <div class="row">
              <div class="col-sm-4 text-center section-button {{ $currentRoute == 'about.general' ? 'active' : null }}">
                <a href="{{route('about.general')}}">
                  <i class="fas fa-eye fa-2x mb-3"></i>
                  <h6>Información general</h6>
                  <div class="liner mb-3 mb-sm-0"></div>
                </a>
              </div>
              <div class="col-sm-4 text-center section-button {{ $currentRoute == 'about.faq' ? 'active' : null }}">
                <a href="{{route('about.faq')}}">
                  <i class="fas fa-question fa-2x mb-3"></i>
                  <h6>Preguntas frecuentes</h6>
                  <div class="liner mb-3 mb-sm-0"></div>
                </a>
              </div>
              <div class="col-sm-4 text-center section-button {{ $currentRoute == 'about.legal' ? 'active' : null }}">
                <a href="{{route('about.legal')}}">
                  <i class="fas fa-shield-alt fa-2x mb-3"></i>
                  <h6>Información legal</h6>
                  <div class="liner mb-3 mb-sm-0"></div>
                </a>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>