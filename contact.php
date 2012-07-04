<?php
session_start();

require_once('objects/init.php');
$init = new init();
$init->init();

?>
<!-- Content loaded through AJAX -->	
<div id="load_content">   
	<div id="contact-form">
        <h3>Contact Us:</h3>
        <form class="ajaxForm" action="JavaScript://" method="post">
        
        	<label for="name">Full Name:</label>
            <span class="error" id="name_error"><?php echo $error['name']; ?></span>
        	<input type="text" id="name" name="name" />
        	
            <label for="email">Email Address:</label>
            <span class="error" id="email_error"><?php echo $error['email']; ?></span>
        	<input type="text" id="email" name="email" />
        	
            <label for="contact-message">Message:</label>
            <span class="error" id="message_error"><?php echo $error['contact_message']; ?></span>
        	<textarea id="contact-message" name="contact_message"></textarea>
        	
            <input type="submit" class="btn" id="submit" name="submit" value="Submit" />
            <input type="hidden" name="contact_form" value="contact_form" />
        </form>
    </div>
</div>