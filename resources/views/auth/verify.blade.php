@extends('layouts.app')

@section('content')
<div class="container push-to-header">
	<div class="row justify-content-center">
		<div class="col-md-8 text-center">
				<div class="text-center">
				<img src="{{asset('img/participes-white.svg')}}" width="300" class="img-fluid mb-5 mt-2"
					alt="{{ config('app.name', 'Laravel') }}">
			</div>
			<div class="card shadow-sm">
				<div class="card-body py-5">
					<h3><i class="far fa-envelope fa-fw text-info"></i></h3>
			<h3 class="is-600">{{ __('Verify Your Email Address') }}</h3>
			@if (session('resent'))
			<div class="alert alert-info mt-4" role="alert">
				<i class="fas fa-info-circle"></i>&nbsp;{{ __('A fresh verification link has been sent to your email address.') }}
			</div>
			@else
			<p>{{ __('Before proceeding, please check your email for a verification link.') }}<br>{{ __('If you did not receive the email') }}...</p>
			<form class="d-inline" method="POST" action="{{ route('verification.resend') }}">
				@csrf
				<button type="submit"
					class="btn btn-outline-primary">{{ __('click here to request another') }}</button>
			</form>
			@endif
				</div>
			</div>
		</div>
	</div>
</div>
@endsection