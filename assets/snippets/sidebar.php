<style>
	.export-btn {
		display: flex;
		align-items: center;
	}
	.export-btn:hover {
		background: none;
	}
</style>
<aside class="side-bar bg-dark">
	<div id="navBtn"><i class="fas fa-bars"></i></div>
	<ul class="nav-list">
		<li tab-target="submissions-tab" class="tab-btn">
			<i class="fas fa-database"></i> Submissions
		</li>
		<li tab-target="questions-tab" class="tab-btn">
			<i class="fas fa-paperclip"></i> Questions
		</li>
		<li class="export-btn">
			<i class="fas fa-table"></i>&nbsp;
			<div class="dropdown">
			  <span class="dropdown-toggle" type="button" id="dropdownMenuButton1" data-bs-toggle="dropdown" aria-expanded="false">
			    Export
			  </span>
			  <ul class="dropdown-menu" aria-labelledby="dropdownMenuButton1">
			    <li>
			    	<a href="export.php?name=submissions" target="_blank">Submissions</a>
			    </li>
			    <li>
			    	<a href="export.php?name=users" target="_blank">User Data</a>
			    </li>
			  </ul>
			</div>
		</li>
		<a href="?logout" class="btn btn-danger mt-2">
			<i class="fas fa-power-off"></i> Logout
		</a>
		<?php
			if (isset($_GET['logout'])) {
				session_destroy();
				header('location: index.php');
			}
		?>
	</ul>
</aside>