



<div class="large-2 small-12 columns" style="width: 15.66667%;">
	<div class="sidebar" style=" margin-left: -2rem; margin-right: 1rem; ">
		<ul class="side-nav">
		<br><br><br><br>
			<li>{{ link_to('', ' Add', $attributes = array('class' => 'fi-plus lrv-link tiny large-12 radius', 'title' => 'Add a Device', 'data-reveal-id' => 'add_device', "style"=>" margin-left: 3rem; ")) }}</li>
			<li>{{ link_to('category/'.$category->id.'/edit', ' Edit', array( 'class' => 'fi-pencil lrv-link large-12 small-12 tiny radius', 'title' => 'Edit Device', "style"=>" margin-left: 3rem; ")) }}</li>
			<li>{{ link_to('#', ' Import XLS', array('class' => 'fi-archive lrv-link large-12 tiny radius delete_user', 'data-reveal-id' => 'import_modal', "style"=>" margin-left: 3rem; ", 'title' => 'Import an XLS files.' )) }}</li>
			<li>{{ link_to('#', ' Delete', array('class' => 'fi-trash lrv-link large-12 tiny radius delete_user', 'data-reveal-id' => 'deleteModal', "style"=>" margin-left: 3rem; ", 'title' => 'Delete selected Device' )) }}	</li>
			
			</br></br></br>
			<li>{{ link_to('mainpage', '&#x21a9; Home', array("class"=>"lrv-link tiny large-12 radius", "style"=>" margin-left: 3rem; "))}}</li>
		</ul>
	</div>
</div>