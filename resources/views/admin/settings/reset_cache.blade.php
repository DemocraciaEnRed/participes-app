<form method="POST" action="{{ route('admin.settings.cache') }}">
    @csrf
    <div class="form-group">
      <label><b>Resetear cache</b></label>
      <p>Si algún valor de la configuración esta mal, intente limpiando la cache</p>
    </div>
    <button type="submit" class="btn btn-sm btn-primary">Resetear cache</button>
  </form>