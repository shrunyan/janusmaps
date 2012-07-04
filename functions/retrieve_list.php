<?php
session_start();

require_once('../objects/init.php');
$init = new init();
$init->init();

if(!empty($_REQUEST))
{	
	$listId = $_REQUEST['id'];
	
	if(!empty($listId))
	{
		if(!empty($_SESSION['user_id']))
		{
			$qry = "SELECT * FROM lists WHERE
				 	id = '$listId'
			";
			$result = mysql_query($qry) or die(mysql_error());
			$rec = mysql_fetch_array($result);			
			$jsonString = json_encode($rec);
			/*
			 * FUCK ME!!!!  Finally got this.
			 * So apparently when you use json_encode and it adds all these \
			 * they are to prevent TINVALID. It has something to do with unicode and converting to strings
			 * I guess it's better to convert to base64... wtf ever that is. 
			 * Anyways. I think this all has something to do with blank characters and makeing them legal.
			 */
			//echo stripslashes($jsonString); <- this was why my JSON wasn't working
			echo $jsonString;
		}
		else {
			echo 'You don\'t appear to be logged in';
		}
	} else {
		echo 'Empty List';
	}
} else {
	echo "Empty Post";
}
