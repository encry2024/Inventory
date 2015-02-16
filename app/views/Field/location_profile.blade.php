



<br><br>
<div class="large-10 small-12 columns large-centered mainpage-container right" style="margin-top: -3rem;">
	<div class="row">
		<div class="large-12 small-12 large-centered">
			<br><br>
			<div class="large-12 small-12 large-centered">
				<label class="size-24 nsi-asset-fnt" ># {{ $location->name }} Profile</label>
				<label class="size-18 nsi-asset-fnt" >{{ $location->lastname }} {{ $location->firstname }}</label>
				<br>

			 	@foreach ($device as $devices)
			 		@if ($devices->deleted_at == '')
			 		<br>
			 		<div class="large-2 columns">
				 		{{ Form::label('', $devices->category->name . ': ', array('class'=>'font-1 fontSize-8 fontWeight')) }}
				 	</div>
				 	{{ link_to('device/'.$devices->id.'/profile', $devices->name, array('class'=>'font-1 fontSize-8 fontWeight') ) }}
					<br><br>


					<br><br>
					@endif
				@endforeach
			</div>
		</div>
	</div>
</div>
<div class="large-10 small-12 columns large-centered mainpage-container right">
	<div class="row">
		<div class="large-12 small-12 columns large-centered">
			<div class="applicantList">@include('Backend.location_log')</div>
		</div>
	</div>
</div>

<!--DELETE MODAL-->
<div id="deleteModal" class="reveal-modal small" data-reveal>
	
	<div class="panel modal-title cus-pan-hd-3 radius">
		<label class="size-18 label-black large-12 label-ln-ht-1">Delete Location</label>
	</div>
	{{ Form::open(array('url' => 'Item/'.$location->id.'/delete')) }}
	<div class="row">
		<div class="large-12 small-12 columns input_fields_wrap">
			<div class="row">
				<div class="large-10 small-12 columns">
					Are you sure you want to delete this?
				</div>
			</div>
			<br>
			<div class="separator"></div>
			<br>
		</div>
		<a class="close-reveal-modal">&#215;</a>
		<div class="large-12 columns">
			<div class="row">
				<div class="large-12 columns">
					{{ Form::submit('Delete Location', ["class"=>"button tiny nsi-btn radius size-14 right"]) }}
				</div>
			</div>
		</div>
		{{ Form::close() }}
	</div>
</div>


<!--EDIT MODAL-->
<div id="editName" class="reveal-modal small" data-reveal>
	{{ Form::open(array('url' => 'editLocation')) }}
	<div class="row">
		<div class="large-12 columns">
			<div class="large-12 columns">
				<h1 class="fontSize-3">{{ $location->name }}</h1>
			</div>
			<div class="large-12 columns">
				{{ Form::label('', 'Change Location Name', array( 'class'=>'fontSize-2 fontColor-black' , 'id' => 'modalLbl')) }}
					</br>
					{{ Form::label('locationName', 'Location Name', array('id' => 'Font')) }}
				  	<div class="row">
						<div class="large-12 columns large-centered">
							<div class="row">
								<div class="large-12 columns">
									{{ Form::text('lName', $location->name , array('placeholder' => 'Enter Location Name', 'name'=>'location-'.$location->id)) }}
								</div>
								</a>
							</div>
						</div>
					</div>
					</br>
				{{ Form::submit('Update' , $attributes = array('class' => 'button tiny large-12 radius', 'name' => 'submit')) }}
				</div>
		</div>
		<a class="close-reveal-modal">&#215;</a>
	</div>
	{{ Form::close() }}
</div>