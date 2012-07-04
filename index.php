<?php 
session_start();

//initalization
require_once('objects/init.php');
$init = new init();
$init->init();

//log user in
require_once('objects/user.php');
$user = new user();
$error = array();
if(!empty($_POST['login_form'])){
	$error = $user->login($_POST);
}
if(!empty($_POST['signup_form'])){
	$error = $user->sign_up($_POST);
}

?>

<?php include('snippets/header.php'); ?>
	
	<!-- **** MAIN **** -->
		<div id="main">
			<?php include('snippets/sidebar.php'); ?>
            
			<!-- Google Map -->
			<div id="map">	
				<div id="no-js">
					<noscript><strong>JavaScript must be enabled in order for you to use Google Maps.</strong> 
					  However, it seems JavaScript is either disabled or not supported by your browser. 
					  To view Google Maps, enable JavaScript by changing your browser options, and then 
					  try again.
					</noscript>
				</div>
				<div id="map_canvas" style="height: 100%; width: 100%;"></div>    
			</div>	
            				
		</div><!-- close main -->

<?php include('snippets/footer.php'); ?>