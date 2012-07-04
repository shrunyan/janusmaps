<?php
session_start();

require_once('objects/init.php');
$init = new init();
$init->init();

?>

<?php include('snippets/header.php'); ?>
<!-- **** MAIN **** -->
<div id="main">
<?php include('snippets/sidebar.php'); ?>
		
		<div id="content">
			<div id="load_content">
			    <h2>Sorry but your access level is to low :(</h2>
				<h3><a href="login.php">Try loging in!</a></h3>
		    </div>
	    </div>
	            
</div><!-- close main -->
<?php include('snippets/footer.php'); ?>