<?php
session_start();

require_once('../objects/init.php');
$init = new init();
$init->init();

if(!empty($_POST))
{	
	$listId = $_POST['id'];
	$listTitle = $_POST['title'];
	$listContent = $_POST['list'];

	if(!empty($listId))
	{
		if(!empty($_SESSION['user_id']))
		{
			$qry = "UPDATE lists SET 
					list_content = '$listContent'
					WHERE id = '$listId'
			";
			mysql_query($qry) or die(mysql_error());
			
			echo $listTitle.' saved';
		}
		else {
			echo 'You must be loged in to save a list';
		}
	} else {
		echo 'No list created';
	}
} else {
	echo "Create a list first";
}
