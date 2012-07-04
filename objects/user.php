<?php
class user 
{
	
	private $info;

	public function __construct($id = 0)
	{
		if(!empty($id)) //if user id was passed in
		{
			$qry = "SELECT * FROM users WHERE id ='$id'";
			$result = mysql_query($qry) or die(mysql_error());
			$record = mysql_fetch_array($result);
			
			if(!empty($record))
			{
				$this->info = $record;
			}
		}
	}
	
	public function login($data)
	{
		if(!empty($data)){//check whether the form has been posted
	
			//form validation
			$error = array();//initialize the error variable
			$showError = false;
			
			if(empty($data['login_email'])){//if no email was entered
				$error['login_email'] = 'Enter your email address';
				$showError = true;
			};
			if(empty($data['login_password'])){
				$error['login_password'] = 'Enter a password';
				$showError = true;
			};
			
			if(empty($error)){//if no errors
				$qry = "SELECT * FROM users 
					WHERE email = '$data[login_email]' &&
					password = '$data[login_password]' ";//building the MySQL select query
						
				$result = mysql_query($qry) or die(mysql_error());//query mysql
				
				$user = mysql_fetch_array($result);
						
				if(empty($user)){//if no matching was found
					$error['login'] = 'Your email or password was incorrect';
					$showError = true;
				}
				else{//if matching was found
					
					$this->set_user_session($user);					
					
					//set cookie
					if($data['user_remember'] == 1)
					{
						$this->set_cookie();
					}
					return;					
					//echo 'success';
					//header('location:index.php');
				}	
			}
			
			return $error;
		}
	}//end login
	
	
	public function sign_up($data)
	{
		//validate form
		if(!empty($data)) //if form has been submitted
		{
			$error = array();
			
			//Email validation
			if(empty($data['signup_email'])){//if no email
				$error['signup_email'] = 'Valid email address required';
			}
			else if(strlen($data['signup_email']) > 100){
				//if email is greater than 100 chars
				$error['signup_email'] = 'Email is to long (100 max)';
			}
			function checkEmail($email) 
			{
			   if(eregi("^[a-zA-Z0-9_]+@[a-zA-Z0-9\-]+\.[a-zA-Z0-9\-\.]+$]", $email)) 
			   {
			      return FALSE;
			   }
			
			   list($Username, $Domain) = split("@",$email);
			
			   if(getmxrr($Domain, $MXHost)) 
			   {
			      return TRUE;
			   }
			}
			
			if(checkEmail($data['signup_email']) == FALSE) 
			{
			   $error['signup_email'] = 'Valid email address required';
			} 
			
			
			//Username validation
			if(empty($data['signup_name'])){
				$error['signup_name'] = 'Enter your name';
			}
			else if(strlen($data['signup_name']) < 3){
				$error['signup_name'] = 'Username is to short (3 min)';
			}
			else if(strlen($data['signup_name']) > 25){
				$error['signup_name'] = 'Username is to long (25 max)';
			}
			
			//Password validation
			if(empty($data['signup_password'])){
				$error['signup_password'] = 'Enter a password';
			}
			else if(strlen($data['signup_password']) < 3){
				$error['signup_password'] = 'Password is to short (3 min)';
			}
			else if(strlen($data['signup_password']) > 25){
				$error['signup_password'] = 'Password is to long (25 max)';
			}
			
			//Repeat password Validation
			if(empty($data['signup_password_repeat'])){ //this works
				$error['signup_password_repeat'] = 'Please repeat your password';
			}
			else if($data['signup_password'] !== $data['signup_password_repeat']){
				$error['signup_password_repeat'] = 'Passwords do not match';
			}
			
			//captcha
			if($_SESSION['c_verify'] != $data['captcha']){
				$error['captcha'] = 'characters do not match';
			}
			
			//form processing
			if(empty($error)){
				
				$qry = "SELECT * FROM users WHERE 
					email = '$data[signup_email]'";
				
				$result = mysql_query($qry) or die(mysql_error());
				$row = mysql_fetch_array($result);
				
				if(!empty($row)){
					$error['signup_email'] = 'This email is already signed up ';
				}
				else {
					$qry = "INSERT INTO users SET 
						email = '$data[signup_email]',
						username = '$data[signup_name]',
						password = '$data[signup_password]' ";
					
					mysql_query($qry) or die(mysql_error());

					//send welcome email
					$this->send_welcome_email($data);
					
					//mysql_insert_id will grab the id assigned to the new user
					$data['id'] = mysql_insert_id();
					
					$this->set_user_session($data);
					return;
					//header('location:index.php');
				}
			}
			
			return $error;
			
		}
	}//end sign_up
	
	
	//sends user a forgot password email
	public function forgot_password($data, &$success) //the & in front of the variable means edit this variable passed in
	{
		if(!empty($data))
		{
			$error = array();
			if(empty($data['email']))
			{
				$error['email'] = 'Enter an email';
			};
			if(empty($error)) //no errors
			{
				$qry = "SELECT * FROM users WHERE email = '$data[email]' ";
				$result = mysql_query($qry) or die(mysql_error());
				
				$record = mysql_fetch_array($result);
				if(empty($record))//no matching email in users table
				{
					$error['email'] = 'this email is not registered - <a href="signup.php">sign up here</a>';	
				}
				else{//is matching email in users table
					//generate code
					$rand = rand(0, 99999);
					$hash = sha1($rand);
					$code = substr($hash, 0, 12);
					
					//store code in DB
					$qry = "INSERT INTO forgot_pass SET 
						user_id = '$record[id]',
						code = '$code' ";
					
					mysql_query($qry) or die(mysql_error());
					
					//send email to user
					$to_email = $data['email'];
					$subject = $record['username'].
						', here is your reset password link';
					$body = 'Click on the link below to reset your password: '."\r\n";
					$body .= 'http://www.dev.uyeia.com/forgot_confirm.php?code='.
						$code.'&email='.$data['email']."\r\n\n";
					$body .= 'Cheers,'."\r\n";
					$body .= 'uyeia';
						
					$headers = 'From: contact@uyeia.com'."\r\n".
								'Reply-To: contact@uyeia.com'."\r\n";
								'X-Mailer: PHP/'.phpversion();
					
					mail($to_email, $subject, $body, $headers);//mail command
					
					$success = "Check you email to complete your password reset.";
					
				}
			}
			
			return $error;
			
		}
	}
	
	
	public function reset_password($data, $rec)
	{
		if(!empty($data))
		{
			//error checking
			$error = array();
			
			//Password validation
			if(empty($data['password'])){
				$error['password'] = 'enter a password';
			}
			else if(strlen($data['password']) < 3){
				$error['password'] = 'password is to short (3 min)';
			}
			else if(strlen($data['password']) > 25){
				$error['password'] = 'password is to long (25 max)';
			}
			else if($data['password'] != $data['r_password']){
				//if email and repeat email are not equal
				$error['r_password'] = 'passwords don\'t match';
			}
			
			if(empty($error)){
				//set password for user
				$qry = "UPDATE users SET password = '$data[password]'
						WHERE email = '$_GET[email]'";
				mysql_query($qry) or die(mysql_error());
				
				//logs in the user
				$this->set_user_session($rec);
				
				//redirects the user to the home page
				header('location:dashboard.php');
			}
			
			return $error;
			
		}
	}
	
	
	//login user
	public function set_user_session($user = null)
	{
		if(!empty($user));
		{
			$this->info = $user;
		}
		
		//set session id
		$_SESSION['user_id'] = $this->info['id'];		
	}
	
	//return username - getter function
	public function get_username()
	{
		return $GLOBALS['filter']->output_str($this->info['username'], 'string');
	}
	//return user email - getter function
	public function get_email()
	{
		return $GLOBALS['filter']->output_str($this->info['email'], 'string');
	}
	//return the access level
	public function get_access()
	{
		return $GLOBALS['filter']->output_str($this->info['access'], 'string');
	}
	//return user id
	public function get_user_id()
	{
		return $GLOBALS['filter']->output_str($this->info['id'], 'string');
	}
	

	private function set_cookie()
	{
		//cookie name
		$name = 'janusmap';
		
		//random cookie value
		$rand = rand(0,99999);
		$hash = sha1($rand);
		$hash = substr($hash, 0, 12);
		$value = $this->info['id'].'_'.$hash;
		
		//experiation - 1 week
		$expire = time() + 7*24*60*60;
		
		//path inside domain
		$path = '/';
		
		//website domain
		$domain = '.janusmaps.com';
						
		setcookie($name, $value, $expire, $path, $domain);
		
		//insert cookie value into DB
		$qry = "INSERT INTO cookies SET 
				user_id = '".$this->info['id']."',
				cookie = '$value'";
		mysql_query($qry) or die(mysql_error());
	}//end set_cookie

	
	
	
	private function send_welcome_email($data)
	{
		//composing and sending welcome email
		$to_email = $data['singup_email'];
		$subject = 'Welcome to janusmaps.com';
		$body = '
			<html>
				<head>
					<title>Welcome to janusmaps</title>
					<style type="text/css">
						body{font:Arial,Helvetica,Verdana;}
						h1 {font: 1px;}
						h2{font: 16px;}
						ul{list-style-type: none;}
					</style>
				</head>
				<body>
					<h1>Welcome '.$data['signup_name'].',</h1>
					<br />
					<p>You have successfully created an account at janusmaps</p>
					<p><strong>Here is your account information:</strong></p>
					<ul>
						<li>Email: '.$data['singup_email'].'</li>
						<li>Username: '.$data['signup_name'].'</li>
						<li>Password: '.$data['signup_password'].'</li>
					</ul>
					
				<hr />
				<p><a href="http://www.janusmap.com" target="_blank">www.janusmap.com</a></p>
				</body>
			</html>
		';
		
		//set email header
		$headers = 'From: contact@janusmap.com'."\r\n".
					'Reply-To: contact@janusmap.com'."\r\n";
					'X-Mailer: PHP/'.phpversion();
		$headers .= 'MIME-Version: 1.0'."\r\n";
		$headers .= 'Content-type: text/html; charset=iso-8859-1'."\r\n";
		
		//mail command
		mail($to_email, $subject, $body, $headers);	
	}//end send_welcome_email

}//end class