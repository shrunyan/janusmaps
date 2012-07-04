<?php
session_start();

require_once('objects/init.php');
$init = new init();
$init->init();

?>
<!-- Content loaded through AJAX -->			            
	<div id="load_content" >
        <h3>Your Account Settings:</h3>
            <form action="functions/edit_account.php" method="post" id="account-form">
            
            <fieldset>
            	<label for="username" id="username-label">Name: 
            		<span><?php echo $GLOBALS['user']->get_username(); ?></span>
            	</label>
            		<!-- DON'T NEED
            		<span class="edit-user">edit</span></label>
            	<span class="error"><?php echo $error['new_username']; ?></span>
                    <input type="text" id="username" name="new_username" />
                     -->
                    
                    <label for="useremail" id="useremail-label">Email: 
                    <span><?php echo $GLOBALS['user']->get_email(); ?></span>
                    <span class="edit-user">edit</span></label>
                    <span class="error"><?php echo $error['new_useremail']; ?></span>
                    <input type="text" id="useremail" name="new_useremail" />
            </fieldset>
            
            <fieldset id="change-password">
            	<h4>Change Your Password:</h4>
            	<span class="error"><?php echo $error['new_userpassword']; ?></span>
                    <label for="userpassword">Enter your new password</label>
                    <input type="text" id="userpassword" name="new_userpassword" />
                    <label for="re-userpassword">Re-enter your new password</label>
                    <input type="text" id="re-userpassword" name="new_re_userpassword" />
            </fieldset>
                        
                <input type="submit" value="Save Changes" class="btn" />
                
            </form>
    </div>