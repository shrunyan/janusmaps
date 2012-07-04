<?php
session_start();

require_once('objects/init.php');
$init = new init();
$init->init();

require_once('objects/user.php');
$user = new user();
$error = $user->forgot_password($_POST, $success);

?>
<!-- Content loaded through AJAX -->
<div id="load_content">   
	<div id="lost-password">
        <h3>Lost Password:</h3>
        <form name="lost-password" action="" method="post">
        	<input type="text" id="reset-password" name="reset-password" />
            <input type="submit" class="btn" value="Submit" />
        </form>
        <div id="log-opt">
        	<a href="login.php" class="log-opt-login ajaxtrigger">Login</a>
            <a href="signup.php" class="log-opt-signup ajaxtrigger">Sign Up</a>
        </div>
    </div>
</div>