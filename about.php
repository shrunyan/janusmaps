<?php
session_start();

require_once('objects/init.php');
$init = new init();
$init->init();

?>
<!-- Content loaded through AJAX -->
<div id="load_content">    
	<div id="about-container">
		<h3>About janusmaps.com:</h3>
		<p>This site has been built and is maintained by <br /><a href="http://www.stuartrunyan.com">Stuart Runyan</a></p>
		<p>It's built to help people plan out their trips in a more direct and intuitive manner. Currently it can map and plot your desired locations. I plan to add more features in the future.</p>
	</div>
</div>
