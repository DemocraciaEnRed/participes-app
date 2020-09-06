@extends('admin.master')

@section('adminContent')

<section>
  <h3 class="is-700">Bitacora del sistema</h3>
  <p class="lead">En esta sección se podrán auditar todas las acciones que ocurren en el sistema</p>
  @foreach($logs as $log)
  <div class="text-smaller">
  <p class="mb-1"><b>@datetime($log->record_datetime)</b> - {{$log->message}} <a data-toggle="collapse" href="#collapse{{$log->id}}" role="button" aria-expanded="false"><i class="fas fa-code fa-fw"></i></a></p>
  <p id="collapse{{$log->id}}" class="collapse"><code>{{$log->context}}</code></p>
  </div>
  @endforeach
  <br>
  {{ $logs->links() }}

</section>

@endsection
