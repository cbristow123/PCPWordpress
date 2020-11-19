<?php
/*
*Plugin Name: updateCurrentStudentRole
*Plugin URI: No yet got one
*Description: Demonstrates accessing database
*Version: 0.01
*Author: Callum Bristow
*/

add_shortcode('updateCurrentStudentRole', 'updateCurrentStudentRole');

	function updateCurrentStudentRole() 
	{
	global $wpdb;
	global $wp_roles;
	
	$current_user = wp_get_current_user();
	$displayname = $current_user->display_name ;
	
	$roles = $current_user->roles;
	$role = array_shift( $roles );
	
	if ($role == "administrator")
	{
		echo "You are currently logged on as an administrator" ;
		echo "<p> If you were to change this account away from 'admin' you might not be able to ever log back in to the system!" ;
		echo "<p>";
		echo "Please log in using student credentials, and try again" ;
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
		
		$current_user->set_role($newRole);
		
		$roles = $current_user->roles;
		$role = array_shift( $roles );
	}
		
	echo "<p/>";
	echo "Do you want to switch this?" ; 
	
	echo "<form method='post'> ";
	echo "<input type='submit' value='Change role'>" ;
	echo "<input type='hidden' name='hidden' value='any'>" ;
	echo "</form>" ;
	}
?>
