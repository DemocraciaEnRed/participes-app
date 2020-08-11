@if ($message = Session::get('success'))
<div class="alert alert-success alert-block rounded-0 mb-0">
    <div class="container">
      <button type="button" class="close" data-dismiss="alert">×</button>    
      <strong><i class="fas fa-check"></i>&nbsp;{{ $message }}</strong>
    </div>
</div>
@endif

@if ($message = Session::get('error'))
<div class="alert alert-danger alert-block rounded-0 mb-0">
    <div class="container">
      <button type="button" class="close" data-dismiss="alert">×</button>    
      {{-- <strong><i class="fas fa-times"></i>&nbsp;{{ $message }}</strong> --}}
      <strong><i class="fas fa-times"></i>&nbsp;Oh no! Hubo un error en la operaćión...</strong>
    </div>
</div>
@endif

@if ($message = Session::get('warning'))
<div class="alert alert-warning alert-block rounded-0 mb-0">
    <div class="container">
      <button type="button" class="close" data-dismiss="alert">×</button>    
      {{-- <strong><i class="fas fa-exclamation-triangle"></i>&nbsp;{{ $message }}</strong> --}}
      <strong><i class="fas fa-exclamation-triangle"></i>&nbsp;Oh no! Hubo un error en la operaćión...</strong>
    </div>
</div>
@endif


@if ($message = Session::get('info'))
<div class="alert alert-info alert-block rounded-0 mb-0">
    <div class="container">
      <button type="button" class="close" data-dismiss="alert">×</button>    
      <strong><i class="fas fa-info-circle"></i>&nbsp;{{ $message }}</strong>
    </div>
</div>
@endif

@if ($errors->any())
<div class="alert alert-danger rounded-0 mb-0">
    <div class="container">
      <button type="button" class="close" data-dismiss="alert">×</button>    
      Hubo un error en la operación. Por favor, revisé el mensaje de error.
    </div>
</div>
@endif