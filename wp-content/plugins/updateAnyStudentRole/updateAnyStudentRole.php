<?php
/*
*Plugin Name: updateAnyStudentRole
*Plugin URI: No yet got one
*Description: Demonstrates accessing database
*Version: 0.01
*Author: Callum Bristow
*/

add_shortcode('updateAnyStudentRole', 'updateAnyStudentRole');

	function updateAnyStudentRole() 
	{
	global $wpdb;
	global $wp_roles;
	
	$current_user = wp_get_current_user();
	$displayname = $current_user->display_name ;
	
	$roles = $current_user->roles;
	$role = array_shift( $roles );
	
	if (!$role == "administrator")
	{
		echo "You are currently not logged on as an administrator" ;
		echo "<p> Please log in using admin credentials, and try again" ;
		echo "<p>";
		echo "Thanks";
		return	;
	}
	echo "$displayname, you are currently registered as $role" ;
	
	if (!empty($_post))
	{
		// implement switch
		if ($role == "unplaced_student")
			{$newRole = "placed_student";}
		else
			{$newRole = "unplaced_student" ;} ;
		
		//$current_user->set_role($newRole);
		
		//$roles = $current_user->roles;
		//$role = array_shift( $roles );
	}
		
	echo "<p/>";
	echo "Do you want to switch this?" ; 
	
	echo "<form method='post'> ";
	echo "Enter a user_id <input type='text' 
	name ='user_id'
	value='", $_POST['userid'] ."'>";
	echo "<input type='submit' value='Change role'>";
	echo "</form>";
	echo "<input type='hidden' name='hidden' value='any'>" ;
	echo "</form>" ;
	}
?>
