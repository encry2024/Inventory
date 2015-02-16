




<div class="large-2 small-12 columns" style="width: 15.66667%;">
    <div class="sidebar" style=" margin-left: -2rem; margin-right: 1rem; ">
		<ul class="side-nav">
		<br><br><br><br>
		<li>{{ link_to('mainpage', '&#x21a9; Home', array("class"=>"lrv-link tiny large-12 radius", "style"=>" margin-left: 3rem; "))}}</li>
			@foreach ($dvc as $dev)
				@if ($dev->status == "Retired" OR $dev->status == "INACTIVE" OR $dev->status == "Defective" )
					<li>{{ link_to('#', ' Edit', array('onclick' => 'getDevProperty('. $device->id .', "'. $device->name .'")', 'class' => 'fi-pencil lrv-link tiny large-12 radius', 'title' => 'Edit Device', 'data-reveal-id' => 'editDeviceModal', 'disabled', "style"=>" margin-left: 3rem; ")) }}	</li>
				@elseif ($dev->status == "ACTIVE" OR $dev->status == "Normal" OR $dev->status == "Not Specified")
					<li>{{ link_to('#', ' Edit', array('onclick' => 'getDevProperty('. $device->id .', "'. $device->name .'")', 'class' => 'fi-pencil lrv-link tiny large-12 radius ', 'title' => 'Edit Device', 'data-reveal-id' => 'editDeviceModal', "style"=>" margin-left: 3rem; ")) }}	</li>
				@endif
			@endforeach
				<!--IF DEVICE IS NOT NORMAL AND IF DEVICE IS ASSIGNED. DISABLE ASSIGN DEVICE AND DELETE-->
			<?php
			foreach ($dvc as $dev) {
				if($dev->location_id != 0) {
					$locsName = $dev->location->name;
					echo "<li><a href='#' class='fi-trash  lrv-link tiny large-12 ' style=' margin-left: 3rem;' data-reveal-id = 'errorModal' > Delete</a></li>";
					echo "<li><a href='#' class='fi-x tiny  lrv-link large-12 ' style=' margin-left: 3rem;' onclick='dissociateDeviceProperty($dev->id, \"$dev->name\", \"$locsName\");' data-reveal-id = 'unAssignModal'> Dissociate</a></li>";
				} else {
					echo "<li><a href='#' class='fi-trash tiny  lrv-link large-12' style=' margin-left: 3rem;' data-reveal-id = 'deleteModal'> Delete</a></li>";
					if ($dev->status == "Retired" OR $dev->status == "INACTIVE" OR $dev->status == "Defective") {
						echo "<li><a href='#' class='fi-flag tiny  lrv-link large-12 ' style=' margin-left: 3rem;' onclick='assignDeviceProperty($dev->id, \"$dev->name\")' data-reveal-id = 'assignModal' disabled> Associate</a></li>";
					} else if ($dev->status == "ACTIVE" OR $dev->status == "Normal" OR $dev->status == "Not Specified") {
						echo "<li><a href='#' class='fi-flag tiny  lrv-link large-12 ' style=' margin-left: 3rem;' onclick='assignDeviceProperty($dev->id, \"$dev->name\")' data-reveal-id = 'assignModal'> Associate</a></li>";
					}
				}
			}
			?>
			<!--IF DEVICE STATUS IS RETIRED. DISABLE CHANGE STATUS-->
			@if ($dev->status == "Retired")
				<li>{{ link_to('#', ' Change Status', array("class"=>"fi-refresh  lrv-link tiny large-12 radius", 'onclick' => 'getValue('. $device->id .', "'. $device->name .'")', 'data-reveal-id' => 'updateStatus', "style"=>" margin-left: 3rem; "))}}</li>
			@else
				@if($dev->location_id == 0)
					<li>{{ link_to('', ' Change Status', array("class"=>"fi-refresh  lrv-link tiny large-12 radius", 'onclick' => 'getValue('. $device->id .', "'. $device->name .'")', 'data-reveal-id' => 'updateStatus', "style"=>" margin-left: 3rem; "))}}</li>
				@else
					<li>{{ link_to('#', ' Change Status', array("class"=>"fi-refresh  lrv-link tiny large-12 radius", 'onclick' => 'getValue('. $device->id .', "'. $device->name .'")', 'data-reveal-id' => 'warningModal', "style"=>" margin-left: 3rem; "))}}</li>
				@endif
			@endif
			
			</br></br></br>
			<li>{{ link_to('category/'. $devices .'/profile', '&#x21a9; Devices', $attributes = array('class' => 'tiny  lrv-link radius large-12', 'title' => 'Return to Devices', "style"=>" margin-left: 3rem; ")) }}</li>
		</ul>
	</div>
</div>