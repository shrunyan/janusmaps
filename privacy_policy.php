<?php 
session_start();

require_once('objects/init.php');
$init = new init();
$init->init();

?>
<!-- Content loaded through AJAX -->		
<div id="load_content">   
	<div id="privacy-policy-container">
        <h3>janusmaps - Privacy Policy:</h3>
		<p>We store all the information you enter in order to provide the services of janusmaps.com.</p>
		<p>This privacy policy may change anytime without notification.</p>
    </div>
</div>