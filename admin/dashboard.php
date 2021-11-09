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
	<!-- <link rel="stylesheet" type="text/css" href="../assets/css/dashboard.css"> -->

	<!-- Google Fonts -->
	<link rel="preconnect" href="https://fonts.googleapis.com">
	<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
	<link href="https://fonts.googleapis.com/css2?family=Open+Sans:wght@400;500;600;700&display=swap" rel="stylesheet">

	<!-- Font Awesome -->
	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta2/css/all.min.css"/>

	<style>
		body {
			overflow-x: hidden;
			display: flex;
		}
		main {
			width: 100%;
			height: 100%;
		}
		.main-nav {
			width: 100%;
			height: 10vh;
		}
		.side-bar {
			width: 200px;
			height: 100vh;
			position: absolute;
			left: -200px;
			transition: all .3s ease;
			z-index: 1;
		}
		.nav-list {
			margin-top: 2rem;
			padding: 1rem;
			list-style-type: none;
		}
		.nav-list li{
			padding: .5rem;
			color: #fff;
		}
		.nav-list li:hover {
			background: #fff;
			color: grey;
			cursor: pointer;
		}
		#navBtn {
			width: 40px;
			height: 40px;
			display: flex;
			justify-content: center;
			align-items: center;
			border: 1px solid grey;
			border-radius: 4px;
			color: #fff;
			font-size: 1.5rem;
			position: absolute;
			left: 210px;
			top: 10px;
			z-index: 1;
			cursor: pointer;
		}
		.show-nav{
			left: 0px;
		}

		.tab {
			width: 100%;
			height: 100%;
			display: flex;
			justify-content: center;
			align-items: center;
		}
		.home-tab {
			display: none;
		}
		.submissions-tab {
			flex-direction: column;
		}
		.questions-list {
			list-style-type: none;
		}
		.header {
			width: 100%;
			align-items: center;
		}
		@media only screen and (max-width: 768px){
			.mobile-hidden {
				display: none;
			}
		}
	</style>
</head>
<body>
	<aside class="side-bar bg-dark">
		<div id="navBtn"><i class="fas fa-bars"></i></div>
		<ul class="nav-list">
			<li tab-target="questions-tab" class="tab-btn">
				<i class="fas fa-paperclip"></i> Questions
			</li>
			<li tab-target="submissions-tab" class="tab-btn">
				<i class="fas fa-database"></i> Submissions
			</li>
			<li>
				<a href="?logout" class="btn btn-danger">
					<i class="fas fa-power-off"></i> Logout
				</a>
				<?php
					if (isset($_GET['logout'])) {
						session_destroy();
						header('location: index.php');
					}
				?>
			</li>
		</ul>
	</aside>
	<main>
		<nav class="main-nav bg-dark"></nav>

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
					<div id="msg"></div>
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
	</main>

	<!-- Submission Modal -->
	<div class="modal fade" id="submission-modal" tabindex="-1" aria-labelledby="submission-modal" aria-hidden="true">
	  <div class="modal-dialog modal-xl">
	    <div class="modal-content">
	      <div class="modal-header">
	        <h5 class="modal-title" id="submission-by"></i></h5>
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
	<script>
		// Manage navbar
		let navVisible = false;
		function manageNavbar() {
			if (navVisible == false) {
				$(".side-bar").addClass('show-nav');
				$("#navBtn").html("<i class='fas fa-times'></i>");
				navVisible = true;
			}
			else {
				$(".side-bar").removeClass('show-nav');
				$("#navBtn").html("<i class='fas fa-bars'></i>");
				navVisible = false;
			}
		}
		$("#navBtn").click(()=>{
			manageNavbar();
		});

		// Load questions
		function loadQuestionsTable() {
			let output = "";
			$.ajax({
				url: "../assets/phpStuff/fetchAllQuestions.php",
				method: "GET",
				dataType: "json",
				success: function (data) {
					if (data.status == true) {
						let x = data.data;
						let count = 1;
						for(let i = 0; i < x.length; i++){
							output += `<tr>
									<td>`+ count++ +`</td>
									<td>`+ x[i].question.substr(0,50)+"..."+ `</td>
									<td>`+ x[i].step_id +`</td>
									<td>
										<button class='btn-sm btn btn-danger del-btn' q-id='`+ x[i].q_id +`''> 
											<i class='fas fa-trash-alt'></i> Delete
										</button>
									</td>
								</tr>`;
						}
						$("#questions-table-body").html(output);
					}
					else {
						console.log(data.msg);
					}
				},
				error: function () {
					console.log("err wd fetch questions req");
				}
			});
		}
		loadQuestionsTable();

		// Loading steps for select input
		function loadOptions() {
			let output = "<option value='none'>Select</option>";
			$.ajax({
				url: "../assets/phpStuff/fetchStepsNav.php",
				method: "GET",
				dataType: "json",
				success: function (data) {
					if (data.status == true) {
						x = data.data;
						for (let i = 0; i < x.length; i++){
							output += `
									<option value='`+ x[i].step_id +`'>`+ x[i].name+` (`+ x[i].step_id +`)` +`</option>
								`; 
						}
						$("#stepsField").html(output);
					}

				},
				error: function () {
					console.log("Err wd fetch options req!");
				}
			});
		}
		loadOptions();

		// Saving question
		$("#addQuestion").click((e)=>{
			e.preventDefault();

			let question = $("#question-text").val();
			let step = $("#stepsField").val();

			const data = JSON.stringify({ question:question, step_id:step });

			$.ajax({
				url: "../assets/phpStuff/addQuestion.php",
				method: "POST",
				data: data,
				dataType: "json",
				success: function (data) {
					if (data.status == true) {
						loadQuestionsTable();
						$(".form")[0].reset();
						$("#msg").html("<div class='alert alert-warning'><i class='fas fa-info-circle'></i> "+ data.msg +"</div>");
					}
				},
				error: function () {
					console.log("err wd add question req");
				}

			});
		});

		// Delete question on click
		$("#questions-table-body").on('click', '.del-btn', function () {
			let id = $(this).attr("q-id");
			let myThis = this;
			if (confirm("Are You Sure?")) {
				const data = JSON.stringify({q_id:id});
				$.ajax({
					url: "../assets/phpStuff/deleteQuestion.php",
					method: "POST",
					data: data,
					dataType: "json",
					success: function (data) {
						if (data.status == true) {
							$(myThis).closest('tr').fadeOut();
							$("#msg").html("<div class='alert alert-warning'><i class='fas fa-info-circle'></i> "+ data.msg +"</div>");
						}
					},
					error: function () {
						console.log("err wd del question req");
					}

				});
			}
		});

		// Manage tabs
		$(".nav-list").on('click', '.tab-btn', function () {

			$('.tab').css('display', 'none');
			
			let name = $(this).attr('tab-target');
			$('section[tab-name="' + name + '"]').fadeIn();
		});

		// Fetch submissions
		function loadSubmissions() {
			let output = "";
			let count = 1;
			$.ajax({
				url: "../assets/phpStuff/fetchUsers.php",
				method: "GET",
				dataType: "json",
				success: function (data) {
					if (data.status == true) {
						x = data.data;
						for (let i = 0; i < x.length; i++){
							output += `<tr>
									<td>`+ count++ +`</td>
									<td>`+ x[i].name +`</td>
									<td class='mobile-hidden'>`+ x[i].email +`</td>
									<td>
										<button class='btn btn-info view-btn' user-id='`+ x[i].user_id +`'>View</button>
										<button class='btn btn-danger'>Delete</button>
									</td>
								</tr>`;
						}
						$("#submissions-table").html(output);
					}

				},
				error: function () {
					console.log("Err wd fetch submissions req!");
				}
			});
		}
		loadSubmissions();

		// Display Submission Modal
		$("#submissions-table").on('click', '.view-btn', function () {
			let id = $(this).attr('user-id');
			const data = JSON.stringify({ user_id:id });
			let output = "";
			$.ajax({
				url: "../assets/phpStuff/fetchSubmission.php",
				method: "POST",
				data: data,
				dataType: "json",
				success: function (data) {
					console.log(data);
					if (data.status == true) {
						$("#submission-by").text(data.userName);
						x = data.data;
						for(let i = 0; i < x.length; i++){
							output += `
								<li>
									Id: <b>`+ x[i].q_id +`</b><br>
									`+ x[i].question +`<br>
									<span class='badge badge-success'>Ans:</span> <b>`+ x[i].answer +`</b>

								</li>
								<hr>
							`;
						}
						output = "<ul class='questions-list'>"+ output +"</ul>";
						$("#submission-info").html(output);
						$("#submission-modal").modal('show');
					}
				},
				error: function () {
					console.log("err wd fetch submission req");
				}

			});
		});
	</script>
</body>
</html>