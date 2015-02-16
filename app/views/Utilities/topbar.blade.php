



<div class=" sticky fixed ">
	<nav class="top-bar" data-topbar role="navigation">
		<ul class="title-area">
			<li class="name">
			<h1><a href="#">NorthStar Solutions Inc - Inventory</a></h1>
			</li>
		</ul>

		<section class="top-bar-section">
		<!-- Right Nav Section -->
			<ul class="right">
				<li class="divider"></li>
				<li><a href="#">Welcome :: {{ Auth::user()->firstname }}</a></li>
				<li class="divider"></li>
				<li>{{ link_to('user/change_password', ' Change Password', ["class" => "fi-key"]) }}</li>
				<li class="divider"></li>
				<li>{{ link_to('logout', ' Logout', ["class" => "fi-power"]) }}</li>

			</ul>
		</section>
	</nav>
</div>