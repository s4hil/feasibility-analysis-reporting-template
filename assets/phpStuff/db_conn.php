<?php
	
	/*
		Database Connection via sqlite3 
	*/

	class DB extends sqlite3
	{
		function __construct()
		{

			$this->open("../db/the_db.sqlite");
		}
	}
	
	$db = new DB();
?>