@php
$currentRoute = Route::currentRouteName();
@endphp

<div id="calendarHeader" class="container push-to-header">
	<h2 class="text-white is-700 text-center mb-4">
		<i class="fas fa-calendar-alt"></i>&nbsp;Eventos
	</h2>
  @hasRole('admin')
  <div class="my-4 text-center">
    <a href="{{route('admin.events.create')}}" class="btn btn-secondary"><i class="fas fa-plus fa-fw"></i><i class="fas fa-calendar-alt"></i> Nuevo</a>
  </div>
  @endhasRole
	<div id="calendarButtons" class="row justify-content-center">
      <div class="col-9 col-sm-8 col-lg-6">
        <div class="card shadow rounded">
          <div class="card-body">
            <div class="row justify-content-center">
              <div class="col-sm-6 text-center section-button {{ $currentRoute == 'events.upcoming' ? 'active' : null }}">
                <a href="{{route('events.upcoming')}}">
                  <i class="fas fa-fast-forward fa-2x fa-fw mb-3"></i>
                  <i class="fas fa-calendar-alt fa-2x fa-fw mb-3"></i>
                  <h6>Próximos eventos</h6>
                  <div class="liner mb-3 mb-sm-0"></div>
                </a>
              </div>
              <div class="col-sm-6 text-center section-button {{ $currentRoute == 'events.past' ? 'active' : null }}">
                <a href="{{route('events.past')}}">
                  <i class="fas fa-history fa-2x mb-3"></i>
                  <h6>Eventos celebrados</h6>
                  <div class="liner mb-3 mb-sm-0"></div>
                </a>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
</div>