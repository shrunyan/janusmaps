<?php

session_start();

require_once('objects/init.php');
$init = new init();
$init->init();

if(!empty($_SESSION['user_id'])){//if user is logged in		
	echo "
			<div id='sidebar'>
				<div id='places-list-con'>
					<h2 id='list-title'><span></span><a class='delete' href='JavaScript://'>X</a></h2>
	                <ul id='places-list'></ul>
                </div>
                <ul id='list-instructions'>
                	<li>Search for a place and add it to your trip</li>
					<li>Places added will appear here</li>
					<li>Save your trip and come back to it later</li>
                </ul>
                <div id='homepage-list' class='homepage'>
                	<h3 id='user'>".$GLOBALS['user']->get_username()."</h3>
                    <a href='new_trip.php' class='btn ajaxtrigger' id='intro-new'>New Trip</a>
                    <a href='JavaScript://' class='btn' id='intro-last'>Last Trip</a>
                    <a href='saved_trip.php' class='btn ajaxtrigger' id='intro-saved'>Saved Trips</a>
                    <a href='account.php' class='btn ajaxtrigger' id='account'>My Account</a>
                    <p>Create a new trip and begin adding your destinations!</p>
                </div>
            </div>
    ";

}
else{//else if user not logged in
	echo "
			<div id='sidebar'>
                <div id='places-list-con'>
					<h2 id='list-title'><span></span><a class='delete' href='JavaScript://'>X</a></h2>
	                <ul id='places-list'></ul>
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
            </div>
	";
}
?>
