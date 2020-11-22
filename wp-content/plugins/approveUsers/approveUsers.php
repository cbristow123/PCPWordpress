<?php
/*
*Plugin Name: approveUsers
*Plugin URL: N/A
*Description: Allows Placement Admins and Admins to approve and/or deny users from a specific wordpress page
*Version: 0.000000001
*Author: Callum South
*/

add_shortcode('approveUsers','approveUsers');

function approveUsers() {
	global $wpdb;
	global $wp_roles;
	global $ultimatemember;

	$current_user = wp_get_current_user();
	$displayname = $current_user->display_name ;

	$roles = $current_user->roles;
	$role = array_shift( $roles );

	if (!empty($_POST))
	{
		$user_id = $_POST['user_id'];
	/*	$sql = "select display_name, user_id, meta_key, meta_value from wp_users, wp_usermeta where meta_key = 'wp_capabilities' and wp_users.ID = wp_usermeta.user_id and wp_users.ID = $user_id" ;

		$results = $wpdb->get_row ($sql) ;
		$arr = unserialize($results->meta_value) ;
		$role = array_keys($arr)[0] ;

		if ($role == "unplaced_student")
			{$newRole = "placed_student";}
		else
			{$newRole = "unplaced_student";};
		*/

		if ($_POST['action'] == 'Approve')
		{
			approve_user($user_id); 
		//	um_fetch_user($user_id);
 		//	$ultimatemember->user->approve();
			$newRole = "student";
		}
	
		else if ($_POST['action'] == 'Deny')
		{
		//	deny_user($user_id);
			update_deny_status($user_id);
		}

		$serialised = serialize( array( "$newRole" => true ) ) ;
		$sql = "update wp_usermeta set meta_value = '" . $serialised . "'where meta_key = 'wp_capabilities' and user_id = " . $user_id ;
		$results = $wpdb->query($sql) ;
	}

	if (!$role == "administrator" && !$role == "placement_administrator")
	{
		echo "You are not currently logged on as an administrator" ;
		echo " <p> To use this function please log in using admin credentials, and try again" ;
		echo "<p>" ;
		echo "Thanks" ;
		return ;
	}

	$results = $wpdb->get_results("Select user_id, display_name, user_email, meta_key, meta_value from wp_users, wp_usermeta where wp_users.id = wp_usermeta.user_id and meta_key = 'account_status' ");

	echo "<table>" ;
	echo "<tr>" ;
	echo "<td>User ID</td>" ;
	echo "<td>Name</td>" ;
	echo "<td>Email</td>";
	echo "<td>Account Status</td>" ;
	echo "</tr>" ;

	foreach ($results as $record )
	{
		echo "<tr>";
		echo "<td>";
		echo $record->user_id ;
		echo "</td>";
		echo "<td>";
		echo $record->display_name ;
		echo "<td>";
		echo $record->user_email ;
		echo "<td>";
		//$arr = unserialize($record->meta_value) ;
		//echo array_keys($arr)[0] ;
		echo $record->meta_value ;
		echo "</td>";
		echo "</tr>" ;
	} ;
	echo "</table>" ;

	echo "<form method='post'> ";
	echo "Enter a User ID <input type='text' name='user_id' value='". $_POST['user_id'] ."'>" ;
	echo "<input type='submit' name='action' value='Approve'>" ;
	echo "<input type='submit' name='action' value='Deny'>" ;
	echo "</form?" ;
}





 function approve_user( $user_id )
    {
        $user = new WP_User( $user_id );
  /*      wp_cache_delete( $user->ID, 'users' );
        wp_cache_delete( $user->data->user_login, 'userlogins' );
        // send email to user telling of approval
        $user_login = stripslashes( $user->data->user_login );
        $user_email = stripslashes( $user->data->user_email );
        // format the message
        $message = nua_default_approve_user_message();
        $message = nua_do_email_tags( $message, array(
            'context'    => 'approve_user',
            'user'       => $user,
            'user_login' => $user_login,
            'user_email' => $user_email,
        ) );
        $message = apply_filters( 'new_user_approve_approve_user_message', $message, $user );
        $subject = sprintf( __( '[%s] Registration Approved', 'new-user-approve' ), get_option( 'blogname' ) );
        $subject = apply_filters( 'new_user_approve_approve_user_subject', $subject );
        // send the mail
        wp_mail(
            $user_email,
            $subject,
            $message,
 //           $this->email_message_headers()
        );
   */     // change usermeta tag in database to approved
        update_user_meta( $user->ID, 'account_status', 'approved' );
        do_action( 'new_user_approve_user_approved', $user );
    }






	 function deny_user( $user_id )
    {
        $user = new WP_User( $user_id );
        // send email to user telling of denial
        $user_email = stripslashes( $user->data->user_email );
        // format the message
        $message = nua_default_deny_user_message();
        $message = nua_do_email_tags( $message, array(
            'context' => 'deny_user',
        ) );
        $message = apply_filters( 'new_user_approve_deny_user_message', $message, $user );
        $subject = sprintf( __( '[%s] Registration Denied', 'new-user-approve' ), get_option( 'blogname' ) );
        $subject = apply_filters( 'new_user_approve_deny_user_subject', $subject );
        // send the mail
        wp_mail(
            $user_email,
            $subject,
            $message,
        //    $this->email_message_headers()
        );
    }
    
    /**
     * Update user status when denying user.
     *
     * @uses new_user_approve_deny_user
     */
   	 function update_deny_status( $user_id )
    {
        $user = new WP_User( $user_id );
        // change usermeta tag in database to denied
        update_user_meta( $user->ID, 'account_status', 'rejected' );
        do_action( 'new_user_approve_user_denied', $user );
    }











?>



