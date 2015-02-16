



<br><br>
@if ($notification = Session::get('notif'))
	<div data-alert class="alert-box success " style=" margin-top: -3rem; ">
		<label class="text-center label-white">{{ $notification }}</label>
		<a href="#" class="close">&times;</a>
	</div>
	<br>
@endif
<div class="large-10 small-12 columns large-centered mainpage-container right" style="margin-top: -3rem;">
	<div class="row">
		<div class="large-12 small-12 columns large-centered">
			<div class="applicantList">@include('Backend.category')</div>
		</div>
	</div>
</div>

