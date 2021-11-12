<?php
	header('Content-Type: application/json; charset=utf-8');
	require_once 'coreFuns.php';

	$response = array();
	$rows = array();

	$data = json_decode(file_get_contents("php://input"), true);

	$user_id = clean($data['user_id']);

	$sql = "SELECT * FROM `_submissions` WHERE `user_id` = '$user_id' LIMIT 1";
	$res = $db->query($sql);
	if ($res) {
		$row = $res->fetchArray(SQLITE3_ASSOC);
		
		$userResponse = $row['response'];

		$arr = explode('|', $userResponse);


		for ($i=0; $i < count($arr); $i++) { 
			$newAr = explode('=', $arr[$i]);
			$qid = $newAr[0];
			$answer = str_replace(' ', '', $newAr[1]);
			
			$question = getQuestionById($qid);
			$question['answer'] = $answer;
			$rows[] = $question;

		}

		$response['status'] = true;
		$response['userName'] = getUserNameById($user_id);
		$response['data'] = $rows;


	}
	else {
		$response['status'] = false;
		$response['msg'] = "Query Failed!";
	}
	echo json_encode($response, JSON_PRETTY_PRINT);
?>