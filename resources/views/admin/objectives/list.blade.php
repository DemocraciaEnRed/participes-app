@extends('admin.master')

@section('adminContent')

<section>
  <h1 class="">Objetivos</h1>
  <p>Lorem ipsum dolor sit amet consectetur, adipisicing elit. In eius ad officia tempora, temporibus repudiandae id
    ipsum neque deserunt rerum esse delectus consectetur voluptates eveniet quaerat commodi ducimus mollitia dolorem.
  </p>
  
  @if(count($objectives) > 0)
    @foreach($objectives as $objective)
    <div class="card mb-3 shadow-sm">
      <div class="card-body">
        <h5 class="card-title font-weight-bold"><a class="text-primary" href="{{route('objective.manage.index',['objId' => $objective->id])}}">{{$objective->title}}</a></h5>
        <h6 class="card-subtitle mb-2">{{count($objective->goals)}} Metas <small class="text-muted">Creado {{$objective->created_at->diffForHumans()}}</small></h6>
        <p class="text-muted text-smaller mb-0">{{Str::limit($objective->content, 200, $end=' [...]')}}</p>
      </div>
    </div>
    @endforeach
  @else
    <div class="card mb-3 shadow-sm">
      <div class="card-body">
        <h6 class="card-title font-weight-bold m-0">No hay objetivos creados</h6>
      </div>
    </div>
  @endif
  {{ $objectives->links() }}
</section>

@endsection
