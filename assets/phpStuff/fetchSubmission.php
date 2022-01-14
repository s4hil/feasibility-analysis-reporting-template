<?php
	header('Content-Type: application/json; charset=utf-8');
	require_once 'coreFuns.php';

	$response = array();
	$rows = array();

	function getResponseScore($str)
	{
		$sum = 0;
		$str_array = explode('|', $str);

		for ($i = 0; $i < count($str_array); $i++) { 
			$arr = explode('=', $str_array[$i]);
			$num = str_replace(' ', '', $arr[1]);
			$sum += (int)$num;
		}
		return $sum;
	}

	$data = json_decode(file_get_contents("php://input"), true);

	$user_id = clean($data['user_id']);
	$user_email = fetchEmailById($user_id);

	$sql = "SELECT * FROM `_submissions` WHERE `user_id` = '$user_id' LIMIT 1";
	$res = $db->query($sql);
	if ($res) {
		$row = $res->fetchArray(SQLITE3_ASSOC);
		
		$userResponse = $row['response'];
		$timestamp = $row['timestamp'];

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
		$response['score'] = getResponseScore($userResponse);
		$response['data'] = $rows;
		$response['comments'] = fetchUserComments($user_email);
		$response['timestamp'] = $timestamp;


	}
	else {
		$response['status'] = false;
		$response['msg'] = "Query Failed!";
	}
	echo json_encode($response, JSON_PRETTY_PRINT);
?>