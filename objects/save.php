<?php

session_start();//allows us to use $_SESSION

$access = 1;

//initalization
require_once('init.php');
$init = new init();
$init->init($access);

$userid = $GLOBALS[user]->get_user_id();
$inputid = $_POST['id'];
$inputvalue = $_POST['value'];

if(!empty($_POST)){
	
if($inputid == 'profilename' ){
		$qry = "UPDATE users SET 
				username = '$inputvalue'
		 		WHERE id = '$userid' ";
		mysql_query($qry) or die(mysql_error());
	}
	
if($inputid == 'profileemail' ){
		$qry = "UPDATE users SET 
				email = '$inputvalue'
		 		WHERE id = '$userid' ";
		mysql_query($qry) or die(mysql_error());
	}
	
if($inputid == 'profilepassword' ){
		$qry = "UPDATE users SET 
				password = '$inputvalue'
		 		WHERE id = '$userid' ";
		mysql_query($qry) or die(mysql_error());
	}
if($inputid == 'profileage' ){
		$qry = "UPDATE users SET 
				age = '$inputvalue'
		 		WHERE id = '$userid' ";
		mysql_query($qry) or die(mysql_error());
	}
if($inputid == 'profileheight' ){
		$qry = "UPDATE users SET 
				height = '$inputvalue'
		 		WHERE id = '$userid' ";
		mysql_query($qry) or die(mysql_error());
	}
if($inputid == 'profilesex' ){
		$qry = "UPDATE users SET 
				sex = '$inputvalue'
		 		WHERE id = '$userid' ";
		mysql_query($qry) or die(mysql_error());
	}
if($inputid == 'profileweight' ){
		$qry = "INSERT INTO weight SET 
				user_id = '$userid',
				weight = '$inputvalue'
		 		";
		mysql_query($qry) or die(mysql_error());
	}
		
	print_r($inputvalue);
}
	

