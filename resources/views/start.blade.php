<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">

  <!-- CSRF Token -->
  <meta name="csrf-token" content="{{ csrf_token() }}">

  <title>{{ config('app.name', 'Laravel') }}</title>
  @yield('metatags')

  <!-- Styles -->
  <link href="{{ asset('css/app.css') }}" rel="stylesheet">
  @yield('stylesheets')
  @yield('headscripts')

  <!-- Scripts -->
  <script src="{{ asset('js/app.js') }}" defer></script>
  <script src="https://kit.fontawesome.com/8da8f66b21.js" crossorigin="anonymous"></script>
</head>

<body>
  <div id="app">
    <main class="py-4">
      <div class="container">
        @include('partials.flashMessage')
        <h1>Start app</h1>
        <hr>
         @if ($errors->any())
    <div class="alert alert-danger">
        <ul class="mb-0">
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
  @endif
        <div class="row">
          <div class="col-md-6">
            <form action="{{route('start.form')}}" method="POST">
              @csrf
              <h3><i class="fas fa-info-circle"></i>&nbsp;Usuario administrador</h3>
              <br>
              <div class="form-group row">
                <label for="name" class="col-md-4 col-form-label text-md-right">{{ __('Name') }}</label>
                <div class="col-md-8">
                  <input id="name" type="text" class="form-control @error('name') is-invalid @enderror" name="name"
                    value="{{ old('name') }}" required>
                  @error('name')
                  <span class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                  </span>
                  @enderror
                </div>
              </div>
              <div class="form-group row">
                <label for="surname" class="col-md-4 col-form-label text-md-right">{{ __('Surname') }}</label>

                <div class="col-md-8">
                  <input id="surname" type="text" class="form-control @error('surname') is-invalid @enderror"
                    name="surname" value="{{ old('surname') }}" required>

                  @error('surname')
                  <span class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                  </span>
                  @enderror
                </div>
              </div>

              <div class="form-group row">
                <label for="email" class="col-md-4 col-form-label text-md-right">{{ __('E-Mail Address') }}</label>

                <div class="col-md-8">
                  <input id="email" type="email" class="form-control @error('email') is-invalid @enderror" name="email"
                    value="{{ old('email') }}" required autocomplete="email">

                  @error('email')
                  <span class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                  </span>
                  @enderror
                </div>
              </div>

              <div class="form-group row">
                <label for="password" class="col-md-4 col-form-label text-md-right">{{ __('Password') }}</label>

                <div class="col-md-8">
                  <input id="password" type="password" class="form-control @error('password') is-invalid @enderror"
                    name="password" required>

                  @error('password')
                  <span class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                  </span>
                  @enderror
                </div>
              </div>

              <div class="form-group row">
                <label for="password-confirm"
                  class="col-md-4 col-form-label text-md-right">{{ __('Confirm Password') }}</label>

                <div class="col-md-8">
                  <input id="password-confirm" type="password" class="form-control" name="password_confirmation"
                    required>
                </div>
              </div>
              <div class="form-group row">
                <label for="password-confirm" class="col-md-4 col-form-label text-md-right">¿Activar DEMO?</label>

                <div class="col-md-8">
                  <div class="custom-control custom-checkbox">
                    <input class="custom-control-input" id="demo" type="checkbox" name="demo" value="1">
                    <label class="custom-control-label" for="demo">Activar</label>
                  </div>
                </div>
              </div>
              <p class="text-muted">El usuario será creado y se lo asignará como administrador. No tiene que validar la
                cuenta. Puede acceder luego sin problemas.</p>
              <h4>¿Arrancar aplicación?</h4>
              <button type="submit" class="btn btn-primary">Arrancar</button>
            </form>
          </div>
          <div class="col-md-6">
            <div class="alert alert-warning mb-3">
              <h4><i class="fas fa-info-circle"></i>&nbsp;Si la aplicación fue iniciada, va a limpiar toda la base de
                datos</h4>
              <p class="mb-0">Puede comenzar una demo haciendo clic en <b>Con DEMO</b> </p>
            </div>
            <div class="alert alert-light mb-3">
              <h4><i class="fas fa-info-circle"></i>&nbsp;Acerca de la demo</h4>
              <p class="">Puede comenzar una demo haciendo clic en <b>Con DEMO</b>. La misma cuenta con:</p>
              <ul class="mb-0">
                <li>5 categorias</li>
                <li>25 organizaciones</li>
                <li>50 usuarios</li>
                <li>20 objetivos</li>
                <li>7 metas por objetivos</li>
                <li>6 usuarios miembros del equipo de cada objetivo</li>
                <li>4 usuarios suscriptos por cada objetivo</li>
                <li>Entre 1 y 9 reportes por meta, siendo, al azar, que sean, de novedad, progreso, o hito.</li>
                <li>Un 60% de que el reporte sea geolocalizado</li>
                <li>Un 40% de que haya un reporte que cambie el estado de la meta a completada</li>
              </ul>
            </div>
          </div>
        </div>
      </div>
    </main>
  </div>
  <script type="text/javascript">
    window.addEventListener('keydown',function(e){if(e.keyIdentifier=='U+000A'||e.keyIdentifier=='Enter'||e.keyCode==13){if(e.target.nodeName=='INPUT'&&e.target.type=='text'){e.preventDefault();return false;}}},true);
  </script>
</body>

</html>