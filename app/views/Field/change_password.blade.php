


<br><br><br>
<div class="large-10 small-12 columns large-centered mainpage-container right">
	<div class="row">
		<div class="large-12 small-12 columns large-centered">
			
			<br><br><br>
			<label class="size-24 nsi-asset-fnt"># Change Password<span style="margin-left: 40rem;"></label>
			<br><br><br>
			<div>
				<label><span>Enter your Password:</span> <span >{{ Form::password('oldPass', ["class"=>"l-3 radius", "style"=>" margin-top: -1.8rem; margin-left: 10rem; "]) }}</span></label>
				<br>
				<label><span>Enter new Password:</span> <span >{{ Form::password('newPass', ["class"=>"l-3 radius", "style"=>" margin-top: -1.8rem; margin-left: 10rem; "]) }}</span></label>
				<br>
				<label><span>Confirm new Password:</span> <span >{{ Form::password('confirmPassword', ["class"=>"l-3 radius", "style"=>" margin-top: -1.8rem; margin-left: 10rem; "]) }}</span></label>
			</div>
		<br>
		<div class="large-6 small-12 columns large-centered">
			<button class="button push-1 size-14 success small radius left font-style-segoe" type="submit" style=" margin-left: 2.5rem; ">
				<span class="fi-check"> Update</span>
			</button>
		</div>
	</div>
</div>
<br>