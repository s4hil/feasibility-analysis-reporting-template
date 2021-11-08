<?php
session_start();
	function clean($str)
    {
        return preg_replace('/[^\.\@\,\-\_A-Za-z0-9 ]/', '', $str);
    }
	if (isset($_POST['login'])) {
		$username = strtolower(clean($_POST['username']));
		$password = strtolower(clean($_POST['password']));

		if ($username == "aijaz" && $password == "aijaz@140") {
			$_SESSION['loginStatus'] = true;
			header('location: dashboard.php');
		}
		else {
			$_SESSION['msg'] = "Invalid Credentials!";
			$_SESSION['loginStatus'] = false;
			header('location: index.php');

		}
	}	
?>