<div class="card shadow-sm my-3">
  <div class="card-body p-3 p-lg-5">
  <div class="row">
      <div class="col-md-6 my-2">
        <div class="d-flex align-items-center">
          <div class="mr-3 category-icon-container" style="background-color: {{$objective->category->backgroundColor()}}">
            <i class="fa-2x fa-fw {{$objective->category->icon}}" style="color: {{$objective->category->color}}"></i>
          </div>
          <div class="w-100">
            <span class="" style="color:{{$objective->category->color}}">{{$objective->category->title}}</span>
            <h4 class="is-700 m-0">
              <a class="text-dark" href="{{route('objectives.index',[$objective->id])}}">{{$objective->title}}</a>
            </h4>
          </div>
        </div>
      </div>
      <div class="col-md-6 my-2">
        <div class="d-flex align-items-center">
          <div class="mr-3 category-icon-container text-center">
            <i class="far fa-2x fa-fw fa-dot-circle text-{{$goal->status}}"></i>
            <span class="text-{{$goal->status}} rounded-circle is-700 text-smallest ">{{$goal->progressPercentage()}}%</span>
          </div>
          <div class="w-100">
            <span class="text-{{$goal->status}}">Meta {{$goal->statusLabel()}}</span>
            <h4 class="is-700 m-0">
              <a class="text-dark" href="{{route('goals.index',[$goal->id])}}">{{$goal->title}}</a>
            </h4>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>