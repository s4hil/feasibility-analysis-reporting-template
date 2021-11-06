<?php
	if (isset($_POST['start'])) {
		include 'coreFuns.php';

		$name = clean($_POST['name']);
		$email = clean($_POST['email']);

		$userInfo = array('name' => $name, 'email' => $email);

		$_SESSION['userInfo'] = $userInfo;
		if (isset($userInfo)) {
			header('location: ../../home.php');
		}
		else {
			header('location: ../../index.php');
		}
	}
?>