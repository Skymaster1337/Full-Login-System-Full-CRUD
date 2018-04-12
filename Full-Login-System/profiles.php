<?php
require_once('PP_Modded_v1-master/include/class.user.php');
$user = User::getInstance();
	if (!$user->get_session()){
	   header("Location: login.php");
	}
	$uid = $_SESSION['uid'];

	if(isset($_POST['Submit'])) {
		// $uid, $fname, $lname, $email, $address, $zipcode, $city, $phone
		User::updateProfile($uid, c($_POST["fname"]), c($_POST["lname"]), c($_POST["email"]), c($_POST["address"]), c($_POST["zipcode"]), c($_POST["city"]), c($_POST["phone"]));
		$_SESSION['UPDATE'] = true;
		if(mysqli_errno($mysqli)){
			echo mysqli_error($mysqli);
			exit();
		}
		header("Location: ".$_SERVER['PHP_SELF']);
	}
	else {
		unset($_SESSION['UPDATE']);
	}

	function doTell(&$in, $default = ""){
		return isset($in)?$in:$default;
	}

$userData = $user->get_user_by_id($uid);
?>
<head>
	<link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.css" rel="stylesheet" integrity="sha256-NuCn4IvuZXdBaFKJOAcsU2Q3ZpwbdFisd5dux4jkQ5w=" crossorigin="anonymous">
	<link href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css" rel="stylesheet" integrity="sha256-7s5uDGW3AHqw6xtJmNNtr+OBRJUlgkNJEo78P4b0yRw= sha512-nNo+yCHEyn0smMxSswnf/OnX6/KwJuZTlNZBjauKhTK0c+zT+q5JOCx0UFhXQ6rJR9jg6Es8gPuD2uZcYDLqSw==" crossorigin="anonymous">
    <style>
		body {
			padding-top: 70px;
		}
		.othertop{margin-top:10px;}
    </style>
</head>
<body>
	<span style="padding-left: 25%;">
		<a href="home.php">Back</a>
	</span>
	<div class="container">
		<div class="row">
			<div class="col-md-10">
				<form class="form-horizontal" method="post" action="" onsubmit="return valider(this)">
					<input type="hidden" name="uid" value="<?php echo $userData['uid']; ?>">
					<fieldset>
						<center>
							<legend>User Profile (All Feilds Required)<?php echo doTell($_SESSION['UPDATE'])?" (Updated)":""; ?></legend>
						</center>
						<div class="form-group">
							<label class="col-md-4 control-label" for="fname">Full name</label>
							<div class="col-md-4">
								<div class="input-group">
								   <div class="input-group-addon">
										<i class="fa fa-user"></i>
								   </div>
								   <input id="fname" name="fname" type="text" placeholder="" value="<?php echo doTell($userData['fname']); ?>" class="form-control input-md">
								</div>
							</div>
						</div>
						<div class="form-group">
							<label class="col-md-4 control-label" for="lname">Last name</label>
							<div class="col-md-4">
								<div class="input-group">
									<div class="input-group-addon">
										<i class="fa fa-user"></i>
									</div>
									<input id="lname" name="lname" type="text" placeholder="" value="<?php echo doTell($userData['lname']); ?>" class="form-control input-md">
								</div>
							</div>
						</div>

						<div class="form-group">
							<label class="col-md-4 control-label" for="email">Email Address</label>
							<div class="col-md-4">
								<div class="input-group">
									<div class="input-group-addon">
										<i class="fa fa-envelope"></i>
									</div>
									<input id="email" name="email" type="text" placeholder="" value="<?php echo doTell($userData['uemail']); ?>" class="form-control input-md">
								</div>
							</div>
						</div>
						<div class="form-group">
							<label class="col-md-4 control-label" for="address">Address</label>
							<div class="col-md-4">
								<div class="input-group">
									<div class="input-group-addon">
										<i class="fa fa-address-card" aria-hidden="true"></i>
									</div>
								   <input id="address" name="address" type="text" placeholder="" value="<?php echo doTell($userData['address']); ?>" class="form-control input-md">
								</div>
							</div>
						</div>
						<div class="form-group">
							<label class="col-md-4 control-label" for="zipcode">Zipcode</label>
							<div class="col-md-4">
								<div class="input-group">
									<div class="input-group-addon">
										<i class="fa fa-sticky-note-o"></i>
									</div>
									<input id="zipcode" name="zipcode" type="text" placeholder="" maxlength="6" value="<?php echo doTell($userData['zipcode']); ?>" class="form-control input-md">
								</div>
							</div>
						</div>
						<div class="form-group">
							<label class="col-md-4 control-label" for="city">City</label>
							<div class="col-md-4">
								<div class="input-group">
									<div class="input-group-addon">
										<i class="fa fa-building"></i>
									</div>
									<input id="city" name="city" type="text" placeholder="" value="<?php echo doTell($userData['city']); ?>" class="form-control input-md">
								</div>
							</div>
						</div>
						<div class="form-group">
							<label class="col-md-4 control-label" for="phone">Phone Number</label>
							<div class="col-md-4">
								<div class="input-group">
									<div class="input-group-addon">
										<i class="fa fa-phone"></i>
									</div>
									<input id="phone" name="phone" type="text" placeholder="" maxlength="12" value="<?php echo doTell($userData['phone']); ?>" class="form-control input-md">
								</div>
							</div>
						</div>
						<div class="form-group">
							<label class="col-md-4 control-label" ></label>
							<div class="col-md-4">
								<input class="btn btn-success" type="submit" value="Submit" name="Submit">
							</div>
						</div>
					</fieldset>
				</form>
			</div>
			<div class="col-md-2 hidden-xs">
				<img src="http://websamplenow.com/30/userprofile/images/avatar.jpg" class="img-responsive img-thumbnail ">
				<div>
					<h3>User Perms</h3>
					<hr></hr>
					<?php
						$user_roles = $user->fetch_roles_order($uid);
						$user_roles = array_map(function($item) {
						    return $item["role_name"];
						}, $user_roles);

						foreach($user_roles as $index => $name){
							if(0 != $index) { echo "<br>"; }
							echo "&mdash; ".$name;
						}
					?>
				</div>
			</div>
			<script>
				function valider(f){
					if(f.fname.value ==""){
					alert("Enter First Name");
					f.fname.focus();
					return false;
				}

				if(f.lname.value ==""){
					alert("Enter Last Name");
					f.lname.focus();
					return false;
				}

				var atpos = f.email.value.indexOf("@");
				var dotpos = f.email.value.lastIndexOf(".");

				if (atpos<1 || dotpos<atpos+2 || dotpos+2>=f.email.value.length){
					alert("Please enter a valid email fx dragonball@love.dk");
					f.email.focus();
					return false;
				}

				if(f.address.value ==""){
					alert("Enter Full Address fx Capitalcity 201 3c");
					f.address.focus();
					return false;
				}

				if(f.zipcode.value ==""){
					alert("Please Enter A Valid Zip Code fx 2730");
					f.zipcode.focus();
					return false;
				}

				if(isNaN(f.zipcode.value)){
					alert("Zipcode can only have numbers");
					f.zipcode.focus();
					return false;
				}

				if(f.zipcode.value.length < 4 || f.zipcode.value.length > 6){
					alert("Please Enter zipcode with 4 Digits");
					f.zipcode.focus();
					return false;
				}

				if(f.city.value ==""){
					alert("Please Enter A city");
					f.city.focus();
					return false;
				}

				if(f.phone.value ==""){
					alert("Please Enter A Valid Number");
					f.phone.focus();
					return false;
				}


				if(isNaN(f.phone.value)){
					alert("Enter Phone with numbers only");
					f.phone.focus();
					return false;
				}

				if(f.phone.value.length < 8 || f.phone.value.length > 12){
					alert("Please Enter 8 Digits fx 44444444");
					f.phone.focus();
					return false;
				}

				return true;
			}
			</script>
	   </div>
	</div>
    <script src="PP_Modded_v1-master/assets/js/jquery.js"></script>
    <script src="PP_Modded_v1-master/assets/js/bootstrap.min.js"></script>
</body>
</html>
