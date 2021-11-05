<?php
	header('Content-Type: application/json; charset=utf-8');
	require_once 'coreFuns.php';

	$response = array();
	$rows = array();

	$sql = "SELECT * FROM `_questions` ORDER BY `q_id` ASC";
	$res = $db->query($sql);
	if ($res) {
		while ($row = $res->fetchArray(SQLITE3_ASSOC)) {
			$rows[] = $row;
		}
		$response['status'] = true;
		$response['data'] = $rows;
	}
	else {
		$response['status'] = false;
		$response['msg'] = "Query Failed!";
	}
	echo json_encode($response);
?>
