<?php
	header('Content-Type: application/json; charset=utf-8');
	require_once 'coreFuns.php';

	$response = array();

	if (isset($_SESSION['loginStatus'])) {
		if ($_SESSION['loginStatus'] == true) {

			$data = json_decode(file_get_contents("php://input"), true);

			$email = $_SESSION['userInfo']['email'];
			$step_id = $data['step_id'];
			$comment_val = $data['comment_val'];

			$sql = "INSERT INTO `_comments` (`email`,`step_id`,`comment`) VALUES(
				'$email',
				'$step_id',
				'$comment_val'
				)";
			$res = $db->exec($sql);
			if ($res) {
				$response['status'] = true;
				$response['msg'] = "Step(".$step_id.") Comment Added!";
			}
			else {
				$response['status'] = false;
				$response['msg'] = "Failed to add comment!";
			}
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