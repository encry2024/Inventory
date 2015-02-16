



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
		<div class="large-12 small-12 large-centered">
			<br><br>
			<div class="large-12 small-12 large-centered">

				<h1><label class="size-24 nsi-asset-fnt"># {{ $device->name }} Profile</label></h1>

				<br>
				Device Information:
				<br><br>
				@foreach ($info as $dv_inf)
					<div class="large-12 columns">
						<label><span>{{ $dv_inf->field->category_label }}</span> <span> &mdash; </span> <span>{{ $dv_inf->value }}</span></label>
					</div>
					<br>
				@endforeach
				<br>
				Device Status:
				<br><br>
				<!-- DEVICE STATUS: NORMAL / DEFECTIVE / RETIRED -->
				@foreach ($dvc as $dev)
					<div class="large-3 columns"> 
						{{ Form::label('', 'Device Status:', array('class'=>'font-1 fontWeight')) }}
					</div>
					@if ($dev->status == "Retired" OR $dev->status == "Defective" OR $dev->status == "INACTIVE")
						<label class="label alert font-1 fontSize-6 fontSize-Device radius">{{ $dev->status }}</label>
						<label class="label alert font-1 fontSize-6 fontSize-Device radius">{{ $dev->comment }}</label>
					@elseif ($dev->status == "Normal" OR $dev->status == "ACTIVE")
						<label class="label success font-1 fontSize-6 fontSize-Device radius">Normal</label>
					@elseif ($dev->status == "Not Specified")
						<label class="label warning font-1 fontSize-6 fontSize-Device radius">{{ $dev->status }}</label>
					@endif
				@endforeach
				<br>
				<!-- DEVICE CURRENTLY ASSIGNED -->
				@foreach ($dvc as $dev)
					<div class="large-3 columns">
						{{ Form::label('', 'Currently Assigned:', array('class'=>'font-1 fontWeight')) }}
					</div>
					@if ($dev->location_id != 0)
						@if ($dev->location->name == '')
							{{ link_to('/location/'.$dev->location_id.'/profile' , $dev->location->lastname . ' ' . $dev->location->firstname, array('title'=>'Click here to go to locations profile.')) }}
						@endif
						{{ link_to('/location/'.$dev->location_id.'/profile' , $dev->location->name, array('title'=>'Click here to go to locations profile.')) }}
					@else
						@if ($dev->status == "Retired" OR $dev->status == "INACTIVE" OR $dev->status == "Defective" )
							<label class="label alert font-1 fontSize-6 fontSize-Device radius">{{ $dev->availability }}</label>
						@elseif ($dev->status == "ACTIVE" OR $dev->status == "Normal" OR $dev->status == "Not Specified")
							<label class="label success font-1 fontSize-6 fontSize-Device radius">{{ $dev->availability }}</label>
						@endif
					@endif
				@endforeach
				<br><br>
			</div>
		</div>
	</div>
</div>

<div class="large-10 small-12 columns large-centered mainpage-container right">
	<div class="row">
		<div class="large-12 small-12 columns large-centered">
			<div class="applicantList">@include('Backend.device_log')</div>
		</div>
	</div>
</div>


<!--DELETE MODAL-->
<div id="deleteModal" class="reveal-modal small" data-reveal>
	<div class="panel modal-title cus-pan-hd-3 radius">
		<label class="size-18 label-black large-12 label-ln-ht-1">Delete {{ $device->name }}</label>
	</div>
	{{ Form::open(array('url' => 'device/'.$device->id.'/delete')) }}
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
					{{ Form::submit('Delete Device', ["class"=>"button tiny nsi-btn radius size-14 right"]) }}
				</div>
			</div>
		</div>
		{{ Form::close() }}
	</div>
</div>

<!-- ASSIGN DEVICE TO LOCATION -->
<div id="assignModal" class="reveal-modal small" data-reveal>
	{{ Form::open(array('url' => 'assign')) }}
	<div class="panel modal-title cus-pan-hd-3 radius">
		<label class="size-18 label-black large-12 label-ln-ht-1">Associate {{ $device->name }}</label>
	</div>
	<div class="row">
		<div class="large-12 columns">
			<div class="large-12 columns">
				<label id="devFont"></label>

				<h1>{{ Form::label('','', array('name' => 'labelDevice', 'id'=>'devLabel', 'class' => 'deviceLbl')) }}</h1>
				{{ Form::hidden('idTb', '', array('name' => 'idTb', 'id'=>'id_textbox' )) }}
				{{ Form::hidden('itemID', $category->id) }}
				{{ Form::label('','Choose below where you want to assign the Device stated above.', array('class'=>'font-1 radius')) }}
				<br></br></br>
				{{ Form::label('', "Location's name", array('id'=>'Font')) }}
				<div id="demo" name="locationList"></div>
				<br><br><br>
				{{ Form::submit('Deploy' , $attributes = array('class' => 'size-14 button tiny large-12 radius', 'name' => 'submit')) }}
				</div>
			</div>
		</div>
		<a class="close-reveal-modal">&#215;</a>
	</div>
	{{ Form::close() }}
</div>

<!--CHANGE STATUS MODAL-->
<div id="updateStatus" class="reveal-modal small" data-reveal>
	{{ Form::open(array('url' => 'changestatus')) }}
	<div class="panel modal-title cus-pan-hd-3 radius">
		<label class="size-18 label-black large-12 label-ln-ht-1">Change {{ $device->name }} Status</label>
	</div>
	<div class="large-12 columns large-centered">
		<div class="row">
			<div class="large-12 columns ">
				<div class="large-12 columns">
					<label id="devFont"></label>
						{{ Form::hidden('', '', array('name' => 'devi_Id', 'id'=>'dev_id')) }}
					</br>
				</div>
				<div class="large-12 columns">
					{{ Form::label('item', 'Change Device Status', array('id' => 'modalLbl')) }}
				</div>
				</br>
			  	<div class="large-12 columns">
			  	</br>
			  	{{ Form::select('status', array('Normal'=>'Normal','Defective' =>'Defective', 'Retired'=>'Retired')) }}
			  	</br></br>
			  	{{ Form::label('Comment') }}
			  	{{ Form::textarea('commentArea','', ["style"=>" height: 4rem; "]) }}
			  	</br></br>
				{{ Form::submit('Update' , $attributes = array('class' => 'size-14 button tiny large-4 radius')) }}
				</div>
			</div>
		</div>
	</div>
	<a class="close-reveal-modal">&#215;</a>
	{{ Form::close() }}
</div>

<!--Dissociate MODAL-->
<div id="unAssignModal" class="reveal-modal small" data-reveal>
	{{ Form::open(array('url' => 'dissociate/device/'.$device->id)) }}
	<div class="panel modal-title cus-pan-hd-3 radius">
		<label class="size-18 label-black large-12 label-ln-ht-1">Dissociate {{ $device->name }}</label>
	</div>
	<div class="row">
		<div class="large-12 columns">
			<label id="devFont"></label>
			{{ Form::hidden('idTb', '', array('name' => 'idTb', 'id'=>'id_txtbox' )) }}
		</div>
		<div class="large-12 columns">
			{{ Form::label('', "Are you sure you want to dissociate " . $device->name . "?", array('id'=>'Font', 'class'=>'left')) }}
			</br>
		</div>
		<div class="sprtr">
		</div>
		<br>
		<div class="large-12 columns">
			{{ Form::submit('Dissociate' , $attributes = array('class' => 'nsi-btn size-14 button tiny radius large-3 right', 'name' => 'submit')) }}
		</div>
		<a class="close-reveal-modal">&#215;</a>
	</div>
	{{ Form::close() }}
</div>


<!--ERROR MESSAGE MODAL-->
<div id="errorModal" class="reveal-modal small" data-reveal>
	<div class="panel modal-title cus-pan-hd-3 radius">
		<label class="size-18 label-black large-12 label-ln-ht-1">Error: Cannot Delete {{ $device->name }}</label>
	</div>
	<div class="row">
		<div class="large-12 columns">

			<div class="large-12 columns">
				{{ Form::label('', "You cannot delete this item.", array( 'class'=>'font-1 ')) }}
				<br>
				{{ Form::label('', 'Someone is still using this Device. This device must be return first before you can delete this.', array('class'=>'font-1 font-6')) }}
			</div>
		</div>
		<a class="close-reveal-modal">&#215;</a>
	</div>
</div>

<!--ERROR MESSAGE MODAL-->
<div id="warningModal" class="reveal-modal small" data-reveal>
	<div class="panel modal-title cus-pan-hd-3 radius">
		<label class="size-18 label-black large-12 label-ln-ht-1">Error: Cannot change device status</label>
	</div>
	<div class="row">
		<div class="large-12 columns">
			<div class="large-12 columns">
				{{ Form::label('', "You cannot Change this Device's status while its on use.", array( 'class'=>'font-1 ')) }}
				<br>
				{{ Form::label('', 'This device must be returned first before you can edit this.', array('class'=>'font-1 font-6')) }}
			</div>
		</div>
		<a class="close-reveal-modal">&#215;</a>
	</div>
</div>


<!--Edit Device Modal-->
<div id="editDeviceModal" class="reveal-modal small" data-reveal>
	{{ Form::open(array('url' => 'update/'.$device->id.'/device')) }}

	<div class="panel modal-title cus-pan-hd-3 radius">
		<label class="size-18 label-black large-12 label-ln-ht-1">Edit {{ $device->name }}</label>
	</div>
	<div class="large-12 columns large-centered">
		<div class="row">
			<div class="large-12 columns ">
				<div class="large-12 columns">
				{{ Form::hidden('', $device->id, array('name' => 'deviceId', 'id'=>'device_id')) }}
				</br></br><br>
				{{ Form::label('', 'Description') }}
				{{ Form::text('device_name', $device->name, array('placeholder' => 'Enter Description', 'class'=>'radius center')) }}
				@foreach ($info as $device_field_info)
					{{ Form::label('itemName', $device_field_info->field->category_label, array('id' => 'Font')) }}
				  	<div class="row">
						<div class="large-12 columns large-centered">
							<div class="row">
								<div class="large-12 columns">
								@if ($device_field_info->field->category_label == "Date Purchased")
									{{ Form::text('date', $device_field_info->value , array('placeholder' => 'Enter Purchased Date', "class"=>"drp-element", 'id' => 'dp1', 'name'=>'field-'.$device_field_info->id, 'readonly')) }}
						  		@elseif ($device_field_info->field->category_label == "Expiration Date")
						  			{{ Form::text('date', $device_field_info->value , array('placeholder' => 'Enter Purchased Date', "class"=>"drp-element", 'id' => 'dp2', 'name'=>'field-'.$device_field_info->id, 'readonly')) }}
						  		@else
						  			{{ Form::text('', $device_field_info->value , $attributes = array('class'=>'radius center', 'name' => 'field-'. $device_field_info->id)) }}
						  		@endif
								</div>
							</div>
						</div>
					</div>
				@endforeach
				</br>
				{{ Form::submit('Update' , $attributes = array('class' => 'size-14 button tiny large-12 radius', 'name' => 'submit')) }}
				</div>
			</div>
		</div>
	</div>
	<a class="close-reveal-modal">&#215;</a>
	{{ Form::close() }}
</div>