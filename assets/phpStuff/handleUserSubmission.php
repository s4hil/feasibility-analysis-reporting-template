<?php
	if (isset($_POST['start'])) {
		include 'coreFuns.php';

		$name = clean($_POST['name']);
		$email = clean($_POST['email']);
		$country = clean($_POST['country']);

		$userInfo = array('name' => $name, 'email' => $email, 'country' => $country);

		$_SESSION['userInfo'] = $userInfo;
		
		if (isset($userInfo)) {
			header('location: ../../home.php');
		}
		else {
			header('location: ../../index.php');
		}
	}
?>