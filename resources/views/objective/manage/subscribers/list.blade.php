@extends('objective.manage.master')

@section('panelContent')

<section>
  <h1 class="">Subscriptores</h1>
  <p>Lorem ipsum dolor sit amet consectetur, adipisicing elit. In eius ad officia tempora, temporibus repudiandae id
    ipsum neque deserunt rerum esse delectus consectetur voluptates eveniet quaerat commodi ducimus mollitia dolorem.
  </p>
  <table class="table">
    <thead class="thead">
      <tr>
        <th scope="col">Nombre y apellido</th>
        <th class="text-center" scope="col">Email</th>
        <th class="text-center" scope="col">Fecha Subscripción</th>
      </tr>
    </thead>
    <tbody>
      @forelse($subscribers as $subscriber)
        <tr>
          <td>@include('utils.avatar',['avatar' => $subscriber->avatar, 'size' => 32, 'thumbnail' => true]){{$subscriber->name}} {{$subscriber->surname}}</td>
          <td class="text-center">{{$subscriber->email}}</td>
          <td class="text-center">@datetime($subscriber->pivot->created_at)</td>
        </tr>
      @empty
        <tr>
          <td colspan="4">No hay organizaciones</td>
        </tr>
      @endforelse
    </tbody>
  </table>
  {{ $subscribers->links() }}
</section>

@endsection
