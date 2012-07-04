<?php
session_start();

require_once('../objects/init.php');
$init = new init();
$init->init();

if(!empty($_SESSION['user_id']))
{
	$userId = $_SESSION['user_id'];
	$qry = "SELECT * FROM lists WHERE
		 	user_id = '$userId' 
		 	ORDER BY saved_time DESC
	";
	$result = mysql_query($qry) or die(mysql_error());
	if(!empty($result))
	{
		$rec = mysql_fetch_array($result);			
		$jsonString = json_encode($rec);
	
		echo $jsonString;	
	} else {
		echo 'You have not created a list yet.';
	}
	
}
else {
	echo 'You must be logged in.';
}