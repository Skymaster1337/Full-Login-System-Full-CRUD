<?php
session_start();
require_once('PP_Modded_v1-master/include/class.user.php');
$user = new User();
    if (!$user->get_session()){
       header("Location: login.php");
    }
$uid = $_SESSION['uid'];
$userData = $user->get_user_by_id($uid);

if(isset($_POST['old_password'])){
  echo "<center>Updated Password</center>";
}

?>
<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="utf-8">
	<title>Home</title>
	<link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.css" rel="stylesheet" integrity="sha256-NuCn4IvuZXdBaFKJOAcsU2Q3ZpwbdFisd5dux4jkQ5w=" crossorigin="anonymous">
	<link rel="stylesheet" href="PP_Modded_v1-master/assets/css/bootstrap.min.css" />
	<link rel="stylesheet" href="PP_Modded_v1-master/assets/css/custom.css"/>
</head>
<body>
  <nav class="navbar navbar-default navbar-fixed-top">
	  <div class="container">
			<a class="navbar-left" href="home.php">Home</a>
			<?php
				// Offer the Admin Page if Admin
				if($user->has_role($uid, array("ADMIN", "MODERATOR") )){
					echo '<a class="navbar-left" href="adminPage.php">Mgr Page</a>';
				}
			?>
			<a class="navbar-right" href="home.php?q=logout">LOGOUT</a>
	  </div>
	</nav>
	<br>
    <div class="row margin">
		<div class="col-md-4">
			<img src="PP_Modded_v1-master/assets/images/vegeta.jpg" alt="welcome"/><br>
			<br><b><?php echo $user->has_role($uid, "ADMIN")?"Welcome Admin":"Welcome User" ?></b>
			<br>First Name: <?php echo ucwords($userData['fname']); ?>
			<br>Last Name: <?php echo ucwords($userData['lname']); ?>
			<br>Email: <?php echo $userData['uemail']; ?>
		</div>
		<div class="col-md-4">
			<center>
        <br>
				<h1>
					Hello <?php echo ucwords($userData['fname']); ?>
				</h1>
        <br>
        <form action="" method="POST">
          <div class="form-group row">
            <!--<label for="inputPasswordOld" >Old Password</label>-->
            <div class="input-group">
              <span class="input-group-addon" id="basic-addon1"> <i class="fa fa-lock"></i></span>
              <input type="password" name="old_password" id="inputPasswordOld"  class="form-control" placeholder="Old Password" aria-describedby="passwordHelpInline">
            </div>
          </div>
          <div class="form-group row">
          <!--<label for="inputPasswordNew">New Password</label>-->
            <div class="input-group">
              <span class="input-group-addon" id="basic-addon1"> <i class="fa fa-lock"></i></span>
              <input type="password" name="new_password" id="inputPasswordNew"  class="form-control" placeholder="New Password" aria-describedby="passwordHelpInline">
            </div>
          </div>
          <div class="form-group row">
            <div class="input-group">
              <button type="submit" class="btn btn-primary">Set Password</button>
            </div>
          </div>
        </form>
			</center>
		</div>
	</div>
	<div id="footer"></div>
    </div>
  </body>

</html>
