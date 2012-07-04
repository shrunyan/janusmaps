<?php
if(!empty($_POST)){
	
	$error = array();

	if(empty($_POST['name'])){
		$error['name'] = 'enter your name';
	}
	if(empty($_POST['email'])){
		$error['email'] = 'enter a valid email';
	}
	if(empty($_POST['contact-message'])){
		$error['contact-message'] = 'enter your message';
	}
	
	
	//send email message
	if(empty($error)){
		
		$title = 'janusmaps - contact form';
		$email = 'shrunyan@gmail.com';
		$body = $_POST['contact-message'];
		
		$headers = 'From: contact@uyeia.com'."\r\n".
					'Reply-To: contact@uyeia.com'."\r\n";
					'X-Mailer: PHP/'.phpversion();
		
		mail($email, $title, $body, $headers);
				
		header('location:index.php');
		
	}
	
	header('location:../index.php');
};



?>