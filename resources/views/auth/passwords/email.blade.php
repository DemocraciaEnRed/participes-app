@extends('layouts.app')

@section('headscripts')
{!! NoCaptcha::renderJs('es') !!}
@endsection

@section('content')
<div class="container push-to-header">
	<div class="row justify-content-center">
		<div class="col-md-10 col-lg-8">
			<div class="text-center">
				<img src="{{asset('img/participes-white.svg')}}" width="300" class="img-fluid mb-5 mt-2"
					alt="{{ config('app.name', 'Laravel') }}">
			</div>
			@if ($errors->any())
			<div class="alert alert-danger">
				<ul class="mb-0">
					@foreach ($errors->all() as $error)
					<li>{{ $error }}</li>
					@endforeach
				</ul>
			</div>
			@endif
			<div class="card shadow-sm py-4">
				{{-- <div class="card-header">{{ __('Reset Password') }}</div> --}}

				<div class="card-body">
					@if (session('status'))
					<div class="alert alert-success" role="alert">
						{{ session('status') }}
					</div>
					@endif

					<form method="POST" action="{{ route('password.email') }}">
						@csrf

						<div class="form-group row">
							<label for="email" class="col-md-4 col-form-label text-md-right">{{ __('E-Mail Address') }}</label>

							<div class="col-md-6">
								<input id="email" type="email" class="form-control @error('email') is-invalid @enderror" name="email"
									value="{{ old('email') }}" required>
								@error('email')
								<span class="invalid-feedback" role="alert">
									<strong>{{ $message }}</strong>
								</span>
								@enderror
							</div>
						</div>

						<div class="form-group row">
							<label for="password-confirm" class="col-md-4 col-form-label text-md-right">Complete el desafio</label>

							<div class="col-md-6">
								{!! NoCaptcha::display(['data-theme' => 'light']) !!}
							</div>
						</div>

						<div class="form-group row mb-0">
							<div class="col-md-6 offset-md-4">
								<button type="submit" class="btn btn-primary">
									{{-- {{ __('Send Password Reset Link') }} --}}
									Enviar correo de recuperación
								</button>
								<a href="{{route('login')}}" class="btn btn-outline-white">Volver</a>
							</div>
						</div>
					</form>
				</div>
			</div>
		</div>
	</div>
</div>
@endsection