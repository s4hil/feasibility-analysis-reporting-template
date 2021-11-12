<!DOCTYPE html>
<html lang="en">
<head>
	<title>Admin - FART</title>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<link rel="icon" type="image/png" href="images/icons/favicon.ico"/>

	<link rel="icon" href="../assets/imgs/favicon.png" type="image/x-icon">

	<!-- CSS -->
	<link rel="stylesheet" type="text/css" href="../assets/css/bootstrap.min.css">
	<link rel="stylesheet" type="text/css" href="../assets/css/common.css">

	<!-- Google Fonts -->
	<link rel="preconnect" href="https://fonts.googleapis.com">
	<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
	<link href="https://fonts.googleapis.com/css2?family=Open+Sans:wght@400;500;600;700&display=swap" rel="stylesheet">

	<!-- Font Awesome -->
	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta2/css/all.min.css"/>

	<style>
		*{
			box-sizing: border-box;
		}
		.wrapper {
			width: 100vw;
			height: 100vh;
			display: flex;
			justify-content: center;
			align-items: center;
			font-family: 'Open Sans', sans-serif;
			background: #f1f1f1;
		}
		.form-container {
			width: 30%;
		}
		.form-container header {
			font-size: 2rem;
			font-weight: 700;
			text-align: center;
			margin: 1rem;
		} 
		.form-group {
			width: 100%;
			border: 1px solid grey;
			display: flex;
			margin-top: 2rem;
		}
		.form-group i {
			width: 10%;
			display: flex;
			justify-content: center;
			align-items: center;
			background: #c4c4c4;
		}
		.input-box {
			padding: .75rem;
			width: 90%;
			outline: none;
			border: none;
		}
		.login-btn {
			margin-top: 2rem;
		}
		@media only screen and (max-width: 768px){
			.form-container {
				width: 90%;
			}
		}
	</style>
</head>
<body>

	<main class="wrapper">
		<div class="form-container">
			<?php
			include 'adminAuth.php';
			if (isset($_SESSION['msg'])) {
				?>
				<div class="alert alert-danger"><i class="fas fa-exclamation-circle"></i>
					<?php
						echo $_SESSION['msg'];
						unset($_SESSION['msg']);
					?>
				</div>
				<?php
			}

			?>
			<header>Login - Admin</header>
			<form class="form" action="adminAuth.php" method="POST">
				<fieldset class="form-group">
					<i class="fas fa-user"></i>
					<input type="text" name="username" class="input-box" placeholder="Username">
				</fieldset>
				<fieldset class="form-group">
					<i class="fas fa-lock"></i>
					<input type="password" name="password" class="input-box" placeholder="Password">
				</fieldset>
				<button name="login" type="submit" class="login-btn btn btn-success form-control">Login</button>
			</form>
		</div>
	</main>

	<!-- JS Scripts -->
	<script src="../assets/js/jquery.min.js"></script>
	<script src="../assets/js/admin.js"></script>
</body>
</html>