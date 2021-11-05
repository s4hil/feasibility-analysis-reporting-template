<?php
	header('Content-Type: application/json; charset=utf-8');
	require_once 'coreFuns.php';

	$response = array();

	$data = json_decode(file_get_contents("php://input"), true);

	$id = clean($data['q_id']);

	$sql = "DELETE FROM `_questions` WHERE `q_id` = '$id'";
	$res = $db->exec($sql);
	if ($res) {
		$response['status'] = true;
		$response['msg'] = "Question Deleted!";
	}
	else {
		$response['status'] = false;
		$response['msg'] = "Failed to delete!";
	}
	echo json_encode($response);
?>