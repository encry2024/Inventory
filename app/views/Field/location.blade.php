



<br><br>
<div class="large-10 small-12 columns large-centered mainpage-container right" style="margin-top: -3rem;">
	<div class="row">
		<div class="large-12 small-12 large-centered">
			<br><br>
			<div class="large-12 small-12 large-centered">
				@include('Backend.location')
			</div>
		</div>
	</div>
</div>

<!-- ADD LOCATION MODAL -->

<div id="add_location" class="reveal-modal small" data-reveal>
	{{ Form::open(array('url' => 'add/location')) }}
	<div class="panel modal-title cus-pan-hd-3 radius">
		<label class="size-18 label-black large-12 label-ln-ht-1">Add Owner</label>
	</div>
	<div class="row">
		<div class="large-12 columns">
			{{ Form::hidden('idTb', '', array('name' => 'idTb', 'id'=>'id_textbox' )) }}
			</br>
		</div>

		<div class="large-12 columns">
			{{ Form::label('', "Lastname *", array('class'=>'size-16', 'id'=>'Font')) }}
			{{ Form::text('lname', '' , array('class' => 'radius', 'placeholder' => 'Lastname')) }}
		</div>

		<div class="large-12 columns">
			{{ Form::label('', "Firstname *", array('class'=>'size-16', 'id'=>'Font')) }}
			{{ Form::text('fname', '' , array('class' => 'radius', 'placeholder' => 'Firstname')) }}
		</div>

		<div class="large-12 columns">
			{{ Form::label('', "Location", array('class'=>'size-16', 'id'=>'Font')) }}
			{{ Form::text('locationTb', '' , array('class' => 'radius', 'placeholder' => 'Location')) }}
		</div>

		<div class="large-12 columns">
		<br><br><br>
			{{ Form::submit('Add Owner' , $attributes = array('class' => 'size-14 nsi-btn button tiny radius', 'name' => 'submit')) }}
		</div>
		<a class="close-reveal-modal">&#215;</a>
	</div>
	{{ Form::close() }}
</div>