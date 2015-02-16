@extends('Template.front')

@section('head')
@if ($alert = Session::get('flash_error'))
	<div class="large-12 columns" >
		<div class="panel" style=" margin: -0.95rem; background-color: #333; border-color: black; ">
			<label class="text-center" style=" color: whitesmoke; padding-top: 0.5rem; ">{{ $alert }}</label>
		</div>
	</div>
@endif
<div class="large-12 columns">
	<div class="row">
		<div class="large-8 columns large-centered">
			{{HTML::image('packages/imgs/portal-logo.png')}}
		</div>
	</div>
</div>
@endsection

@section('body')
	<!-- LOGIN FIELD -->
	@include('Field.login')
@endsection

@section('script')
@endsection

@section('style')
<style type="text/css">
	body {
		background-color: #0e7ac3 !important;
	}
</style>
@endsection