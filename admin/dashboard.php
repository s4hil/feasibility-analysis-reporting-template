<?php
include 'adminAuth.php';
	if (isset($_SESSION['loginStatus'])) {
		if ($_SESSION['loginStatus'] != true) {
			die("Get Out!");
		}
	}
	else {
		die("Get Out");
	}
?>	

<!DOCTYPE html>
<html>
<head>
	<title>Dashboard - FART</title>
	<!-- Basic Metas -->
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<link rel="icon" href="../assets/imgs/favicon.png" type="image/x-icon">

	<!-- CSS -->
	<link rel="stylesheet" type="text/css" href="../assets/css/bootstrap.min.css">
	<link rel="stylesheet" type="text/css" href="../assets/css/common.css">
	<link rel="stylesheet" type="text/css" href="../assets/css/dashboard.css">
	<!-- <link rel="stylesheet" type="text/css" href="../assets/css/dashboard.css"> -->

	<!-- Google Fonts -->
	<link rel="preconnect" href="https://fonts.googleapis.com">
	<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
	<link href="https://fonts.googleapis.com/css2?family=Open+Sans:wght@400;500;600;700&display=swap" rel="stylesheet">

	<!-- Font Awesome -->
	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta2/css/all.min.css"/>

</head>
<body>
	<aside class="side-bar bg-dark">
		<div id="navBtn"><i class="fas fa-bars"></i></div>
		<ul class="nav-list">
			<li tab-target="submissions-tab" class="tab-btn">
				<i class="fas fa-database"></i> Submissions
			</li>
			<li tab-target="questions-tab" class="tab-btn">
				<i class="fas fa-paperclip"></i> Questions
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
	<main>
		<!-- For displaying alerts -->
		<div id="msg" class="alert alert-warning"><i class="fas fa-info-circle"></i></div>
		
		<nav class="main-nav bg-dark"></nav>
		<section class="container-fluid tab submissions-tab p-4" tab-name="submissions-tab">
			<div class="alert alert-info d-flex justify-content-between header">
				<h1><i class="fas fa-paperplane"></i> Submissions</h1>
				<a href="exportSubmissions.php" class="btn btn-warning" target="_blank">
					<i class="fas fa-table"> </i> Export Data
				</a>
			</div>
			<table class="table table-striped">
				<thead class="table-dark text-white">
					<tr>
						<th>S.no</th>
						<th>Name</th>
						<th class="mobile-hidden">Email</th>
						<th>Action</th>
					</tr>
				</thead>
				<tbody id="submissions-table">
					<!-- To be populated by js -->
				</tbody>
			</table>
		</section>

		<section class="tab home-tab" tab-name="questions-tab">
			<div class="container-fluid row d-flex justify-content-center mt-5">
				<div class="form-col col-sm-12 col-md-4 col-lg-4">
					<h2 class="alert alert-info">Add Question</h2>
					<form class="form">
						<fieldset class="form-group">
							<label>Question</label>
							<textarea id="question-text" rows="4" class="form-control" placeholder="Enter Question"></textarea>
						</fieldset>
						<fieldset class="form-group">
							<label>Select Step Catagory</label>
							<select id="stepsField" class="form-control">
								<!-- To be populated by js -->
							</select>
						</fieldset>
						<fieldset class="form-group">
							<button class="btn btn-primary form-control" id="addQuestion">Save</button>
						</fieldset>
					</form>
				</div>
				<div class="col col-sm-12 col-md-8 col-lg-8">
					<h2 class="alert alert-info">Questions</h2>
					<table class="table table-striped">
						<thead class="table-dark text-white">
							<tr>
								<th>S.no</th>
								<th>Question</th>
								<th>Step</th>
								<th>Action</th>
							</tr>
						</thead>
						<tbody id="questions-table-body">
							<!-- To be populated by js -->
						</tbody>
					</table>
				</div>
			</div>
		</section>
	</main>

	<!-- Submission Modal -->
	<div class="modal fade" id="submission-modal" tabindex="-1" aria-labelledby="submission-modal" aria-hidden="true">
	  <div class="modal-dialog modal-xl">
	    <div class="modal-content">
	      <div class="modal-header">
	        <h5 class="modal-title" id="submission-by"></i></h5><h4 id="score"></h4>
	        </h4>
	      </div>
	      <div class="modal-body" id="submission-info">
	     
	      </div>
	      <div class="modal-footer">
	        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
	      </div>
	    </div>
	  </div>

	<script src="../assets/js/jquery.min.js"></script>
	<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js"></script>
	<script src="../assets/js/dashboard.js"></script>
</body>
</html>