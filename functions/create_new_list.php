<?php
session_start();

require_once('../objects/init.php');
$init = new init();
$init->init();

/*
 * Check if the form was empty
 */
if(!empty($_REQUEST))
{
	$title = $_REQUEST['list_name'];
	$userid = $GLOBALS['user']->get_user_id();
	$username = $GLOBALS['user']->get_username();
	
	/* Check if the user is logged in */		
	if(!empty($userid)){		
		$qry = "INSERT INTO lists SET 
				user_id = '$userid',
				list_title = '$title',
				list_content = ''
		";
		mysql_query($qry) or die(mysql_error());
		
		$listid = mysql_insert_id();
		
		echo "
					<div id='places-list-con'>
						<h2 id='list-title'><span>".$title."</span><a class='delete' href='JavaScript://'>X</a></h2>
		                <ul id='places-list' class='list-".$listid."'></ul>
	                </div>
	                <ul id='list-instructions'>
	                	<li>Search for a place and add it to your trip</li>
						<li>Places added will appear here</li>
						<li>Save your trip and come back to it later</li>
	                </ul>
	                <div id='homepage-list' class='homepage' style='display: none;'>
	                	<h3 id='user'>".$username."</h3>
	                    <a href='new_trip.php' class='btn ajaxtrigger' id='intro-new'>New Trip</a>
	                    <a href='JavaScript://' class='btn' id='intro-last'>Last Trip</a>
	                    <a href='saved_trip.php' class='btn ajaxtrigger' id='intro-saved'>Saved Trips</a>
	                    <a href='account.php' class='btn ajaxtrigger' id='account'>My Account</a>
	                    <p>Create a new trip and begin adding your destinations!</p>
	                </div>
	    ";
	} else {
		echo "
					<div id='places-list-con'>
						<h2 id='list-title'><span>".$title."</span><a class='delete' href='JavaScript://'>X</a></h2>
		                <ul id='places-list' class='list-true'></ul>
	                </div>
	                <ul id='list-instructions'>
	                	<li>Search for a place and add it to your trip</li>
						<li>Places added will appear here</li>
						<li>Save your trip and come back to it later</li>
	                </ul>
	                <div id='homepage-list'>
	                	<p>Search and plan your dream trip.</p>
	                    <h4>For Free!</h4>
	                    <p>Go ahead and try it out. If you like it...</p>
	                    <a href='signup.php' class='btn ajaxtrigger log-opt-signup'>Sign Up</a>
	                </div>
	    ";
	}
} else {
	echo 'Not the right type of request';
}