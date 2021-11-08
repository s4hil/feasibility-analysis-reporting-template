<?php
	class DB extends sqlite3
	{
		function __construct()
		{

			$this->open("../assets/db/the_db.sqlite");
		}
	}
	
	$db = new DB();

?>

<!DOCTYPE html>
<html>
<head>
	<title>Export Data</title>
</head>
<body>
	<table border="1" cellspacing="0" style="width: 100%;" id="mainTable">
		<thead>
			<tr>
				<th>Submission ID</th>
				<th>User ID</th>
				<th>Response</th>
				<th>TimeStamp</th>
			</tr>
		</thead>
		<tbody>
			<?php
				$res = $db->query("SELECT * FROM `_submissions`");
				while ($row = $res->fetchArray(SQLITE3_ASSOC)) {
					?>
					<tr>
						<td><?php echo $row['submission_id']; ?></td>
						<td><?php echo $row['user_id']; ?></td>
						<td><?php echo $row['response']; ?></td>
						<td><?php echo $row['timestamp']; ?></td>
					</tr>
					<?php
				}
			?>
		</tbody>
	</table>
	<script src="../assets/js/jquery.min.js"></script>
	<script src="../assets/js/jquery.table2excel.min.js"></script>
	<script>
		let now = new Date();
		let day = now.getDate();
		let month = now.getMonth()+1;
		let year = now.getFullYear();

		let today = day+"_"+month+"_"+year;
		
		// console.log();
		$("#mainTable").table2excel({
			filename: "fart_"+today+".xls"
		});
	</script>
</body>
</html>