



<div class="large-12 columns large-centered">
<br><br>
	<h1><label class="size-24 nsi-asset-fnt"># Category List</label></h1>
	<br><br><br>
	<table id="example1" class="dtable large-12" style="width: 100%; margin-bottom: 3rem;">
	</table>
</div>

<!-- CATEGORY MODAL -->
<div id="category_modal" class="reveal-modal small" data-reveal>
	<div class="panel modal-title cus-pan-hd-3 radius">
		<label class="size-22 label-black large-12 label-ln-ht-1">Add Category</label>
	</div>
	{{ Form::open(array('url' => 'addcategory')) }}
	<div class="row">
		<div class="large-12 small-12 columns input_fields_wrap">
			<label id="modalLbl">Add Category</label>
			<div class="row">
				<div class="large-10 small-12 columns">
				  	<input type="text" placeholder="Enter Category name" id="textStyle" name="itemTb" class="radius">
				</div>
			</div>
			</br></br>
			<div class="row">
				<div class="large-12 small-12 columns large-centered">
					<div class="row">
						<div class="large-10 small-12 columns">
							<label id="modalLbl">Category-Data</label>
							<input type="text" value="Manufacturer" name="mytext[]" placeholder="Enter device data-field" readonly>
							<input type="text" value="Department" name="mytext[]" placeholder="Enter device data-field" readonly>
							<input type="text" value="Purchased Date" name="mytext[]" placeholder="Enter device data-field" readonly>
						</div>
					</div>
				</div>
			</div>
		</div>
		<a class="close-reveal-modal">&#215;</a>
		<div class="large-12 columns">
			<div class="row">
				<div class="large-12 columns">
					<input class="button tiny radius size-16" type="submit" value="Add Item" name="submit">
					<Button class="button tiny radius size-16 add_field_button" id="Font"> Add Data-field</button>
				</div>
			</div>
		</div>
	</div>
	{{ Form::close() }}
</div>
