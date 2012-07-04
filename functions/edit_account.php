<?php
session_start();

require_once('../objects/init.php');
$init = new init();
$init->init();


if(!empty($_POST))
{
	$username = $_POST['new_username'];
	$useremail = $_POST['new_useremail'];
	$userpass = $_POST['new_userpassword'];
	$userid = $GLOBALS['user']->get_user_id();
	$error = array();
	
	/* NOT GOING TO ALLOW CHANGING USERNAME
	if(!empty($username))
	{
		$qry = "UPDATE users SET
				username = '$username'
				WHERE id = '$userid'
		";
		mysql_query($qry) or die(mysql_error());
	}
	*/
	
	if(!empty($useremail))
	{
		if(strlen($useremail) > 100){
			//if email is greater than 100 chars
			$error['new_useremail'] = 'Email is to long (100 max)';
		}
		function checkEmail($email) 
			{
			   if(eregi("^[a-zA-Z0-9_]+@[a-zA-Z0-9\-]+\.[a-zA-Z0-9\-\.]+$]", $email)) 
			   {
			      return FALSE;
			   }
			
			   list($Username, $Domain) = split("@",$email);
			
			   if(getmxrr($Domain, $MXHost)) 
			   {
			      return TRUE;
			   }
			}
			
		if(checkEmail($useremail) == FALSE) 
			{
			   $error['new_useremail'] = 'Valid email address required';
			}
		
		
		if(empty($error))
		{
			$qry = "SELECT * FROM users WHERE email = '$useremail'";
			$results = mysql_query($qry) or die(mysql_error());
			$row = mysql_fetch_array($results);
			
			if(!empty($row))
			{
				$error['new_useremail'] = 'This email address is not available';	
			} else 
			{
				$qry = "UPDATE users SET
						email = '$useremail'
						WHERE id = '$userid'
				";
				mysql_query($qry) or die(mysql_error());
			}
		}	
	}
	if(!empty($_POST['new_userpassword']))
	{

		
		if(empty($error))
		{
			$qry = "UPDATE users SET
					password = '$userpass'
					WHERE id = '$userid'
			";
			
			mysql_query($qry) or die(mysql_error());
		}
	}
	header('location:../index.php');
}