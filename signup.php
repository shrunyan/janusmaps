<?php
session_start();

require_once('objects/init.php');
$init =new init();
$init->init();

require_once('objects/user.php');
$user = new user();
$error = $user->sign_up($_POST);

?>
<!-- Content loaded through AJAX -->		
<div id="load_content">
	<div id="signup-form">
        <h3>Sign Up:</h3>
        <form class="ajaxForm" action="index.php" method="post">
        
        	<label for="signup_name">Full Name:</label>
        	<span class="error" id="signup_name_error"><?php echo $error['signup_name']; ?></span>
        	<input type="text" id="signup_name" name="signup_name" autofocus />
        	
            <label for="signup_email">Email address:</label>
            <span class="error" id="signup_email_error"><?php echo $error['signup_email']; ?></span>
        	<input type="text" id="signup_email" name="signup_email" />
        	
            <label for="signup_password">Password:</label>
            <span class="error" id="signup_password_error"><?php echo $error['signup_password']; ?></span>
        	<input type="text" id="signup_password" name="signup_password" />
        	
            <label for="signup_password_repeat">Repeat Password:</label>
            <span class="error" id="signup_password_repeat_error"><?php echo $error['signup_password_repeat']; ?></span>
        	<input type="text" id="signup_password_repeat" name="signup_password_repeat" />
        	
            <label for="captcha">Enter the characters below:</label>
            <span class="error" id="captcha_error"><?php echo $error['captcha']; ?></span>
            <img id="captcha-img" src="captcha/captcha.php" alt="Captcha image" />
            <input type="text" id="captcha" name="captcha" />
            
            <input type="hidden" value="signup_form" name="signup_form" />
            <input type="submit" class="btn" value="Sign Up" />
        </form>
        <div id="log-opt">
        	<a href="login.php" class="log-opt-login ajaxtrigger">Login</a>
            <!-- <a href="forgot_pass.php" class="log-opt-pass ajaxtrigger">Lost Password</a> -->
        </div>
    </div>
</div>