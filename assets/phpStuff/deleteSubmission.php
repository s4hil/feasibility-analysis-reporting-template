<?php
	header('Content-Type: application/json; charset=utf-8');
	require_once 'coreFuns.php';
	$response = array();

	if (isset($_SESSION['loginStatus'])) {
		if ($_SESSION['loginStatus'] == true) {
			$data = json_decode(file_get_contents("php://input"), true);

			$user_id = clean($data['user_id']);

			if (isset($user_id) && $user_id != "") {
				$sql1 = "DELETE FROM `_users` WHERE `user_id` = $user_id";
				$sql2 = "DELETE FROM `_submissions` WHERE `user_id` = $user_id";

				$res1 = $db->exec($sql1);
				$res2 = $db->exec($sql2);

				if ($res1 && $res2) {
					$response['status'] = true;
					$response['msg'] = "Record Deleted!";
				}
				else {
					$response['status'] = false;
					$response['msg'] = "Failed To Delete Record!";
				}
			}
			else {
				$response['status'] = false;
				$response['msg'] = "Invalid Parameters!";
			}
			echo json_encode($response);
		}
		else {
			$response['status'] = false;
			$response['msg'] = "Unauthorized!";
			die(json_encode($response));

		}
	}
	else {
		$response['status'] = false;
		$response['msg'] = "Unauthorized!";
		die(json_encode($response));

	}

?>