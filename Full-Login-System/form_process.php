<?php 

// define variables and set to empty values
$fname_error = $lname_error = $uname_error = $email_error = $upass_error = "";
$fname = $lname = $uname = $uemail = $upass = $success = "";

//form is submitted with POST method
if ($_SERVER["REQUEST_METHOD"] == "POST") {
  if (empty($_POST["fname"])) {
    $fname_error = "Enter Your First Name";
  } else {
    $fname = test_input($_POST["fname"]);
    // check if name only contains letters and whitespace
    if (!preg_match("/^[a-zA-Z ]*$/",$fname)) {
      $fname_error = "Kun bogstaver og mellemrum tilladt"; 
    }
  }
  
  if (empty($_POST["lname"])) {
    $lname_error = "Enter Your Last Name";
  } else {
    $lname = test_input($_POST["lname"]);
    // check if name only contains letters and whitespace
    if (!preg_match("/^[a-zA-Z ]*$/",$lname)) {
      $lname_error = "Kun bogstaver og mellemrum tilladt"; 
    }
  }
  
  if (empty($_POST["uname"])) {
    $uname_error = "Enter Your Username";
  } else {
    $uname = test_input($_POST["uname"]);
    // check if name only contains letters and whitespace
    if (!preg_match("/^[a-zA-Z ]*$/",$uname)) {
      $uname_error = "Kun bogstaver og mellemrum tilladt"; 
    }
  }

  if (empty($_POST["uemail"])) {
    $email_error = "Enter Your Email";
  } else {
    $uemail = test_input($_POST["uemail"]);
    // check if e-mail address is well-formed
    if (!filter_var($uemail, FILTER_VALIDATE_EMAIL)) {
      $email_error = "Email can example be: hej@hotmail.com"; 
    }
  }
   $password_length = 8;	
	
  if (empty($_POST["upass"])) {
    $upass_error = "Enter Your Password";
  }else {
	$upass = test_input($_POST["upass"]);
	if (!preg_match("#[0-9]+#", $upass) ) { 
	$upass_error = "Must contain at least one number";
	if ( !preg_match("#[A-Z]+#", $upass) ) {
	$upass_error = "Must contain at least one uppercase letter";
	if ( strlen($upass) < $password_length ) {
	$upass_error = "Must be more than 8 characters";
	if ( !preg_match("/\s/", $upass)) {
	$upass_error = "Space Not Allowed";
	}
	
	}
  }	
	}
  }
}
  
  if ($fname_error == '' and $lname_error == '' and $uname_error == '' and $email_error == '' and $upass_error == '' ){
      $message_body = '';
      unset($_POST['submit']);
      foreach ($_POST as $key => $value){
          $message_body .=  "$key: $value\n";
      }
}

function test_input($data) {
  $data = trim($data);
  $data = stripslashes($data);
  $data = htmlspecialchars($data);
  return $data;
}