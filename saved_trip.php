<?php
session_start();

require_once('objects/init.php');
$init = new init();
$init->init();

?>
<!-- Content loaded through AJAX -->	
<div id="load_content">
    <div id="saved-trips">
        <h3>Saved Trips:</h3>
        <ul id="list-saved-trips">
            <!-- SAVED TRIPS WILL LOAD HERE -->
            <?php
            	if(!empty($_SESSION['user_id'])){ 
	            	$user = $GLOBALS['user']->get_user_id();	
	            
	            	$qry = "SELECT * FROM lists WHERE user_id = '$user'";
	            		
	            	$results = mysql_query($qry) or die(mysql_error());
	            	if(!empty($results))
	            	{
		            	while($rec = mysql_fetch_array($results))
		            	{
		            		echo '
			            		<li>
					            	<span class="trip-name"><a id="trip-'.$rec['id'].'" href="JavaScript://">'.$rec['list_title'].'</a></span>
					                <span class="delete-trip"><a href="JavaScript://">X</a></span>
					                <span class="delete-confirm"><a href="functions/delete_list.php?id='.$rec['id'].'">Are you sure?</a></span>
					            </li>
		            		';
		       			
		            	}
	            	} else if(empty($results)){
	            		echo '<p>You have no lists. Create a new list and get started mapping out your trip.</p>';
	            	}
            	} else {
            		echo '<p>You must <a href="signup.php" class="ajaxtrigger">signup</a> or <a href="login.php" class="ajaxtrigger">login</a> first in order to save a list</p>';
            	}
            ?>
        </ul>
    </div>
</div>