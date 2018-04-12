<?php
// Generating Password
$chars = "abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789!@#$%&*_";
$password = substr( str_shuffle( $chars ), 0, 8 );

// Generating New password as done in above function and Update it in database by below query
$password = md5($password); //Hash Password
$query = mysql_query("UPDATE `users` SET `upass` ='$password' WHERE `uemail` ='$email'");
if($query) {
	$to = $email;
	$subject = 'Your New Password...';
	$message = 'Hello User
	Your new password : '.$password.'
	E-mail: '.$email.'
	Now you can login with this email and password.';
	/* Send the message using mail() function */
	if(mail($to, $subject, $message )){
		echo "New Password has been sent to your mail, Please check your mail and SignIn.";
	}
	$_SESSION['login_user']= $email;//Initializing Session with user email
}
?>

