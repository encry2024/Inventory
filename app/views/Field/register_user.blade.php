



<br><br>
{{ Form::open(array('url'=>'registeruser')) }}
<div class="row">
	<label class="label-white size-39 text-center ">NorthStar User Registration</label>
</div>
<br><br>
<div class="row">
<br>
	<div class="large-6 columns large-centered">
		{{ Form::text('username', '', ['class'=>'error radius size-18 text-center font-style-segoe text-height-3', 'placeholder'=>'Enter your Username', 'id'=>'', 'name'=>'username']) }}
		@if ($errors->has('username')) <small class="error"><i class="fi-alert"> </i>{{ $errors->first('username') }}</small> @endif
	</div>
	<br>
	<div class="large-6 columns large-centered">
		{{ Form::password('password', ['class'=>'error radius size-18 large-10 text-center font-style-segoe text-height-3', 'placeholder'=>'Enter your Password', 'id'=>'', 'name'=>'password']) }}
		@if ($errors->has('password')) <small class="error"><i class="fi-alert"> </i>{{ $errors->first('password') }}</small> @endif
	</div>
	<br>
	<div class="large-6 columns large-centered">
		{{ Form::password('password_confirmation', ['class'=>'error radius size-18 large-10 text-center font-style-segoe text-height-3', 'placeholder'=>'Confirm your Password', 'id'=>'', 'name'=>'password_confirmation']) }}
		@if ($errors->has('password_confirmation')) <small class="error"><i class="fi-alert"> </i>{{ $errors->first('password_confirmation') }}</small> @endif
	</div>
	<br>
	<div class="large-6 columns large-centered">
		{{ Form::text('firstname', '', ['class'=>'error radius size-18 large-10 text-center font-style-segoe text-height-3', 'placeholder'=>'Enter your Firstname', 'id'=>'', 'name'=>'firstname']) }}
		@if ($errors->has('firstname')) <small class="error"><i class="fi-alert"> </i>{{ $errors->first('firstname') }}</small> @endif
	</div>
	<br>
	<div class="large-6 columns large-centered">
		{{ Form::text('lastname', '', ['class'=>'error radius size-18 large-10 text-center font-style-segoe text-height-3', 'placeholder'=>'Enter your Lastname', 'id'=>'', 'name'=>'lastname']) }}
		@if ($errors->has('lastname')) <small class="error"><i class="fi-alert"> </i>{{ $errors->first('lastname') }}</small> @endif
	</div>
	<br><br>
	<div class="large-6 small-12 columns large-centered">
		<div class="row">
			<div class="large-12 columns">
				<button class="button login-btn small large-12 radius large-centered font-style-segoe text-size-20" type="submit">
					<i class="fi-check"></i>
					<span>Create Account</span>
				</button>
			</div>
		</div>
	</div>
</div>

{{ Form::close() }}
<br>