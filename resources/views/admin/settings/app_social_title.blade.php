<form method="POST" action="{{ route('admin.settings.form') }}">
  @method('PUT')
  @csrf
  <div class="form-group">
    <label><b>Social Share - Titulo de la web</b></label>
    <input type="hidden"  name="name" value="app_social_title" >
    <input type="hidden"  name="type" value="string" >
    <input type="hidden"  name="cached" value="true" >
    <input type="text" class="form-control" name="value" placeholder="Título para redes y aplicación" maxlength="255" value="{{$settings['app_social_title']->value}}">
  </div>
  <button type="submit" class="btn btn-sm btn-primary">Editar</button>
</form>