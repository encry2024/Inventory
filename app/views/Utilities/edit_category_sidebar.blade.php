








<div class="large-2 small-12 columns" style="width: 15.66667%;">
	<div class="sidebar" style=" margin-left: -2rem; margin-right: 1rem; ">
		<ul class="side-nav">
		<br><br><br><br>
			<li>{{ Form::submit('Update', $attributes = array('class' => 'lrv-link small large-5 radius', 'title' => "Click update to change the Item's Information", "style"=>" margin-left: 2.7rem; background-color: transparent; border-color: transparent;")) }}</li>
			<li>{{ link_to('/', 'Add Field', $attributes = array('class' => 'lrv-link tiny large-12 radius add_field_button', 'title' => 'Return Home', "style"=>" margin-left: 3rem;")) }}</li>
			</br></br></br>
			<li>{{ link_to('mainpage', '&#x21a9; Category', array("class"=>"lrv-link tiny large-12 radius", "style"=>" margin-left: 3rem; "))}}</li>
		</ul>
	</div>
</div>