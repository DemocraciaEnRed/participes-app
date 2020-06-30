@extends('admin.master')

@section('adminContent')

<section>
  <h1 class="">Organizaciones</h1>
  <p>Lorem ipsum dolor sit amet consectetur, adipisicing elit. In eius ad officia tempora, temporibus repudiandae id
    ipsum neque deserunt rerum esse delectus consectetur voluptates eveniet quaerat commodi ducimus mollitia dolorem.
  </p>
  <hr>
  <table class="table table-sm">
    <thead class="thead-dark">
      <tr>
        <th scope="col">Organizacion</th>
        <th width="80" class="text-center" scope="col">Accion</th>
      </tr>
    </thead>
    <tbody>
      @if(count($organizations) > 0)
        @foreach($organizations as $organization)
          <tr>
            <td>
              <div class="media">
                <img src="{{ asset($organization->logo->path) }}" class="mr-3 mt-1" width="50" alt="" title="" />
                <div class="media-body">
                  <h5 class="font-weight-bold">{{ $organization->name }}</h5>
                  {{ $organization->description }}
                </div>
              </div>
            </td>
            <td class="text-center">
              <div class="btn-group btn-group-sm" role="group" aria-label="Basic example">
                <a href="{{ route('admin.organizations.edit', ['id' => $organization->id]) }}"
                  type="button" class="btn btn-primary">Editar</a>
              </div>
            </td>
          </tr>
        @endforeach
      @else
        <tr>
          <td colspan="4">No hay organizaciones</td>
        </tr>
      @endif
    </tbody>
  </table>
</section>

@endsection
