<?php error_reporting(E_ALL); ?>
<?php
// require_once 'vendor/autoload.php';
// use ZxcvbnPhp\Zxcvbn;
/*$userData = array(
  'Marco',
  'marco@example.com'
);

$zxcvbn = new Zxcvbn();
$strength = $zxcvbn->passwordStrength('password', $userData);
echo $strength['score'];
// will print 0

$strength = $zxcvbn->passwordStrength('correct horse battery staple');
echo $strength['score'];
// will print 4*/
require_once('PP_Modded_v1-master/include/class.user.php');
$user = new User();
$user->get_session();
$uid = $user->get_uid();

// define variables and set to empty values
$fname_error = $lname_error = $uname_error = $email_error = $upass_error = "";
$fname = $lname = $uname = $uemail = $upass = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
//if (isset($_POST['submit'])){
	$fname = strip_tags(filter_input(INPUT_POST, 'fname', FILTER_SANITIZE_STRING));
	if (empty($_POST["fname"])) {
    $fname_error = "Enter Your First Name";
  } else {
    echo 'succes';
    }

	$lname = strip_tags(filter_input(INPUT_POST, 'lname', FILTER_SANITIZE_STRING));
	 if (empty($_POST["lname"])) {
    $lname_error = "Enter Your Last Name";
  } else {
    echo 'succes';
    }

	$uname = strip_tags(filter_input(INPUT_POST, 'uname', FILTER_SANITIZE_STRING));
	 if (empty($_POST["uname"])) {
    $uname_error = "Enter Your Username";
  } else {
    echo 'succes';
    }

	$uemail = strip_tags(filter_input(INPUT_POST, 'uemail', FILTER_SANITIZE_EMAIL));
	 if (empty($_POST["uemail"])) {
    $email_error = "Enter Your Email";
  } else {
    $uemail = test_input($_POST["uemail"]);
    // check if e-mail address is well-formed
    if (!filter_var($uemail, FILTER_VALIDATE_EMAIL)) {
      $email_error = "Email can example be: hej@hotmail.com"; 
    }	
  } 
	$upass = strip_tags(filter_input(INPUT_POST, 'upass', FILTER_SANITIZE_STRING));
	 $password_length = 8;	

	if (empty($_POST["upass"])) {
		$upass_error = "Enter Your Password";
	}else {
		if (!preg_match("#[0-9]+#", $upass) ) $upass_error = "Must contain at least one number";
		if (!preg_match("#[A-Z]+#", $upass) ) $upass_error = "Must contain at least one uppercase letter";
		if (strlen($upass) < 8 ) $upass_error = "Must be more than 8 characters";
		if (preg_match("/\s/", $upass)) $upass_error = "Space Not Allowed";
	}
}

function test_input($data) {
  $data = trim($data);
  $data = stripslashes($data);
  $data = htmlspecialchars($data);
  return $data;
}

	$register = $user->reg_user($fname, $lname, $uname, $uemail, $upass);

	if ($register) {
		// Registration Success
		echo "<div class='textcenter'>Registration successful <a href='login.php'>Click here</a> to login</div>";
		exit();
		if(isset($_POST['man_redirect'])){
			$r = $_POST['man_redirect'];
			header("Location: ".$r);
		}
	} else {
		// Registration Failed
		echo "<div class='textcenter'>Registration failed. Email or Username already exits please try again.</div>";
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
            <td>&nbsp;</td>
            <td>
              <input class="btn" type="submit" id="contact-submit" onclick="window.onbeforeunload = null;" name="submit" value="Register">
            </td>
          </tr>
					<?php
						if(!isset($_SESSION['man_redirect'])){
		          	echo '<tr>
		            	<td>&nbsp;</td>
		            	<td><a href="login.php">Already registered? Click Here!</a></td>
		          	</tr>';
						}
						else {
							echo '<tr>';
								echo '<td>&nbsp;</td><td>';
								echo '(You are Creating a new User, <b>Don\'t Refresh</b>)';
								echo '<input type="hidden" name="man_redirect" value="'.$_SESSION['man_redirect'].'">';
								unset($_SESSION['man_redirect']); // Unset the Session Var.
								echo '<script>/* Enable navigation prompt*/ window.onbeforeunload = function() { return false; };</script>';
							echo '</td></tr>';
						}
					?>
        </table>
      </form>
    </div>
  </body>
</html>
