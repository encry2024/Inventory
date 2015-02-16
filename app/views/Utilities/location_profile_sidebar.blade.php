



<div class="large-2 small-12 columns" style="width: 15.66667%;">
	<div class="sidebar" style=" margin-left: -2rem; margin-right: 1rem; ">
		<ul class="side-nav">
		<br><br><br><br>
		<li>{{ link_to('mainpage', '&#x21a9; Home', array("class"=>"lrv-link tiny large-12 radius", "style"=>" margin-left: 3rem; "))}}</li>
			<li><a href="#" title="Edit location's name." data-reveal-id="editName" class="general foundicon-edit size-18"> Edit</a></li>
				@if (count($device) != 0)
					<li><a href="#" title="Delete location." data-reveal-id="errorModal" class="general foundicon-trash size-18"> Delete</a></li>
				@else
					<li><a href="#" title="Delete location." data-reveal-id="deleteModal" class="general foundicon-trash size-18"> Delete</a></li>
				@endif
			</br></br></br>
			<li>{{ link_to('location', '&#x21a9; Location', array("class"=>"lrv-link tiny large-12 radius", "style"=>" margin-left: 3rem; "))}}</li>
		</ul>
	</div>
</div>