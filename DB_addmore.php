<html>
	<head>
		<title> VC Fund Project </title>
		<link rel="stylesheet" href="./table.css">
		<style>
			body {background-color:lightgray; font-family: Sans-serif; font-size: 16}
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

	// only fire this page when the pic and id are queried
	if (isset($_GET['pic']) && isset($_GET['id'])) {
		$id = $_GET['id'];
		$picSrc  = $_GET['pic'];
		
		if ($picSrc =='')
			$picSrc = './not_found.jpg';
		
		// get more user information using AngelList API
		$get_api = "https://api.angel.co/1/users/" . $id;
		$user_data_orig = file_get_contents($get_api);
		
		//print $user_data_orig."<BR><BR>";
		
		// decode the user's JSON data
		$user_data = json_decode($user_data_orig);	// decode the json string into array
		
		// get main attributes
		$name = $user_data->{'name'};
		unset($user_data->{'id'});
		unset($user_data->{'image'});
		unset($user_data->{'name'});
		
		// output basic user info
		echo "<div class='img'> <img src=" . $picSrc. " class='img-responsive img-circle'". "/> </div> ";
		echo "<b><font size='5'>" . $name . "</font></b><BR><BR>";
		
		// iterate through each object in JSON
		return_json_markup($user_data);
				
		
	}
	else {
		die ("Invalid link!");
	}
	
	function return_json_markup($data) {
	
		foreach($data as $key => $value) {
			// check if $value is an array
			// apply recursion through that array
			if ( is_array($value) && sizeof($value) != 0 ) {
				// classify each category using its key
				$display_key = key_display($key);
				echo "<b><font size='4'>" . $display_key . "</font></b>";
				echo "<BLOCKQUOTE>";
			
				// dissect the array into each element and recurse through them
				foreach($value as $list_elem) {
				
					// erase unnecessary pairs in locations, roles, skills
					if ($key == 'locations' || $key == 'roles' || $key == 'skills' ) {
						foreach ( $list_elem as $k => $v) {
							if ($k == 'id' || $k == 'tag_type' || $k == 'name' )
								unset($list_elem->{$k});
						}
					}
					
					// parse each element in the list of locations, roles, skills
					echo name_with_links($list_elem);
					echo "<BR>";
					
				}
				
				echo "</BLOCKQUOTE>";
			}
			// if nothing is in the $value
			else if (!$value) {
				// ignore that attribute
			}
			// otherwise, print them out
			else if ($value == 'True'){
				$display_key = key_display($key);
				echo "<b><font size='4'>" . $display_key . ": </font></b> YES";
			}
			else if ( preg_match('/http.*/', $value ) ) {
				$display_key = key_display($key);
				echo "<a href=". $value .">". $display_key ."</a><BR>";
			}			
			else {
				$display_key = key_display($key);
				echo "<b><font size='4'>" . $display_key. ": </font></b>";
				
				if ($key == 'what_i_do' || $key == 'criteria' || $key == 'what_ive_built'){
					echo "<BLOCKQUOTE>";
					echo $value . "<BR>";
					echo "</BLOCKQUOTE>";
				}
				else
					echo $value . "<BR>";
				
				
			}
		}
		
		return;
	}
	
	function key_display($key) {
		if ($key == "bio")
			$key = "About";
		else if ($key == "follower_count")
			$key = "Followers";
		else if ($key == "angellist_url")
			$key = "AngelList Info";
		else if ($key == "online_bio_url")
			$key = "Online Bio";
		else if ($key == "twitter_url")
			$key = "Twitter";
		else if ($key == "facebook_url")
			$key = "Facebook";
		else if ($key == "linkedin_url")
			$key = "LinkedIn";
		else if ($key == "what_i_do")
			$key = "What I Do";
		else if ($key == "what_ive_built")
			$key = "What I've Built";
		else if ($key == "locations")
			$key = "Locations";
		else if ($key == "roles")
			$key = "Roles";
		else if ($key == "skills")
			$key = "Skills";
		else if ($key == "investor")
			$key = "Investor";
		else if ($key == "criteria")
			$key = "Criteria";
		
		return $key;
		
	}	
	
	function name_with_links($list) {
	
		$return_field = "<a href=". $list->{'angellist_url'} ." >". $list->{'display_name'};
		
		if ( isset( $list->{'level'} ) )
		{
			$return_field .= " (level ". $list->{'level'} . ")";
		}
		$return_field .= "</a>";
		
		return $return_field;
	}
	
?>
	
	
</body>
</html>