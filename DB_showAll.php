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
	
	// Database not selected
	if (!$db_selected) {
		die ("Failed to select the target database; Create the data by clicking on \"Load AngelList\"");
	}
	
	// USE the database ucfund 
	mysql_query("USE ".$new_db, $db_connection);
	
	// Select Table
	$table = 'Alumni';
	
	$result = mysql_query("SELECT * FROM ". $table, $db_connection);
	
	$numRows = mysql_num_rows($result) + 1;		// returns # of rows
	$numCols = mysql_num_fields($result);	// returns # of columns
	
	//Open the table
	echo "<div class='table-responsive'>";
	echo "<table class='table table-striped table-bordered' width='40%'>";
	
	$rowArray;
	for ($row = 0; $row < $numRows; ++$row)
	{
		// only retrieve the row results after the first row table is filled
		if ($row != 0)
			$rowArray = mysql_fetch_row($result);
		
		echo "<tr>";
		
		// get the local variable to store id & picture source
		$id = 0;
		$pic_src;
		
		for ($col = 0; $col < $numCols; ++$col)
		{
			// get the column name and make use of it later
			$attr = mysql_field_name($result, $col);
		
			if ($row == 0)	// fill in the column attributes except the id
			{
				if ($attr != 'id')
					echo "<td><b><center><font size='4'>". $attr . "</font></b><center></td>";
			}
			
			else	// output selected results
			{
				if ($attr == 'pic') {
					// store the current row's pic src
					$pic_src = $rowArray[$col];
					
					// handle null images
					if ( !$pic_src ) {
						echo "<td align='center'> <img src='./not_found.jpg' class='img-responsive img-circle' /> </td>";
					} else {	// normal cases
						echo "<td align='center'> <img src=".$pic_src." class='img-responsive img-circle' /> </td>";
					}
				} else if($attr == 'id'){
					// skip id column, just store the id value
					$id = $rowArray[$col];
				} else if($attr == 'name'){
					echo "<td><a href=./DB_addmore.php?pic=$pic_src&id=$id>" . shorten_string($rowArray[$col]) . "</a></td>";
				} else if($attr == 'url') {	 // profile hyperlink
					echo "<td> <a href=\"".$rowArray[$col]."\"> ".$rowArray[$col]. " </td>";
				} else {
					echo "<td>" . $rowArray[$col] . "</td>";
				}
			}	
		}	// end of one row filling
		echo "</tr>";
	}
	
	// Close the table
	echo "</table>";
	echo "</div>";
	
	// Close the database connection
	mysql_close($db_connection);

	function shorten_string($str) {
		$size = strlen($str);
		$max_size = 60;
		
		if ($size > $max_size)
			$final_string = substr($str, 0, $max_size). "<br>" . shorten_string(substr($str, $max_size));
		else
			$final_string = $str;
		
		return $final_string;
	}
	
?>
	
	
</body>
</html>