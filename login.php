<?php
session_start();//allows us to use $_SESSION

//initalization
require_once('objects/init.php');
$init = new init();
$init->init();

//log user in
require_once('objects/user.php');
$user = new user();
$error = $user->login($_POST);

?>
<!-- Content loaded through AJAX -->		      
<div id="load_content">    
	<div id="login-form">
        <h3>Login:</h3>
        <form class="ajaxForm" action="index.php" method="post">
        
            <label for="login_email">Email address:</label>
            <span class="error" id="login_error"><?php echo $error['login']; ?></span>
            <span class="error" id="login_email_error"><?php echo $error['login_email']; ?></span>
        	<input type="text" id="login_email" name="login_email" autofocus />
        	
            <label for="login_password">Password:</label>
            <span class="error" id="login_password_error"><?php echo $error['login_password']; ?></span>
        	<input type="password" id="login_password" name="login_password" />
        	
            <input type="checkbox" name="user_remeber" id="user_remember" value="1" />
			<label for="user_remember">Remember me next time</label>
			
			<input type="hidden" value="login_form" name="login_form" />
            <input type="submit" class="btn" value="Login" />
        </form>
        <div id="log-opt">
        	<a href="signup.php" class="log-opt-signup ajaxtrigger">Sign Up</a>
            <!-- <a href="forgot_pass.php" class="log-opt-pass ajaxtrigger">Lost Password</a> -->
        </div>
    </div>
</div>