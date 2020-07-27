@extends('admin.master')

@section('adminContent')

<section>
  <h1 class="">Administradores de la plataforma</h1>
  <p>Los administradores de la plataforma pueden gestionar la totalidad de los objetivos, metas y reportes. Pudiendo crear, editar, y eliminar.</p>
  <hr>
  <table class="table table-sm">
    <thead class="thead-dark">
      <tr>
        <th scope="col">Nombre y apellido</th>
        <th class="text-center" scope="col">Email</th>
        <th width="80" class="text-center" scope="col">Accion</th>
      </tr>
    </thead>
    <tbody>
      @forelse($administrators as $user)
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
  </table>
</section>

@endsection
