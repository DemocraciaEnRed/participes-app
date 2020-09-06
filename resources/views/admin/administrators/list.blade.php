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
      </div>
      <div>
          <form id="remove{{$user->id}}" action="{{ route('admin.administrators.delete.form', ['adminId' => $user->id]) }}" method="POST">
            @csrf
            @method('DELETE')
          </form>
          <button type="submit" form="remove{{$user->id}}" class="btn btn-link btn-sm">
            <i class="fas fa-times"></i>&nbsp;Quitar
          </button>
      </div>
    </div>
  </div>
  @empty
  <div class="card shadow-sm my-3">
    <div class="card-body text-center">
      <i class="far fa-surprise"></i>&nbsp;Ehhh..... no deberias de estar viendo esto vacio... de ser asi.. llama al administrador de sistemas urgentemente.
    </div>
  </div>
  @endforelse
</section>

@endsection
