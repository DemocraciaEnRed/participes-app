<form method="POST" action="{{ route('admin.settings.form') }}">
    @method('PUT')
    @csrf
    <div class="form-group">
      <label><b>Home - Subtitulo</b></label>
      <input type="hidden"  name="name" value="app_home_subtitle" >
      <input type="hidden"  name="type" value="string" >
      <input type="hidden"  name="cached" value="true" >
      <input type="text" class="form-control" name="value" placeholder="Breve descripción en el header de la home" value="{{$settings['app_home_subtitle']->value}}">
    </div>
    <button type="submit" class="btn btn-sm btn-primary">Editar</button>
  </form>