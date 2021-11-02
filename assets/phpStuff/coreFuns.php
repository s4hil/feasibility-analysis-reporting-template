<?php
	header("Access-Control-Allow-Origin");
	header("Access-Control-Allowed-Methods: POST, GET");

	// DB connection 
	require_once("db_conn.php");

	// Sanitize
	function clean($str)
    {
        return preg_replace('/[^\.\@\,\-\_A-Za-z0-9 ]/', '', $str);
    }

    // Find step name by id
    function fetchStepNameById($id)
    {
    	global $db;
    	$sql = "SELECT * FROM `_steps` WHERE `step_id` = '$id' LIMIT 1";
    	$res = $db->query($sql);
    	if ($res) {
    	 	$name = $res->fetchArray(SQLITE3_ASSOC)['name'];
    	 	return $name;
    	}
    	else {
    		return false;
    	} 
    }

    // fetch total number of steps
   	function fetchTotalSteps()
   	{
   		$count = 0;
   		$sql = "SELECT * FROM `_steps`";
   		global $db;
   		$res = $db->query($sql);
   		if ($res) {
   			while($row = $res->fetchArray()) {
   				$count++;
   			}
   		}
   		else {
   			$count = 0;
   		}
   		return $count;
   	}
?>	