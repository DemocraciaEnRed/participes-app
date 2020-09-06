@extends('panel.master')

@section('panelContent')

<section>
  <h3 class="is-700">Mis objetivos</h1>
  <p class="lead">Estos son los objetivos de los cuales formas parte del equipo.</p>
  @if(!Auth::user()->hasVerifiedEmail())
  <div class="alert alert-warning">
    <h5 class="is-700"><i class="fas fa-exclamation-triangle"></i>&nbsp;¡Debe verificar su cuenta para poder ingresar a los paneles de administracion de los objetivos!</h5>
    <span>Aún no has verificado tu cuenta. Para hacerlo, ingresar en tu <a href="/panel">panel de control<i class="fas fa-arrow-right fa-fw"></i></a></span>
  </div>
  @endif
  @if(count($objectives) > 0)
  @foreach($objectives as $objective)
  <div class="card my-3 shadow-sm">
      <div class="card-body d-flex align-items-start">
          <div class="mr-3 category-icon-container" style="background-color: {{$objective->category->background_color}}">
            <i class="fa-2x fa-fw {{$objective->category->icon}}" style="color: {{$objective->category->color}}"></i>
          </div>
          <div class="w-100">
            <span class="" style="color:{{$objective->category->color}}">{{$objective->category->title}}</span>
            <h4 class="is-700 my-1">
              <a href="{{route('objectives.manage.index',['objectiveId' => $objective->id])}}" class="text-dark">{{$objective->title}}</a>
            </h4>
            <p class="text-muted text-smaller my-1">{{Str::limit($objective->content, 200, $end=' [...]')}}</p> 
          </div>
          <div class="text-center">
            <span class="text-smaller text-info"><i class="fas fa-{{$objective->pivot->role == 'manager' ? 'user-shield' : 'user-edit'}}"></i> {{$objective->pivot->role == 'manager' ? 'Coordina' : 'Reporta'}}</span>
          </div>
      </div>
    </div>
  @endforeach
  @else
  <div class="card mb-3 shadow-sm">
    <div class="card-body text-center">
      <h6 class="card-title mb-2"><i class="far fa-surprise"></i>&nbsp;No forma parte de ningun objetivo</h6>
      <p class="text-smaller mb-0">¿Quiere participar activamente? Únase a algun objetivo!</p>
    </div>
  </div>
  @endif
  {{ $objectives->links() }}

</section>

@endsection