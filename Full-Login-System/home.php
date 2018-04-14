<?php
session_start();
    include_once 'PP_Modded_v1-master/include/class.user.php';
    $user = User::getInstance();
    $uid = $_SESSION['uid'];
    if (!$user->get_session()){
       header("Location: login.php");
    }
    if (isset($_GET['q'])){
        header("Location: login.php?q");
    }
	$userData = $user->get_user_by_id($uid);
?>
<!DOCTYPE html>
<html lang="en">
	<head>
		<meta charset="utf-8">
		<title>Home</title>
		<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
		<link rel="stylesheet" href="PP_Modded_v1-master/assets/css/custom.css"/>
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
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
        <div class="d-flex background-nav2">
  			<div class="mr-auto p-2">
            Welcome Back, <?php echo $userData['fname'];?>! |
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
            <img src="PP_Modded_v1-master/assets/images/vegeta.jpg" alt="welcome"/><br>
				<br><b>
					
				</b>

				<br>First Name: <?php echo ucwords($userData['fname']); ?>
				<br>Last Name: <?php echo ucwords($userData['lname']); ?>
				<br>Email: <?php echo $userData['uemail']; ?>
			</div>
			<div class="col-md-4">
			   <h1>
				<center>
					alt indhold
				</center>
			  </h1>
		   </div>
           <div class="col-md-4 userstats-background">
           User stats<br>
           Put a Image Here<br>
            <div class="userstatsborder"><?php
				if($user->has_role($uid, "ADMIN")){
						echo "Group: Admin";
					}
					else if($user->has_role($uid, "MODERATOR")) {
						echo "Group, Mod";
					}
					else {
						echo "Group, User";
					}
					?>
             </div>
                    <div class="userstatsborder">Joined: 20 Jan 2018</div>
                    <div class="userstatsborder">Last Seen: 20:18</div>
                    <div class="userstatsborder">Local Time: 03:01am</div>
                    <div class="userstatsborder"><a href="Lastpost.php">Last Post</a> 10 hours 20 mionutes ago</div>
                    <div class="userstatsborder">Location: Nowhere</div>
                    <div class="userstatsborder">Status: Chilling</div>
			</div>
		</div>
	</body>
</html>
