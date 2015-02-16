



<br><br><br>
{{ Form::open(array('url'=>'authenticate')) }}
<div class="row">
<br>
	
	<div class="large-6 columns large-centered">
		{{ Form::text('username', '', ['class'=>'error radius size-18 text-center font-style-segoe text-height-3', 'placeholder'=>'Username', 'id'=>'', 'name'=>'username']) }}
		@if ($errors->has('username')) <small class="error"><i class="fi-alert"> </i>{{ $errors->first('username') }}</small> @endif
	</div>
	
	<br>
	
	<div class="large-6 columns large-centered">
		{{ Form::password('password', ['class'=>'error radius size-18 large-10 text-center font-style-segoe text-height-3', 'placeholder'=>'Password', 'id'=>'', 'name'=>'password']) }}
		@if ($errors->has('password')) <small class="error"><i class="fi-alert"> </i>{{ $errors->first('password') }}</small> @endif
	</div>
	
	<br>

	<div class="large-9 c-pull-1 small-12 columns large-centered">
	{{ link_to('register/user', " Create an account", ['class'=>'login-btn radius small button label-black text-size-20 right font-style-segoe fi-torso']) }}
	</div>
	<div class="large-6 small-12 columns large-centered">
		<button class="button login-btn small radius left font-style-segoe text-size-20" type="submit">
			<i class="fi-check"></i>
			<span>Login</span>
		</button>
	</div>
</div>


<br>