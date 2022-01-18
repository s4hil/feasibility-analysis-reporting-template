<!DOCTYPE html>
<html>
<head>
	<title>Export Data</title>
</head>
<body>
<?php
	if (isset($_GET['name']) && ctype_alpha($_GET['name'])) {

		$name = "_" . $_GET['name'];


		class DB extends sqlite3
		{
			function __construct()
			{

				$this->open("../assets/db/the_db.sqlite");
			}
		}
		
		$db = new DB();

		
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



		$sql = "SELECT * FROM $name";
		$res = $db->query($sql);

		if ($name == "_submissions") {
			?>
				<table id="exportTable">
					<thead>
						<tr>
							<th>Submission Id</th>
							<th>User Name</th>
							<th>Time Stamp</th>
							<th>Response</th>
						</tr>
					</thead>
					<tbody>
						<?php
							while ($row = $res->fetchArray(SQLITE3_ASSOC)) {
								?>
								<tr>
									<td><?php echo $row['submission_id']; ?></td>
									<td><?php echo getUserNameById($row['user_id']); ?></td>
									<td><?php echo $row['timestamp']; ?></td>
									<td><?php echo $row['response']; ?></td>
								</tr>
								<?php
							}
						?>
					</tbody>
				</table>
			<?php
		}
		elseif ($name == "_users") {
			?>
				<table id="exportTable">
					<thead>
						<tr>
							<th>User Id</th>
							<th>Name</th>
							<th>Email</th>
							<th>Country</th>
						</tr>
					</thead>
					<tbody>
						<?php
							while ($row = $res->fetchArray(SQLITE3_ASSOC)) {
								?>
								<tr>
									<td><?php echo $row['user_id']; ?></td>
									<td><?php echo $row['name']; ?></td>
									<td><?php echo $row['email']; ?></td>
									<td><?php echo $row['country']; ?></td>
								</tr>
								<?php
							}
						?>
					</tbody>
				</table>
			<?php
		}
		elseif($name == "_questions"){
			?>
				<table id="exportTable">
					<thead>
						<tr>
							<th>S.no</th>
							<th>Q Id</th>
							<th>Question</th>
							<th>Step Id</th>
						</tr>
					</thead>
					<tbody>
						<?php
						$count = 0;
							while ($row = $res->fetchArray(SQLITE3_ASSOC)) {
								$count++;
								?>
								<tr>
									<td><?php echo $count; ?></td>
									<td><?php echo $row['q_id']; ?></td>
									<td><?php echo $row['question']; ?></td>
									<td><?php echo $row['step_id']; ?></td>
								</tr>
								<?php
							}
						?>
					</tbody>
				</table>
			<?php
		}
	}
	else {
		echo "Invalid Parameters";
	}
?>

<script src="../assets/js/jquery.min.js"></script>
	<script src="../assets/js/jquery.table2excel.min.js"></script>
	<script>
		let now = new Date();
		let day = now.getDate();
		let month = now.getMonth()+1;
		let year = now.getFullYear();

		let today = day+"_"+month+"_"+year;
		
		// console.log();
		$("#exportTable").table2excel({
			filename: "fart_"+today+".xls"
		});
	</script>
</body>
</html>