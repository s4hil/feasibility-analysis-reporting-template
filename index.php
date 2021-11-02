<!DOCTYPE html>
<html>
<head>
	<!-- Basic Metas -->
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<title>Feasibility Analysis Reporting Template</title>
	<link rel="icon" href="assets/imgs/favicon.png" type="image/x-icon">

	<!-- CSS -->
	<link rel="stylesheet" type="text/css" href="assets/css/bootstrap.min.css">
	<link rel="stylesheet" type="text/css" href="assets/css/common.css">
	<link rel="stylesheet" type="text/css" href="assets/css/index.css">

	<!-- Google Fonts -->
	<link rel="preconnect" href="https://fonts.googleapis.com">
	<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
	<link href="https://fonts.googleapis.com/css2?family=Open+Sans:wght@400;500;600;700&display=swap" rel="stylesheet">

	<!-- Font Awesome -->
	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta2/css/all.min.css"/>
</head>
<body>
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
			<div class="container">
				<div class="form-container">
					<form class="main-form">
						<h6 class="step-progress">Step <span id="current-step">1</span>/7</h6>
						<div class="step step-questions">
							<h2 class="step-header d-flex"><div id="step-name"></div></h2>
							<div class="fields">
								<!-- To be populated by js -->
							</div>
						</div>

						<!-- Step Navigation -->
						<div class="d-flex justify-content-end mt-4">
							<button id="showPrevStep" disabled class="btn btn-lg btn-secondary mr-3 disabled">
								<i class="fas fa-arrow-left"></i> Back 
							</button>
							<button class="btn btn-lg btn-primary" id="showNextStep">Next Step</button>
							<button class="btn btn-lg btn-success" style="display: none;" id="submitForm">Finish</button>
						</div>
					</form>
				</div>
			</div>
		</section>
	</main>
	<script src="assets/js/jquery.min.js"></script>
	<script src="assets/js/index.js"></script>
</body>
</html>