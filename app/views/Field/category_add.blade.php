


<br><br><br>
<div class="large-10 small-12 columns large-centered mainpage-container right">
	<div class="row">
		<div class="large-12 small-12 columns large-centered">
			<br><br><br>
			@if ($notification = Session::get('message'))
				<div data-alert class="alert-box success ">
					<label class="text-center label-white">{{ $notification }}</label>
					<a href="#" class="close">&times;</a>
				</div>
				<br>
			@endif
			<label class="size-24 nsi-asset-fnt"># Add Category<span style="margin-left: 40rem;"></label>
			<br>
				{{ Form::submit(' Save', ['class' => 'nsi-btn button size-14 fi-plus tiny radius', 'title' => 'Add Category']) }}
				<div class="row">
					<div class="large-12 small-12 columns input_fields_wrap">
						</br></br>
						<div class="row">
							<div class="large-4 small-12 columns">
									<label id="modalLbl">Name:
										<input type="text" placeholder="Enter Category name" id="textStyle" name="itemTb" class="radius" style=" margin-top: -1.9rem; margin-left: 15rem; ">
									</label>
									<label>Category Information:
										<input type="text" value="Brand" name="mytext[]" style=" margin-top: -1.7rem; margin-left: 15rem; " placeholder="Enter device data-field" readonly>
										<input type="text" value="Model" name="mytext[]" style=" margin-top: -0.5rem; margin-left: 15rem; " placeholder="Enter device data-field" readonly>
										<input type="text" value="Serial Number" name="mytext[]" style=" margin-top: -0.5rem; margin-left: 15rem; " placeholder="Enter device data-field" readonly>
										<input type="text" value="Product Key" name="mytext[]" style=" margin-top: -0.5rem; margin-left: 15rem; " placeholder="Enter device data-field" readonly>
										<input type="text" value="NSI Inventory Tag" name="mytext[]" style=" margin-top: -0.5rem; margin-left: 15rem; " placeholder="Enter device data-field" readonly>
										<input type="text" id="dp1" value="Date Purchased" name="mytext[]" style=" margin-top: -0.5rem; margin-left: 15rem; " placeholder="Enter device data-field" readonly>
										<input type="text" value="Order Number" name="mytext[]" style=" margin-top: -0.5rem; margin-left: 15rem; " placeholder="Enter device data-field" readonly>
										<input type="text" value="Purchased Cost" name="mytext[]" style=" margin-top: -0.5rem; margin-left: 15rem; " placeholder="Enter device data-field" readonly>
										<input type="text" value="Expiration Date" name="mytext[]" style=" margin-top: -0.5rem; margin-left: 15rem; " placeholder="Enter device data-field" readonly>
									</label>

								</div>

							</div>
						</div>
					</div>
				</div>
		</div>
	</div>
</div>