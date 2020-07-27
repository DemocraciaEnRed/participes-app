@extends('layouts.app')

@section('content')
<div class="container">
	<div class="row justify-content-center">
		<div class="col-md-8 text-center">
			<img src="{{asset('img/participes-color.svg')}}" width="300" class="img-fluid mb-5 mt-2">
			<h5>{{ __('Verify Your Email Address') }}</h5>
			@if (session('resent'))
			<div class="alert alert-info" role="alert">
				<i class="fas fa-info-circle"></i>&nbsp;{{ __('A fresh verification link has been sent to your email address.') }}
			</div>
			@else
			<p>{{ __('Before proceeding, please check your email for a verification link.') }}</p>
			<p>{{ __('If you did not receive the email') }}</p>
			<form class="d-inline" method="POST" action="{{ route('verification.resend') }}">
				@csrf
				<button type="submit"
					class="btn btn-link p-0 m-0 align-baseline">{{ __('click here to request another') }}</button>.
			</form>
			@endif
		</div>
	</div>
</div>
@endsection