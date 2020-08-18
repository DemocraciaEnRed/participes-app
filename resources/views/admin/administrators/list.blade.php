@extends('admin.master')

@section('adminContent')

<section>
  <h3 class="is-700">Administradores de la plataforma</h3>
  <p class="lead">Los administradores de la plataforma pueden gestionar la totalidad de los objetivos, metas y reportes. Pudiendo crear, editar, y eliminar.</p>
  @forelse($administrators as $user)
  <div class="card my-3 shadow-sm">
      <div class="card-body d-flex align-items-start">
        <div class="mr-3 text-center">
         @include('utils.avatar',['avatar' => $user->avatar, 'size' => 48, 'thumbnail' => true])
        </div>
        <div class="w-100">
          <h5 class="my-1 is-600">{{$user->surname}}, {{$user->name}}</h5>
          <p class="my-1 text-smaller text-muted">Email: {{$user->email}}</p>
          <div class="mt-2" role="group">
            <form id="remove{{$user->id}}" action="{{ route('admin.administrators.delete.form', ['id' => $user->id]) }}" method="POST">
              @csrf
              @method('DELETE')
            </form>
            <button type="submit" form="remove{{$user->id}}" class="btn btn-outline-danger btn-sm">
              <i class="fas fa-times"></i>&nbsp;Quitar
            </button>
          </div>
        </div>
      </div>
    </div>
  @empty
  @endforelse
  {{-- <table class="table table-sm">
    <thead class="thead-dark">
      <tr>
        <th scope="col">Nombre y apellido</th>
        <th class="text-center" scope="col">Email</th>
        <th width="80" class="text-center" scope="col">Accion</th>
      </tr>
    </thead>
    <tbody>
        <tr>
          <td>{{$user->name}}</td>
          <td class="text-center">{{$user->email}}</td>
            <td class="text-center">
            <div class="btn-group btn-group-sm" role="group">
              <form action="{{ route('admin.administrators.delete.form', ['id' => $user->id]) }}" method="POST">
              @csrf
              @method('DELETE')
              <input type="hidden" value="{{$user->id}}">
              <button type="submit" class="btn btn-danger btn-sm">
                Quitar
              </button>
              </form>
            </div>
          </td>
        </tr>
      @empty
        <tr>
          <td colspan="4">No hay organizaciones</td>
        </tr>
      @endforelse
    </tbody>
  </table> --}}
</section>

@endsection
