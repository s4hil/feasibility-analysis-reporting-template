<?php
  session_start();

	// DB connection 
	require_once("db_conn.php");

	// Sanitize
	function clean($str)
    {
        return preg_replace('/[^\.\@\,\-\_A-Za-z0-9 ]/', '', $str);
    }

    // Find step name by id
    function fetchStepDetailsById($id)
    {
    	global $db;
    	$sql = "SELECT * FROM `_steps` WHERE `step_id` = '$id' LIMIT 1";
    	$res = $db->query($sql);
    	if ($res) {
        $userInfo = $res->fetchArray(SQLITE3_ASSOC);
    	 	return $userInfo;
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

    // Fetching Steps count
    function getQuestionById($id)
    {
        global $db;
        $res = $db->query("SELECT * FROM _questions WHERE `q_id` = '$id'");
        if ($res) {
            $row = $res->fetchArray(SQLITE3_ASSOC);
            return $row;
        }
        else {
            return "Not Found!";
        }
    }
    
    // Fetch user name by id
    function getUserNameById($id)
    {
        global $db;
        $res = $db->query("SELECT * FROM `_users` WHERE `user_id` = '$id'");
        if ($res) {
            return $res->fetchArray(SQLITE3_ASSOC)['name'];
        }
        else {
            return false;
        }
    }

    // fetch user email by id
    function fetchEmailById($id)
    {
      global $db;
      $res = $db->query("SELECT * FROM `_users` WHERE `user_id` = '$id'");
      if ($res) {
        $user = $res->fetchArray(SQLITE3_ASSOC);
        $email = $user['email'];
        return $email;
      }
      else {
        return false;
      }
    }

    // Fetching user comments by user email
    function fetchUserComments($email)
    {
      global $db;
      $data = array();
      $sql = "SELECT * FROM `_comments` WHERE `email` = '$email'";
      $res = $db->query($sql);
      if ($res) {
        while ($row = $res->fetchArray(SQLITE3_ASSOC)) {
          $data[] = $row; 
        }
        return $data;
      }
      else {
        return false;
      }
    }
?>	