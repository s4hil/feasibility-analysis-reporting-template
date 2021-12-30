<?php
	header('Content-Type: application/json; charset=utf-8');
	require_once 'coreFuns.php';

	$response = array();

	if (isset($_SESSION['loginStatus'])) {
		if ($_SESSION['loginStatus'] == true) {

			$data = json_decode(file_get_contents("php://input"), true);
			$id = clean($data['id']);
			$q = clean($data['question']);

			$sql = "UPDATE `_questions` SET `question`='$q' WHERE `q_id` = '$id'";
			$res = $db->exec($sql);
			if ($res) {
				$response['status'] = true;
				$response['msg'] = "Question Updated!";
			}
			else {
				$response['status'] = false;
				$response['msg'] = "Couldn't Update Question!";
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