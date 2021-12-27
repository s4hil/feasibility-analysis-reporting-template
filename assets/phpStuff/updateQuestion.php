<?php
	header('Content-Type: application/json; charset=utf-8');
	require_once 'coreFuns.php';

	$response = array();

	if (isset($_SESSION['loginStatus'])) {
		if ($_SESSION['loginStatus'] == true) {

			$data = json_decode(file_get_contents("php://input"), true);

			$id = clean($data['q_id']);
			$q
			
		}
		else {
			$response['status'] = false;
			$response['msg'] = "Unauthorized User!";
		}
	}
	else {
		$response['status'] = false;
		$response['msg'] = "Unauthorized!";
	}

	
	echo json_encode($response);
?>