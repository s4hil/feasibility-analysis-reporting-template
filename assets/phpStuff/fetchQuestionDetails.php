<?php
	header('Content-Type: application/json; charset=utf-8');
	require_once 'coreFuns.php';

	$response = array();

	function fetchStepName($id)
	{
		global $db;
		$sql = "SELECT * FROM `_steps` WHERE `step_id` = '$id'";
		$res = $db->query($sql);
		if ($res) {
			$row = $res->fetchArray(SQLITE3_ASSOC);
			$name = $row['name'];
			return $name;
		}
	}

	if (isset($_SESSION['loginStatus'])) {
		if ($_SESSION['loginStatus'] == true) {

			$data = json_decode(file_get_contents("php://input"), true);

			$id = clean($data['q_id']);
			$sql = "SELECT * FROM `_questions` WHERE `q_id` = '$id'";
			$res = $db->query($sql);
			if ($res) {
				$question = $res->fetchArray(SQLITE3_ASSOC);
				
				$response['status'] = true;
				$questionDetails = array();
				$questionDetails['q_id'] = $question['q_id'];
				$questionDetails['question'] = $question['question'];
				$questionDetails['step'] = fetchStepName($question['step_id']);
				$questionDetails['step_id'] = $question['step_id'];
				$response['data'] = $questionDetails;
			}
			else {
				$response['status'] = false;
				$response['msg'] = "Failed to fetch question!";
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