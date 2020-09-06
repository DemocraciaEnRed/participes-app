@if(!$event->objectives->isEmpty())
<h3 class="is-700 my-5"> Objetivos relacionados con el evento</h3>
@foreach($event->objectives as $objective)
  <div class="card my-3 shadow-sm">
      <div class="card-body d-flex align-items-start">
          <div class="mr-3 category-icon-container" style="background-color: {{$objective->category->background_color}}">
            <i class="fa-2x fa-fw {{$objective->category->icon}}" style="color: {{$objective->category->color}}"></i>
          </div>
          <div class="w-100">
            <span class="" style="color:{{$objective->category->color}}">{{$objective->category->title}}</span>
            <h4 class="is-700 my-1">
              <a href="{{route('objectives.index',['objectiveId' => $objective->id])}}" class="text-dark">{{$objective->title}}</a>
            </h4>
            <p class="text-muted text-smaller my-1">{{Str::limit($objective->content, 200, $end=' [...]')}}</p> 
          </div>
      </div>
    </div>
  @endforeach
@endif