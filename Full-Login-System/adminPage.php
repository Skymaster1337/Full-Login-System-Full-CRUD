<?php
session_start();
require_once('PP_Modded_v1-master/include/class.user.php');
$user = User::getInstance();
$uid = $_SESSION['uid'];

if (!$user->get_session()){
    header("Location: home.php");
	exit(); # Stop Loading
}
//$userData = $user->get_user_by_id($uid);
$userData = User::getUser();

// Check User Perms
if(!$user->has_role($uid, array("ADMIN", "MODERATOR") )){
  header("Location: home.php");
}

$role_level = 0;
$role = $user->fetch_role($uid);
switch(strtoupper($role)){
	case "MODERATOR":
		// Authorized
	break;

	case "ADMIN":
		// Authorized
	break;

	default:
		http_response_code(403);
		header("Location: home.php");
	exit(); # Stop Loading
	break;
}
?>

<head>
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
	<link rel="stylesheet" type="text/css" href="PP_Modded_v1-master/assets/css/custom.css">
    <link rel="stylesheet" href="PP_Modded_v1-master/assets/css/custom_admin.css"/>
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
            <?php
					if($user->has_role($uid, "ADMIN")){
						echo "Welcome Admin!";
					}
					else if($user->has_role($uid, "MODERATOR")) {
						echo "Welcome Mod!";
					}
					else {
						echo "Welcome User!";
					}
				?>
			<a class="navbar-right" href="home.php?q=logout">LOGOUT</a>
	  </div>
	</nav>
	<br>
	<div class="row margin">
		<div class="col-md-4">
			            <div class="sidebar-wrapper">
                <div class="logo">
                    <span class="simple-text">
                        CMK Mobler
                    </span>
                </div>
                <ul>
                    <li>
                        <a class="nav-link" href="skrivebordet.php">
                            <i class="nc-icon nc-chart-pie-35"></i>
                            <p>Skrivebordet</p>
                        </a>
                    </li>
                    <li>
                        <a class="nav-link" href="admin-opretprodukter.php">
                            <i class="nc-icon nc-circle-09"></i>
                            <p>Opret Produkt(er)</p>
                        </a>
                    </li>
                                        <li>
                        <a class="nav-link" href="admin-produkter.php">
                            <i class="nc-icon nc-circle-09"></i>
                            <p>Alle Produkt(er)</p>
                        </a>
                    </li>
                    <li>
                        <a class="nav-link" href="admin-nyheder.php">
                            <i class="nc-icon nc-notes"></i>
                            <p>Opret Nyhed(er)</p>
                        </a>
                    </li>
                                        <li>
                        <a class="nav-link" href="admin-opretnyheder.php">
                            <i class="nc-icon nc-notes"></i>
                            <p>Opret Nyhed(er)</p>
                        </a>
                    </li>
                    <li>
                        <a class="nav-link" href="admin-brugere.php">
                            <i class="nc-icon nc-notes"></i>
                            <p>Brugere & Rettighed</p>
                        </a>
                    </li>
                </ul>
            </div>
		</div>
		<div class="col-md-4">
		   <h1>
			<center>
				<br>Welcome <?php echo ucwords($userData['fname']); ?>
				<br>Status: <?php echo $user->get_status($uid); ?>
			</center>
		  </h1>
	   </div>
		<div class="col-md-4">
			<a href="adminPage_users.php">View Users</a><br>
			<a href="adminPage_users.php?edit">Edit Users</a><br>
			<a href="adminPage_users.php?reg">New Users</a><br>
		</div>
	</div>
</body>
