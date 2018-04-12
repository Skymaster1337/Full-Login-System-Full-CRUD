<?php
session_start();
    include_once '../PP_Modded_v1-master/include/class.user.php';
    $user = User::getInstance();
    $uid = $_SESSION['uid'];
    if (!$user->get_session()){
       header("Location: ../login.php");
    }
    if (isset($_GET['q'])){
        header("Location: ../login.php?q");
    }
	$userData = $user->get_user_by_id($uid);
?>
<!DOCTYPE html>
<html lang="en">
	<head>
		<meta charset="utf-8">
		<title>Home</title>
		<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
		<link rel="stylesheet" href="../PP_Modded_v1-master/assets/css/custom.css"/>
	</head>
	<body>
		<nav class="navbar navbar-default navbar-fixed-top">
		  <div class="container">
				<a class="navbar-left" href="../home.php">Home</a>
				<?php
					// Offer the Admin Page if Admin
					if($user->has_role($uid, array("ADMIN", "MODERATOR") )){
						echo '<a class="navbar-left" href="../adminPage.php">Mgr Page</a>';
					}
				?>
				<a class="navbar-right" href="../home.php?q=logout">LOGOUT</a>
		  </div>
          
		</nav>
        <div class="d-flex background-nav2">
  			<div class="mr-auto p-2"><?php
				if($user->has_role($uid, "ADMIN")){
						echo "Hello, Admin";
					}
					else if($user->has_role($uid, "MODERATOR")) {
						echo "Hello, Mod";
					}
					else {
						echo "Hello, User";
					}
					?> |
            </div>
  <div class="p-2"><a href="">| Support</a></div>
  <div class="p-2"><a href="">| My Favorites</a></div>
  <div class="p-2"><a href="">| My Recommendations</a></div>
  <div class="p-2"><a href="settings/settings.php">| Settings</a></div>
  <div class="p-2"><a href="">| Messages</a></div>
</div>
		<br>
		<div class="row margin">
			<div class="col-md-4">
				<a href="../profiles.php">Edit Profile</a><br>
				<a href="../password.php">Change Password</a><br>
				<a href="../imagePage.php">Upload Picture</a>
			</div>
			<div class="col-md-4">
			   <h1>
				<center>
					
				</center>
			  </h1>
		   </div>
			<div class="col-md-4">
				
			</div>
		</div>
	</body>
</html>
