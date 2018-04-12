<?php
require_once("PP_Modded_v1-master/include/class.user.php");
$user = User::getInstance();
if (!$user->get_session()){
	header("Location: login.php");
}
else if (isset($_GET['q'])){
	$user->user_logout();
	header("Location: login.php");
}
$uid = $_SESSION['uid'];
$userData = $user->get_user_by_id($uid);

switch($user->fetch_role($uid)){
	case "PUBLIC":
		echo "Welcome Pubic User. Please Login!";
		echo "<a href='login.php'>Click me!</a>";
		exit();
	break;

	case "GUEST":
		echo "Welcome Guest User!";
	break;

	case "MEMBER":
		echo "Hello Memeber!";
	break;

	case "ADMIN":
		echo "Hello Admin!";
	break;

	case "":
		http_response_code(500);
		echo "Please contact support, You Account has on perms.";
		exit();
	break;
	default:
		http_response_code(500);
		echo "Programming Error! User has no case!";
		exit();
	break;
}
echo "<br>";
echo "<a href='home.php'>Click me to goto your Profile!</a>";
?>
