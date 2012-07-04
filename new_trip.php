<?php
session_start();

require_once('objects/init.php');
$init = new init();
$init->init();

?>
<!-- Content loaded through AJAX -->		
<div id="load_content">
    <div id="new-trip">
        <h3>New Trip Name:</h3>
        <form id="new-trip-form" action="functions/create_new_list.php" method="post">
        	<input type="text" id="list_name" name="list_name" />
            <input type="submit" class="btn" id="set-name" name="set-name" value="Set Name" />
        </form>
    </div>
</div>