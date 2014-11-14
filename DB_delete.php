<html>
	<head>
		<title> VC Fund Project </title>
		<link rel="stylesheet" href="./table.css">
		<style>
			body {background-color:lightgray; font-family: Sans-serif}
		</style>
	</head>
	
<body>
	<h1>AngelList Search Buttons</h1>
	
	By Steve Oh <br><br>
	
	<h4>Select the buttons below in order to see the list of UCLA alumni accessible to members of the UCLA VC Fund. </h4>
	
	<div id = "buttons">
		<input id = "DB_load" type="button" value="Load AngelList" onclick="location='DB_load.php'" />
		<input id = "DB_delete" type="button" value="Delete AngelList" onclick="location='DB_delete.php'" />
		<input id = "DB_showAll" type="button" value="Show ALL AngelList" onclick="location='DB_showAll.php'" />
	</div>
	
	<br><br>

<?php
	// define servername and user/password variables
	$servername = "localhost";
	$username = "root";
	$password = "1234";
	
	// Create connection
	$db_connection = mysql_connect($servername, $username, $password);
	
	// Check connection
	if ( !$db_connection ) {
		die ("Error connecting to MySQL: ".mysql_error());
	}
	
	$new_db = 'UCFund';
	
	// Need to delete the database
	$sql = "DROP DATABASE " . $new_db;
	if ( !mysql_query($sql, $db_connection) ) {
		die ("Failed to delete ". $new_db ." database! <br> " . mysql_error(). "<br>");
	}
	
	// Close the database connection
	mysql_close($db_connection);

	// if no error has occurred, print out success message
	print "Deleting UCLA-associated Alumni has been successful!";
	
?>
	
	
</body>
</html>