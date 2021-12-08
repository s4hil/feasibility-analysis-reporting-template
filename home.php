<?php
	session_start();

	// DB Connection
	class DB extends SQLITE3
	{
		
		function __construct()
		{
			$this->open('assets/db/the_db.sqlite');
		}
	}
	$db = new DB();
?>

<!DOCTYPE html>
<html>
<head>
	<!-- Basic Metas -->
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<title>Home - FART</title>
	<link rel="icon" href="assets/imgs/favicon.png" type="image/x-icon">

	<!-- CSS -->
	<link rel="stylesheet" type="text/css" href="assets/css/bootstrap.min.css">
	<link rel="stylesheet" type="text/css" href="assets/css/common.css">
	<link rel="stylesheet" type="text/css" href="assets/css/home.css">

	<!-- Google Fonts -->
	<link rel="preconnect" href="https://fonts.googleapis.com">
	<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
	<link href="https://fonts.googleapis.com/css2?family=Open+Sans:wght@400;500;600;700&display=swap" rel="stylesheet">

	<!-- Font Awesome -->
	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta2/css/all.min.css"/>
	<style>
		#msg {
			position: absolute;
			top: 10px;
			right: 10px;
			padding: 1rem;
			border-radius: 7px;
			font-weight: 700;
			display: none;
		}

		.wrapper {
			height: 100vh;
			overflow: hidden;
		}
		.side-bar {
			height: 100%;
		}
		.step-questions {
			height: 80%;
			overflow-y: scroll;
		}
		@media only screen and (max-width: 768px){
			aside.side-bar {
				display: none;
			}
			.main-content {
				width: 100%;
			}
			
		}
	</style>
</head>
<body>
	<div id="msg" class="alert alert-danger"></div>
	<main class="wrapper">
		<aside class="side-bar">
			<header class="nav-header">FART</header>
			<nav class="steps-nav">
				<ul class="steps-nav-list">
					
					<li class="inactive">
						<div>2</div> Technical Feasibility
					</li>
				</ul>
			</nav>
		</aside>
		<section class="main-content">
			<div class="container q-container">
				<div class="form-container">
					<form class="main-form" method="POST" action="?">
						<h6 class="step-progress">Step <span id="current-step">1</span>/7</h6>
						<div class="step step-questions">
							<h2 class="step-header d-flex"><div id="step-name"></div></h2>
							<div class="fields">
								<!-- To be populated by js -->
							</div>
						</div>

						<!-- Step Navigation -->
						<div class="d-flex justify-content-end mt-4">
							<button class="btn btn-lg btn-primary ml-2" id="showNextStep">
								<i class="fas fa-arrow-right"></i> Next Step
							</button>
							<button style="display: none;" class="btn btn-lg btn-success" id="submitForm" name="submitForm" onerror="popAlert('hi')">Finish</button>
						</div>
					</form>
					<?php 
						if (isset($_POST['submitForm'])) {
							$id = rand(1000, 9999)-1;
							$userInfo = $_SESSION['userInfo'];
							$name = $userInfo['name'];
							$email = $userInfo['email'];
							$sql1 = "INSERT INTO `_users` (`user_id`, `name`, `email`) VALUES (
									'$id',
									'$name',
									'$email'
									)";
							$res1 = $db->exec($sql1);
							if ($res1) {
								$response = "";
								foreach ($_POST as $key => $field) {
									$response .= $key . " = " . $field . " | "; 
								}
								$response = str_replace("| submitForm =  | ", "", $response);
								$sql = "INSERT INTO `_submissions` (`response`, `user_id`) VALUES(
												'$response',
												'$id'
										)";
								$res = $db->exec($sql);
								if ($res) {
										// Setting session vars for analysis
										$_SESSION['responseStr'] = $response;
									?>
										<script>
											window.location = "analysis.php";
											alert("Submission Received!");
										</script>
									<?php
								}
							}
						}
					?>
				</div>
			</div>
		</section>
	</main>
	<script src="assets/js/jquery.min.js"></script>
	<script src="assets/js/home.js"></script>
</body>
</html>