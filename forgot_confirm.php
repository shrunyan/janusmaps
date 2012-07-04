<?php
session_start();

require_once('objects/init.php');
$init = new init();
$init->init();

//check to make sure code matches the DB
//u - references data coming from a particular table
$qry = "select u.* from users u, forgot_pass f where
		u.email = '$_GET[email]' && 
		u.id = f.user_id &&
		f.code = '$_GET[code]'";

$result = mysql_query($qry) or die(mysql_error());
$rec = mysql_fetch_array($result);

if(empty($rec))
{
	$unsuccessful = 'Your forgot password email contained an error. Please resend email, <a href="forgot_pass.php">here</a>';
}

require_once('objects/user.php');
$user = new user();
$error = $user->reset_password($_POST, $rec);

?>

<?php include('snippets/header.php'); ?>
<div id="main">
<?php include('snippets/sidebar.php'); ?>
		
		<div id="content">     
			<div id="forgot_confirm">
		
			<h2>Reset your password</h2>
			
			<p>This will reset your password for your account.</p>
			
			<form method="post" action="forgot_confirm.php?code=<?php 
									echo $_GET['code']; 
								?>&email=<?php 
									echo $_GET['email']; 
								?>">
	
				<label for="password">New Password:</label>
				<input type="password" name="password" id="password" />
				<p class="error"><?php echo $error['password']; ?></p>
			
				<label for="r_password">Repeat new password:</label>
				<input type="password" name="r_password" id="r_password" />
				<p class="error"><?php echo $error['r_password']; ?></p>
				
				<p><?php echo $unsuccessful; ?></p>
				
				<input type="submit" id="submit" value="Submit" />
			
			</form>
		</div>
	    </div>
	            
</div><!-- close main -->		
<?php include('snippets/footer.php'); ?>

