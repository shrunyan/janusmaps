<?php
session_start();

require_once('../objects/init.php');
$init = new init();
$init->init();


if(!empty($_GET))
{
	$list = $_GET['id'];
	$user = $GLOBALS['user']->get_user_id();
	
	$qry = "DELETE FROM lists WHERE id = '$_GET[id]'";
	mysql_query($qry) or die(mysql_error());
	
	//header('location:../index.php');            
    $qry = "SELECT * FROM lists WHERE user_id = '$user'";
            
    $results = mysql_query($qry) or die(mysql_error());
            
    while($rec = mysql_fetch_array($results))
       {
         echo '
           <li>
		     <span class="trip-name"><a href="JavaScript://">'.$rec['list_title'].'</a></span>
		     <span class="delete-trip"><a href="JavaScript://">X</a></span>
		     <span class="delete-confirm"><a href="functions/delete_list.php?id='.$rec['id'].'">Are you sure?</a></span>
		  </li>
         ';
        }
} else {
	echo 'We apologize but we ran into an error.';
}