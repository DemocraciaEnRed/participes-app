<form method="POST" action="{{ route('admin.settings.form') }}">
    @method('PUT')
    @csrf
    <div class="form-group">
      <label><b>Footer - Simple descripción</b></label>
      <input type="hidden"  name="name" value="app_footer_description" >
      <input type="hidden"  name="type" value="string" >
      <input type="hidden"  name="cached" value="true" >
      <input type="text" class="form-control" name="value" placeholder="Breve descripción para el footer" maxlength="255" value="{{$settings['app_footer_description']->value}}">
    </div>
    <button type="submit" class="btn btn-sm btn-primary">Editar</button>
  </form>