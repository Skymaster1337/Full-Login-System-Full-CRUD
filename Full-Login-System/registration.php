<?php error_reporting(E_ALL); ?>
<?php require_once('PP_Modded_v1-master/include/class.user.php');
$user = new User();
$user->get_session();
$uid = $user->get_uid();

// define variables and set to empty values
$fname_error = $lname_error = $uname_error = $email_error = $upass_error = "";
$fname = $lname = $uname = $uemail = $upass = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    function test_input($data) {
        $data = trim($data);
        $data = stripslashes($data);
        $data = htmlspecialchars($data);
        return $data;
      }

      $checkPns = true;
//if (isset($_POST['submit'])){
    
    $fname = strip_tags(filter_input(INPUT_POST, 'fname', FILTER_SANITIZE_STRING));
	if (empty($_POST["fname"]) || strlen($_POST["fname"])<3) {
    $fname_error = "Enter Your First Name";
    $checkPns = false;
  } else {
    //echo 'succes';
    }

	$lname = strip_tags(filter_input(INPUT_POST, 'lname', FILTER_SANITIZE_STRING));
	 if (empty($_POST["lname"]) || strlen($_POST["lname"])<3) {
    $lname_error = "Enter Your Last Name";
    $checkPns = false;
  } else {
    //echo 'succes';
    }

	$uname = strip_tags(filter_input(INPUT_POST, 'uname', FILTER_SANITIZE_STRING));
	 if (empty($_POST["uname"]) || strlen($_POST["uname"])<3) {
    $uname_error = "Enter Your Username";
    $checkPns = false;
  } else {
    //echo 'succes';
    }
    $exMail = substr($_POST["uemail"], strpos($_POST["uemail"], "@") + 1);    
    $exMail = strpos($_POST["uemail"], '.');

    if(strpos($_POST["uemail"], '@') > 0 && strpos($_POST["uemail"], '.')>0 && $exMail > strpos($_POST["uemail"], '@') ){
        $chkEmail = true;
    } else {
        $chkEmail = false;
    }

	$uemail = strip_tags(filter_input(INPUT_POST, 'uemail', FILTER_SANITIZE_EMAIL));
	 if (empty($_POST["uemail"]) || strlen($_POST["uemail"])<3 || $chkEmail == false) {
    $email_error = "Enter Your Email (Example: xxx@hotmaill.com)";
    $checkPns = false;
  } else {
      
  } 
	$upass = strip_tags(filter_input(INPUT_POST, 'upass', FILTER_SANITIZE_STRING));
	 $password_length = 8;	

	if (empty($_POST["upass"]) || strlen($_POST["upass"])<3) {
    $upass_error = "Enter Your Password";
    $checkPns = false;
	} else {
		if (!preg_match("#[0-9]+#", $upass) ){ $upass_error = "Must contain at least one number"; $checkPns = false; }
		if (!preg_match("#[A-Z]+#", $upass) ){ $upass_error = "Must contain at least one uppercase letter"; $checkPns = false;}
		if (strlen($upass) < 8 ){ $upass_error = "Must be more than 8 characters"; $checkPns = false;}
        if (preg_match("/\s/", $upass)){ $upass_error = "Space Not Allowed"; $checkPns = false;}
    }

    if($checkPns == true){
    $register = $user->reg_user($fname, $lname, $uname, $uemail, $upass);
      
         if ($register) {
              // Registration Success
              echo '<script type="text/javascript"> alert("Your account has been successfully created, redirecting to login. "); window.location.replace("login.php"); </script>';
              exit();
              if(isset($_POST['man_redirect'])){
                  $r = $_POST['man_redirect'];
                  header("Location: ".$r);
              }
          } else {
              // Registration Failed
              echo "<div class='textcenter'>Registration failed. Email or Username already exits please try again.</div>";
          }
    }
}

?>
<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <title>Register</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
	<link rel="stylesheet" href="PP_Modded_v1-master/assets/css/custom.css" />
  </head>

  <body>
		<?php
			if(isset($_SESSION['man_redirect'])){
				$navItm = "";
				// Offer the Admin Page if Admin
				echo '<link rel="stylesheet" href="assets/css/custom_admin.css"/>';
				if( $user->has_role($uid, array("ADMIN", "MODERATOR") )){
					$navItm = '<a class="navbar-left" href="adminPage.php">Mgr Page</a>';
				}

				echo '<nav class="navbar navbar-default navbar-fixed-top">
					  <div class="container">
							<a class="navbar-left" href="home.php">Home</a>'.
								$navItm
							.'<a class="navbar-right" href="home.php?q=logout">LOGOUT</a>
					  </div>
					</nav>';
			}
		?>

    <div class="container">
      <h1>Registration Here</h1>
			<form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>" method="post" name="reg">
        <table class="table">
          <tr>
            <th>First Name:</th>
            <td>
              <div><input type="text" name="fname" value="<?php echo $fname ?>"></div>
              <span class="error"><?php echo $fname_error ?></span>
            </td>
          </tr>
          <tr>
            <th>Last Name:</th>
            <td>
             <div><input type="text" name="lname" value="<?php echo $lname ?>"></div>
               <span class="error"><?php echo $lname_error ?></span>
            </td>
          </tr>
          <tr>
            <th>User Name:</th>
            <td>
              <div><input type="text" name="uname" value="<?php echo $uname ?>"></div>
               <span class="error"><?php echo $uname_error ?></span>
            </td>
          </tr>
          <tr>
            <th>Email:</th>
            <td>
              <div><input type="email" name="uemail" value="<?php echo $uemail ?>"></div>
               <span class="error"><?php echo $email_error ?></span>
            </td>
          </tr>
          <tr>
            <th>Password:</th>
            <td>
              <div><input type="password" name="upass" value="<?php echo $upass ?>"></div>
               <span class="error"><?php echo $upass_error ?></span>
            </td>
          </tr>
          <tr>
            <td> </td>
            <td>
              <input class="btn" type="submit" id="contact-submit" onclick="window.onbeforeunload = null;" name="submit" value="Register">
            </td>
          </tr>
					<?php
						if(!isset($_SESSION['man_redirect'])){
		          	echo '<tr>
		            	<td> </td>
		            	<td><a href="login.php">Already registered? Click Here!</a></td>
		          	</tr>';
						}
						else {
							echo '<tr>';
								echo '<td> </td><td>';
								echo '(You are Creating a new User, <b>Don\'t Refresh</b>)';
								echo '<input type="hidden" name="man_redirect" value="'.$_SESSION['man_redirect'].'">';
								unset($_SESSION['man_redirect']); // Unset the Session Var.
								//echo '<script>/* Enable navigation prompt*/ window.onbeforeunload = function() { return false; };</script>';
							echo '</td></tr>';
						}
					?>
        </table>
      </form>
    </div>
  </body>
</html>
