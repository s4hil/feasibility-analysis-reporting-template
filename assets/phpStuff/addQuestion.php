<?php
	header('Content-Type: application/json; charset=utf-8');
	require_once 'coreFuns.php';

	$response = array();

	$data = json_decode(file_get_contents("php://input"), true);

	$question = clean($data['question']);
	$step = clean($data['step_id']);

	$sql = "INSERT INTO `_questions` (`question`,`step_id`) VALUES('$question','$step')";
	$res = $db->exec($sql);
	if ($res) {
		$response['status'] = true;
		$response['msg'] = "Question Added!";
	}
	else {
		$response['status'] = false;
		$response['msg'] = "Failed To Add!";
	}
	echo json_encode($response);
?>