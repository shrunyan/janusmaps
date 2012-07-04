<?php
if(!empty($_POST)){
	
	session_start();

	//initalization
	require_once('../objects/init.php');
	$init = new init();
	$init->init();
	
	//log user in
	require_once('../objects/user.php');
	$user = new user();
	
	if($_POST['login_form'] == 'login_form')
	{
		$error = $user->login($_POST);		
		if(empty($error)){
			echo 'success';
		} else if (!empty($error)) {
			$error['form'] = 'login';
			$json = json_encode($error);
			echo $json;
		} else {
			echo 'error';
		}
		
	} else if ($_POST['signup_form'] == 'signup_form')
	{
		$error = $user->sign_up($_POST);		
		if(empty($error)){
			echo 'success';
		} else if (!empty($error)) {
			$error['form'] = 'signup';
			$json = json_encode($error);
			echo $json;
		} else {
			echo 'error';
		}
		
	} else if ($_POST['contact_form'] == 'contact_form')
	{
		$error = array();
		//Error checking
		if(empty($_POST['name'])){
			$error['name'] = 'Enter your name';
		}
		if(empty($_POST['email'])){
			$error['email'] = 'Enter a valid email';
		}
		if(empty($_POST['contact_message'])){
			$error['contact_message'] = 'Enter your message';
		}		
		//send email message
		if(empty($error)){
			$title = 'janusmaps - contact form';
			$email = 'shrunyan@gmail.com';
			$body = 
			'From: '.$_POST['name']."\r\n".
			'Email: '.$_POST['email']."\r\n".
			'Message: '.$_POST['contact_message'];
			
			$headers = 'From: contact@janusmaps.com'."\r\n".
						'Reply-To: contact@janusmaps.com'."\r\n";
						'X-Mailer: PHP/'.phpversion();
			
			mail($email, $title, $body, $headers);
			echo 'success';
			
		} else if (!empty($error)) {
			$error['form'] = 'contact';
			$json = json_encode($error);
			echo $json;	
		} else {
			echo 'error';
		}		
	}
} else {
	
	echo 'Form failed';

}

?>