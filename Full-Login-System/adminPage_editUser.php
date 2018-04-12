<?php
require_once('PP_Modded_v1-master/include/class.user.php');
$user = User::getInstance();
	if (!$user->get_session()){
	   header("Location: login.php");
	}
$uid = $_SESSION['uid'];
$userData = $user->get_user_by_id($uid);

// Check User Perms
if(!$user->has_role($uid, array("ADMIN", "MODERATOR") )){
  header("Location: home.php");
}

// Grab User Account by the ID, Check if it Exists and setup.
	$userI = $user->get_user_by_id($_GET['uid']); // Grab User Listing that will be edited.
	if(empty($userI)){
		echo "User not found! Please go back and specify and real user!";
		if(isset($_GET['url'])){
			header('Location: '.urldecode($_GET['url']));
		}
		exit();
	}

// Do the Update if Presented with the Needed Data.
if (isset($_POST['submit'])){
	$uid = strip_tags(filter_input(INPUT_POST, 'uidUpdate', FILTER_SANITIZE_STRING));
	$fname = strip_tags(filter_input(INPUT_POST, 'fname', FILTER_SANITIZE_STRING));
	$lname = strip_tags(filter_input(INPUT_POST, 'lname', FILTER_SANITIZE_STRING));
	$uname = strip_tags(filter_input(INPUT_POST, 'uname', FILTER_SANITIZE_STRING));
	$uemail = strip_tags(filter_input(INPUT_POST, 'uemail', FILTER_SANITIZE_EMAIL));
	$upass = strip_tags(filter_input(INPUT_POST, 'upass', FILTER_SANITIZE_STRING));
	$update = $user->update_user($uid, $fname, $lname, $uname, $uemail);

	// Do the Password Update, if not empty.
	if(!empty($upass)){
		$user->update_password($uid, $upass);
	}

	$newRoles = isset($_POST['newRoles'])?$_POST['newRoles']:array();
	$user->update_roles($uid, $newRoles);

	echo "<div class='textcenter'>Upadate Successful!</div>";
	if(isset($_GET['url'])){
		header('Location: '.urldecode($_GET['url']));
	}
}


function doTell(&$in, $default = ""){ return isset($in)?$in:$default; }

?>
<head>
	<link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.css" rel="stylesheet" integrity="sha256-NuCn4IvuZXdBaFKJOAcsU2Q3ZpwbdFisd5dux4jkQ5w=" crossorigin="anonymous">
    <link rel="stylesheet" href="PP_Modded_v1-master/assets/css/bootstrap.css"/>
		<link rel="stylesheet" href="PP_Modded_v1-master/assets/css/custom.css"/>
		<link rel="stylesheet" href="PP_Modded_v1-master/assets/css/multiselect.css"/>
		<script src="PP_Modded_v1-master/assets/js/jquery.js"></script>
		<script src="PP_Modded_v1-master/assets/js/multiselect.min.js"></script>
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

	<!-- SweetAlert -->
  <script src="PP_Modded_v1-master/assets/js/sweetalert.min.js"></script>
  <link rel="stylesheet" href="PP_Modded_v1-master/assets/css/sweetalert.min.css">
	<script>
		// @link https://www.ludu.co/lesson/how-to-use-sweetalert
		function deleteUser() {
			var userId = <?php echo $_GET['uid']; ?>;
			var linkURL = "adminPage_users.php?delete=";
	    swal({
	      title: "Delete the User?",
	      text: "If you want to delete User " + userId + " then click Ok!",
	      type: "warning",
	      showCancelButton: true
	    }, function() {
	      // Redirect the user
				window.onbeforeunload = null;
	      window.location.href = linkURL + userId;
	    });
	  }
	</script>
	<link rel="stylesheet" href="PP_Modded_v1-master/assets/css/sidebar.css"/>
	<ul id="social_side_links">
		<li><a style="background-color: #e81010" onclick="deleteUser()" title="Delete User"><img src="PP_Modded_v1-master/assets/images/user-delete.svg" /></a></li>
	</ul>

	<div class="container">
		<h1>Update User Account</h1>
		<?php
			// Check if you are shooting your self in the foot.
			if($uid == $_GET['uid']){
				echo '
					<div class="alert alert-danger">
					  <strong>Danger!</strong> You are Editing your own Profile! If you remove and permissions on your account you may lose access to this page.
					</div>
					<script>
						function deleteUser(){
							swal("Not Allowed!", "Sorry, You can\'t shoot your self in the foot.", "error");
						}
					</script>
				';
			}
		?>
		<form action="" method="POST" name="reg">
			<table class="table">
				<tr>
					<th>Full Name:</th>
					<td>
						<input type="text" name="fname" value="<?php echo $userI['fname'] ?>" required>
					</td>
				</tr>
				<tr>
					<th>Last Name:</th>
					<td>
						<input type="text" name="lname" value="<?php echo $userI['lname'] ?>" required>
					</td>
				</tr>
				<tr>
					<th>User Name:</th>
					<td>
						<input type="text" name="uname" value="<?php echo $userI['uname'] ?>" required>
					</td>
				</tr>
				<tr>
					<th>Email:</th>
					<td>
						<input type="email" name="uemail" value="<?php echo $userI['uemail'] ?>" required>
					</td>
				</tr>
				<tr>
					<th>Password:</th>
					<td>
						<input type="password" name="upass" value>
					</td>
				</tr>

				<tr>
					<th>Roles:</th>
					<td>
						<div class="row">
							<div class="col-xs-5">
								<select id="multiselect" class="roleList form-control" size="8" multiple="multiple">
									<?php
										$nonJoin = $user->fetch_all_roles();
										print_r($nonJoin);
										foreach($nonJoin as $id => $role){
											echo '<option value="'.$role['role_id'].'">'.$role['role_name'].'</option>';
										}
									?>

								</select>
							</div>
							<div class="col-xs-2">
								<button type="button" id="multiselect_rightAll" class="btn btn-block"><i class="fa fa-forward" aria-hidden="true"></i></button>
								<button type="button" id="multiselect_rightSelected" class="btn btn-block"><i class="fa fa-chevron-right" aria-hidden="true"></i></button>
								<button type="button" id="multiselect_leftSelected" class="btn btn-block"><i class="fa fa-chevron-left" aria-hidden="true"></i></button>
								<button type="button" id="multiselect_leftAll" class="btn btn-block"><i class="fa fa-backward" aria-hidden="true"></i></button>
							</div>

							<div class="col-xs-5">
								<select name="newRoles[]" id="multiselect_to" class="roleList form-control" size="8" multiple="multiple">
									<?php
										$joined = $user->fetch_roles_order($_GET['uid']);
										foreach($joined as $id => $role){
											echo '<option value="'.$role['role_id'].'">'.$role['role_name'].'</option>';
										}
									?>
								</select>
							</div>
						</div>

						<script type="text/javascript">
							jQuery(document).ready(function($) {
									$('#multiselect').multiselect({
										keepRenderingSort: true
									});
							});
						</script>
					</td>
				</tr>
				<tr>
					<td>&nbsp;</td>
					<td>
						(You are Editing a User)
						<?php echo '<input type="hidden" name="uidUpdate" value="'.$_GET['uid'].'">'; ?>
						<script>/* Enable navigation prompt*/ window.onbeforeunload = function() { return false; };</script>
					</td>
				</tr>

				<tr>
					<td>&nbsp;</td>
					<td>
						<input class="btn" type="submit" onclick="window.onbeforeunload = null;" name="submit" value="Update" onclick="return(submitreg());">
					</td>
				</tr>
			</table>
		</form>
	</div>
  <script src="PP_Modded_v1-master/assets/js/bootstrap.min.js"></script>
</body>
</html>
