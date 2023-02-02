<form method="POST" action="{{ route('admin.settings.form') }}">
  @method('PUT')
  @csrf
  <div class="form-group">
    <label><b>Social Share - Descripción de la web</b></label>
    <p class="text-muted text-smaller">Esta es la descripción que se mostrará en las redes sociales, buscadores y en la aplicación.</p>
    <input type="hidden"  name="name" value="app_social_description" >
    <input type="hidden"  name="type" value="string" >
    <input type="hidden"  name="cached" value="true" >
    <input type="text" class="form-control" name="value" placeholder="Breve descripción para redes y aplicación" maxlength="255" value="{{$settings['app_social_description']->value}}">
  </div>
  <button type="submit" class="btn btn-sm btn-primary">Editar</button>
</form>