 @if(!$event->photos->isEmpty())
<div class="card shadow-sm my-3">
  <div class="card-body p-3 p-lg-5">
    <h3 class="is-600">Fotos</h3>
    <report-album :photos='@json($event->photos)'>
      @include('partials.loading')
    </report-album>
  </div>
</div>
@endif