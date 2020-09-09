@if(!$objective->communities->isEmpty())
  <div class="card shadow-sm text-center my-3">
    <div class="card-body p-3 p-lg-5">
    <h4 class="is-700 mb-2">¡Seguí acompañandonos en nuestra comunidad!</h4>
    @foreach($objective->communities as $community)
      <a href="{{$community->url}}" target="_blank" class="py-2 px-3 rounded d-inline-block my-1 mb-1" style="border: 2px solid {{$community->color}}; color: {{$community->color}}"><i class="{{$community->icon}}"></i>&nbsp;{{$community->label}}</a>
    @endforeach
    </div>
  </div>
@endif