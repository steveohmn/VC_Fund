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
		<input id = "DB_addmore" type="button" value="Load MORE AngelList" onclick="location='DB_addmore.php'" />
		<input id = "DB_showAll" type="button" value="Show ALL AngelList" onclick="location='DB_showAll.php'" />
	</div>
	
	<br><br>

<?php
	// define servername and user/password variables
	$servername = "localhost";
	$username = "root";
	$password = "1234";

	// Get AngelList User Information from the web
	$user_data = file_get_contents('https://api.angel.co/1/search?query=ucla&type=User');
	$json = json_decode($user_data);	// decode the json string into array
	
	// Create connection
	$db_connection = mysql_connect($servername, $username, $password);
	
	// Check connection
	if ( !$db_connection ) {
		die ("Error connecting to MySQL: ".mysql_error());
	}
	
	$new_db = 'UCFund';
	$db_selected = mysql_select_db($new_db, $db_connection);
	
	if (!$db_selected) {
		// Need to create the database
		$sql = "CREATE DATABASE " . $new_db;
		if ( !mysql_query($sql, $db_connection) ) {
			echo "Failed to create ". $new_db ." database" .mysql_error(). "<br>";
		}
	}
	
	// USE the database ucfund 
	mysql_query("USE ".$new_db);
	
	// Create Table
	$table = 'Alumni';
	
	mysql_query("CREATE TABLE ". $table .
				" (pic VARCHAR(200), id INT NOT NULL, name VARCHAR(200) NOT NULL,
				   type VARCHAR(10), url VARCHAR(200), PRIMARY KEY(id, name)
				  ) ENGINE=INNODB", $db_connection );
	
	// Insert tuples in JSON object to the Table
	insert_into_table($json, $table, $db_connection);
	
	// Close the database connection
	mysql_close($db_connection);

	// helper functions
	function insert_into_table( $obj, $table, $db_conn ){
		// define tuple variables
		$id = 'id';
		$name = 'name';
		$type = 'type';
		$pic = 'pic';
		$url = 'url';		
		
		$i = 0;
		$total_size = sizeof($obj);	// get the number of users in this json object
		
		while ( $i < $total_size ) {	
			// INSERT each value into the table
			if( !mysql_query("INSERT INTO ".$table.
							 " VALUES(\"".$obj[$i]->{$pic}."\", ". $obj[$i]->{$id}.", \"".$obj[$i]->{$name}."\", \"".$obj[$i]->{$type}."\",
							          \"".$obj[$i]->{$url}."\" )", $db_conn ) )
				die ("Inserting values of the user data into the database failed! <br> Table already has the duplicate information.") ;
			
			$i++;	// next object in the array
		}
	
	}
	
	print "Loading UCLA-associated Alumni has been successful!";

?>
	
	
</body>
</html>