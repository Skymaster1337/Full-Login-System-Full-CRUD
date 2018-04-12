<?php
require_once('PP_Modded_v1-master/include/class.user.php');
$user = new User();
	if (!$user->get_session()){
	   header("Location: login.php");
	}
	$uid = $_SESSION['uid'];
	$userData = $user->get_user_by_id($uid);

	// Check User Perms
	if(!$user->has_role($uid, array("ADMIN", "MODERATOR") )){
	  header("Location: home.php");
	}

	function doTell(&$in, $default = ""){ return isset($in)?$in:$default; }

// Check for a Registration Request
	if(isset($_GET['reg'])) {
		// Setup the Registration Page and Detection of the Current Session
		$_SESSION['man_redirect'] = "adminPage_users.php?view";
		header("Location: registration.php");
		exit();
	}

// Delete the User on Request
	if(isset($_GET['delete'])){
		$user->delete_user($_GET['delete']);
		header("Location: adminPage_users.php?edit");
		exit();
	}

// Setup for an Edit Mode on Request
	$editMode = false;
	if(isset($_GET['edit'])) {
		$editMode = true;
	}
	if(isset($_GET['edit']) && isset($_GET['uid']) ){
		header("Location: adminPage_editUser.php?url=adminPage_users.php%3Fedit&uid=".$_GET['uid']);
		exit();
	}

?>
<head>
	<link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.css" rel="stylesheet" integrity="sha256-NuCn4IvuZXdBaFKJOAcsU2Q3ZpwbdFisd5dux4jkQ5w=" crossorigin="anonymous">
    <link rel="stylesheet" href="PP_Modded_v1-master/assets/css/bootstrap.css"/>
		<link rel="stylesheet" href="PP_Modded_v1-master/assets/css/custom.css"/>
</head>
<body>
	<link rel="stylesheet" href="PP_Modded_v1-master/assets/css/custom_admin.css"/>
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

	<link rel="stylesheet" href="PP_Modded_v1-master/assets/css/sidebar.css"/>
	<ul id="social_side_links">
		<?php if(!isset($_GET['edit'])){
				echo '<li><a style="background-color: #54d063;" href="?edit" title="Edit Mode"><!-- add target="_blank" to open in new tab. --><img src="assets/images/pencil.svg" /></a></li>';
		} ?>
		<li><a style="background-color: #54aed0" href="PP_Modded_v1-master/?reg" title="New User"><img src="PP_Modded_v1-master/assets/images/create-group-button.svg" /></a></li>
	</ul>

	<div class="container">
		<div class="row">
			<table class="table">
			  <thead>
				<tr>
				  <th scope="col">#</th>
				  <th scope="col">First Name</th>
				  <th scope="col">Last Name</th>
				  <th scope="col">Username</th>
					<?php
						if($editMode == true){
							echo '<th scope="col">&nbsp;</th>';
						}
					?>
				</tr>
			  </thead>
			  <tbody>
				<?php
					$usersList = $user->fetch_all_users(); // Grab User Listing

					foreach($usersList as $i => $userI ){
						echo "<tr>";
							echo "<th scope=\"row\">".$userI['uid']."</th>";
							echo "<td>".$userI['fname']."</td>";
							echo "<td>".$userI['lname']."</td>";
							echo "<td>".$userI['uname']."</td>";
							echo "<td>";
								$uR = $user->fetch_role($userI['uid']);
								switch($uR){
										case "ADMIN":
											echo '&nbsp;<i class="fa fa-id-badge" aria-hidden="true" title="Administrator"></i>&nbsp;&nbsp;';
										break;

										case "MODERATOR":
											echo '<i class="fa fa-user-circle" aria-hidden="true" title="Moderator"></i>&nbsp;&nbsp;';
										break;

										case "MEMBER":
											echo '<i class="fa fa-user-circle-o" aria-hidden="true" title="Member"></i>&nbsp;&nbsp;';
										break;

										case "GUEST":
											echo '<i class="fa fa-user-o" aria-hidden="true" title="Guest"></i>&nbsp;&nbsp;';
										break;

										case "NONE":
											echo '<i class="fa fa-user-times" aria-hidden="true" title="User has no Perms"></i>&nbsp;&nbsp;';
										break;

										default:
										break;
								}

								if($editMode == true){
									echo "<a href=\"?edit&uid=".$userI['uid']."\"><i class=\"fa fa-pencil-square\" aria-hidden=\"true\"></i>&nbsp;Edit User</a>";
								}
							echo "</td>";
						echo "</tr>";
					}
				?>
			  </tbody>
			</table>
	   </div>
	</div>
    <script src="PP_Modded_v1-master/assets/js/jquery.js"></script>
    <script src="PP_Modded_v1-master/assets/js/bootstrap.min.js"></script>
</body>
</html>
