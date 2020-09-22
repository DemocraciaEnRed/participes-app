<form method="POST" action="{{ route('admin.settings.form') }}">
    @method('PUT')
    @csrf
    <div class="form-group">
      <label><b>Footer - Datos de contactos</b></label>
      <input type="hidden"  name="name" value="app_footer_contact_info" >
      <input type="hidden"  name="type" value="string" >
      <input type="hidden"  name="cached" value="true" >
      <textarea type="text" class="form-control" name="value" placeholder="Ingrese aqui datos de contacto" maxlength="255">{{$settings['app_footer_contact_info']->value}}</textarea>
    </div>
    <button type="submit" class="btn btn-sm btn-primary">Editar</button>
  </form>