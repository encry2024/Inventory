



<div class="large-2 small-12 columns " style="width: 15.66667%;">
	<div class="sidebar " style=" margin-left: -3rem; margin-right: 1rem; ">
		<ul class="side-nav">
			<br><br><br><br>
			<li>{{ link_to('category/add', ' Create New', array('class' => 'lrv-link tiny size-14 fi-plus', "style"=>" margin-left: 3rem; ")) }}</li>
			<br><br>
			<li>{{ link_to('search/information', ' Search Information', $attributes = array('class' =>'size-14 fi-asterisk lrv-link tiny radius', 'title' => 'Add a Location for the Device', "style"=>" margin-left: 3rem; ")) }}</li>
			<li>{{ link_to('location', ' Create Owners', $attributes = array('class' =>'size-14 fi-marker lrv-link tiny radius', 'title' => 'Add a Location for the Device', "style"=>" margin-left: 3rem; ")) }}</li>
			<li>{{ link_to('devices/association', " Associations", ['class' =>'size-14 fi-thumbnails lrv-link tiny radius', 'title' => 'Check all the checked out devices', "style"=>" margin-left: 3rem; "]) }}</li>
			<li>{{ link_to('history' , ' History', $attributes = array('class' => 'size-14 lrv-link tiny radius fi-clipboard-notes', 'title' => "Check all the actions taken in history.", "style"=>" margin-left: 3rem; ")) }}</li>
		</ul>
	</div>
</div>