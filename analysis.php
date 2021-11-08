<?php
session_start();
	class DB extends sqlite3
	{
		function __construct()
		{

			$this->open("assets/db/the_db.sqlite");
		}
	}
	
	$db = new DB();

	function processResponseStr($str)
	{
		$sum = 0;
		$str_array = explode('|', $str);

		for ($i = 0; $i < count($str_array); $i++) { 
			$arr = explode('=', $str_array[$i]);
			$num = str_replace(' ', '', $arr[1]);
			$sum += (int)$num;
		}
		return $sum;
	}

	function getStepsSum()
	{
		global $db;
		$res = $db->query("SELECT * FROM `_questions`");
		$count = 0;
		while ($row = $res->fetchArray(SQLITE3_ASSOC)) {
			$count++;
		}
		return $count * 5;
	}

	$feasibilityPercentage = "";
	$sum = "";

	if (isset($_SESSION['responseStr'])) {
		$sum = processResponseStr($_SESSION['responseStr']);

		$maxVal = getStepsSum();
		$feasibilityPercentage = round($sum / $maxVal * 100, 2);
		session_destroy();
	}
?>

<!DOCTYPE html>
<html>
<head>
	<!-- Basic Metas -->
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<title>Analysis - FART</title>
	<link rel="icon" href="assets/imgs/favicon.png" type="image/x-icon">

	<!-- CSS -->
	<link rel="stylesheet" type="text/css" href="assets/css/bootstrap.min.css">
	<link rel="stylesheet" type="text/css" href="assets/css/common.css">

	<!-- Google Fonts -->
	<link rel="preconnect" href="https://fonts.googleapis.com">
	<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
	<link href="https://fonts.googleapis.com/css2?family=Open+Sans:wght@400;500;600;700&display=swap" rel="stylesheet">

	<!-- Font Awesome -->
	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta2/css/all.min.css"/>

	<style>
		:root{
			--purple: #11103E;
		}
		.wrapper {
			display: flex;
			align-items: center;
			flex-direction: column;
			height: 100vh;
			width: 100%;
			justify-content: center;
			overflow: hidden;
		}
		.bar-container {
			width: 100%;
			height: 15px;
			background: #fff;
			border-radius: 5px;
			box-shadow: 2px 2px 5px var(--purple);
		}
		.progress {
			width:<?php echo ceil($feasibilityPercentage)."%" ?>;
			height: 100%;
			background-color: var(--purple);
		}
		header h1 {
			color: var(--purple);
			font-weight: 700;
			font-size: 4rem;
		}
		.bg-img {
			position: absolute;
			z-index: -1;
			top: 50%;
			left: 50%;
			transform: translate(-50%,-50%);
			height: 80%;
			opacity: .2;
		}
		h3 span {
			font-weight: 700;
		}
	</style>
</head>
<body>
	<img class="bg-img" src="assets/imgs/designer.svg">
	<main class="wrapper container text-center">
		<header>
			<h1 class="">Analysis</h1>
			<h5 class="text-secondary">We analysed your response and this is what we've found out.</h5>
		</header>
		<div class="analysis-container w-100 mt-5">
			<h3>Your idea is <span><?php echo $feasibilityPercentage; ?>%</span> feasible.</h3>
			<div class="bar-container mt-4"><span class="progress"></span></div>
		</div>
		<h6 class="mt-4">Sum = <?php echo $sum; ?> (to be hidden later)</h6>
		<a href="index.php" class="mt-4 btn- lg btn btn-success"><i class="fas fa-home"></i> HOME</a>
	</main>
	
    <script src="assets/js/jquery.min.js"></script>
	<!-- <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
    <script src="assets/js/main.min.js"></script> -->
    <script>
  
    </script>
</body>
</html>
