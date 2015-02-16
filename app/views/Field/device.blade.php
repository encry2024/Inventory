



<br><br><br>
<div class="large-10 small-12 columns large-centered mainpage-container right">
	<div class="row">
		<div class="large-12 small-12 large-centered">
			<br><br>
			<div class="applicantList">@include('Backend.device')</div>
		</div>
	</div>
</div>


<!--DELETE MODAL-->
<div id="deleteModal" class="reveal-modal small" data-reveal>
	<div class="panel modal-title cus-pan-hd-3 radius">
		<label class="size-18 label-black large-12 label-ln-ht-1">Delete Category</label>
	</div>
	{{ Form::open(array('url' => 'Item/'.$category->id.'/delete')) }}
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
					{{ Form::submit('Delete Category', ["class"=>"button tiny nsi-btn radius size-14 right"]) }}
				</div>
			</div>
		</div>
		{{ Form::close() }}
	</div>
</div>

<!-- ADD DEVICE MODAL -->
<div id="add_device" class="reveal-modal small" data-reveal>
	{{ Form::open(array('url' => 'adddevice')) }}
	<div class="panel modal-title cus-pan-hd-3 radius">
		<label class="size-18 label-black large-12 label-ln-ht-1">Add {{ $category->name }}</label>
	</div>
	<div class="row">
		<div class="large-10 small-10 columns large-centered">
			<div class="row">
			<br>
				{{ Form::label('device', 'Description', array('id' => 'modalLbl')) }}
			  	{{ Form::text('', '', $attributes = array('class' => 'radius', 'id' => 'textStyle', 'placeholder' => 'Enter your description for this Item', 'name' => 'mydevice')) }}
			  	@foreach ($fields as $devField)
			  		{{ Form::label('itemName', $devField->category_label, array('id' => 'Font')) }}

			  		@if ($devField->category_label == "Date Purchased")
						{{ Form::text('date', '', ['class'=>'drp-element text-center radius', 'placeholder'=>'State the Date', 'name' => 'field-'. $devField->id, 'id'=>'dp1', 'readOnly']) }}
			  		@elseif ($devField->category_label == "Expiration Date")
			  		{{ Form::text('date', '', ['class'=>'drp-element text-center radius', 'placeholder'=>'State the Date', 'name' => 'field-'. $devField->id, 'id'=>'dp2', 'readOnly']) }}
			  		@else
			  			{{ Form::text('','', array('class' => 'radius', 'placeholder' => "Enter device's ". $devField->item_label, 'name' => 'field-'. $devField->id)) }}
			  		@endif
			  	@endforeach
				{{ Form::hidden('itemId', $category->id ) }}
				<br>
				{{ Form::submit('Add ' . $category->name , $attributes = array('class' => 'size-14 nsi-btn button small  large-12 radius', 'name' => 'submit')) }}
			</div>
		</div>
		<a class="close-reveal-modal">&#215;</a>
	</div>
	{{ Form::close() }}
</div>

<!--IMPORT MODAL-->
<div id="import_modal" class="reveal-modal small" data-reveal>
	<div class="panel modal-title cus-pan-hd-3 radius">
		<label class="size-18 label-black large-12 label-ln-ht-1">Import XLS</label>
	</div>
	{{ Form::open(array("url"=>"import/" . $category->id . "/data", 'files' => true)) }}
	<div class="row">
		<div class="large-12 small-12 columns input_fields_wrap">
			<div class="row">
				<div class="large-10 small-12 columns">
					<label>Filename</label>
					{{ Form::file('file','',array('')) }}
				</div>
			</div>
			
			<br>
			<div class="custom-separator"></div>
			{{ Form::submit('Import File', ["class"=>"button tiny nsi-btn radius size-14 right"]) }}
			<br><br>
			<label><i>Uploading files may take time depending on the items you are importing to.</i></label>
		</div>
		<a class="close-reveal-modal">&#215;</a>
		{{ Form::close() }}
	</div>
</div>