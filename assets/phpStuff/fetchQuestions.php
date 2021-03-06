<?php
	header('Content-Type: application/json; charset=utf-8');
	require_once 'coreFuns.php';

	$response = array();
	$rows = array();

	$data = json_decode(file_get_contents("php://input"), true);

	$step = clean($data['step']);

	$sql = "SELECT * FROM `_questions` WHERE `step_id` = '$step'";

	$res = $db->query($sql);
	if ($res) {
		$response['status'] = true;
		$count = 0;
		while ($row = $res->fetchArray(SQLITE3_ASSOC)) {	
			$rows[] = $row;
			$count++;
		}
		$response['data'] = $rows;
		$response['count'] = $count;
		if (fetchStepDetailsById($step) == "") {
			$response['step_name'] = 0;
		}
		else{
			$step_details = fetchStepDetailsById($step);
			$response['step_name'] = $step_details['name'];
			$response['step_detail'] = $step_details['detail'];
		}
		$response['total_steps'] = fetchTotalSteps();
	}
	else {
		$response['status'] = false;
		$response['msg'] = "Query Error!";
	}
	
	echo json_encode($response);
?>