<?php
$title = "sing up";
$admin = "";
$noHeader = true;
session_start();

if (isset($_COOKIE["admin_id"])) {
	header("location: index.php");
}
include "include/init.php";
// include "include/lang/arabic.php";
$error  =  array("name" => "", "pass" => "", "email" => "", "number" => "");
if ($_SERVER["REQUEST_METHOD"] == "POST") {


	$name = filter_var($_POST["name"], FILTER_SANITIZE_STRING);
	$email = filter_var($_POST["email"], FILTER_SANITIZE_EMAIL);
	$number = filter_var($_POST["number"], FILTER_SANITIZE_NUMBER_INT);
	$pass1 = filter_var($_POST["password1"], FILTER_SANITIZE_STRING);
	$pass2 = filter_var($_POST["password2"], FILTER_SANITIZE_STRING);
	$shapass = password_hash($pass1, PASSWORD_DEFAULT);

	// $pass = filter_var($_POST["pass"] , FILTER_SANITIZE_STRING);

	// testing the inputs to system
	$checkemail = checkExist("*", "users", " email = '$email'");
	// check err on the input 
	if (empty($name)) {
		$error["name"] = "name cant be empty";
	} elseif (strlen($name) < 8) {
		$error["name"] = "this is less than request";
	}
	if (empty($email)) {
		$error["email"] = "name cant be empty";
	} elseif (strlen($email) < 8) {
		$error["email"] = "this is less than request";
	} elseif (!$checkemail == 0) {

		$error["email"] = "this emial is exiest";
	}
	if (empty($number)) {
		$error["number"] = "there is no email";
	} elseif (strlen($number) < 8) {
		$error["number"] = "that email in not exiest ";
	}
	if (empty($pass1)) {
		$error["pass"] = "name cant be empty";
	} elseif (strlen($pass1) < 8) {
		$error["pass"] = "this is less than request";
	} elseif ($pass1 !== $pass2) {
		$error["pass"] = "there is no matched";
	}
	if (!array_filter($error)) {

		$q = $con->prepare("INSERT INTO users ( `name` , email , pass   ,mobile , `admin` ) 
	    VALUES (?,?,?,?,0)");
		$q->execute(array($name, $email, $shapass, $number));
		// $massege = '<div class="alert alert-success">1 recored insert</div>';

		$fetchUserData = $con->prepare("SELECT * FROM users where name = ? and pass = ? and email = ? limit 1");
		$fetchUserData->execute(array($name, $shapass, $email));
		$user = $fetchUserData->fetch();


		setcookie("admin_name",   $user["name"],  time() + (20000  * 10000), "/");
		setcookie("admin_id",     $user["id"],  time() + (200000 * 10000), "/");
		setcookie("admin_auth",  $user["admin"],  time() + (200000 * 10000), "/");
		header("location: index.php?wellcom");
	}
}
?>
<div class="container">
	<div class="custom_justify_content">
		<div class="form_container col-sm-7  mt-5 <?php echo $algin; ?> ">
			<div class="custom_card login_form pa-5">
				<div class="text-center">
					<img class='login_img mt-4' src="<?php echo $img ?>profile.svg" alt=""
						class="login_profile sing_up">
				</div>
				<h3 class="text-center">sing up </h3>
				<form class="form-horizontal  " action=<?php echo $_SERVER["PHP_SELF"]; ?> method="post">

					<div class="form-group form-group-lg">
						<lable class="control-lable col-sm-2">name:</lable>
						<div class=" input_container">
							<input type="text" placeholder="enter your name" class=form-control name=name
								required>
						</div>
						<h6 class="error"><?php echo $error["name"] ?></h6>
					</div>

					<div class="form-group form-group-lg">
						<lable class="control-lable col-sm-2">email:</lable>
						<div class=" input_container">
							<input type="text" placeholder="email address" class="form-control" name=email>
						</div>
						<h6 class="error"><?php echo $error["number"] ?></h6>
					</div>
					<div class="form-group form-group-lg">
						<lable class="control-lable col-sm-2">mobaile number:</lable>
						<div class=" input_container">
							<input type="text" placeholder="enter you phone number should contant to you "
								class="form-control" name=number>
						</div>
						<h6 class="error"><?php echo $error["number"] ?></h6>
					</div>
					<div class="form-group form-group-lg">
						<lable class="control-lable col-sm-2">password:</lable>
						<div class=" input_container">
							<input type="password" placeholder="password" class="form-control" name=password1>
						</div>
						<h6 class="error"><?php echo $error["pass"] ?></h6>

					</div>
					<div class="form-group form-group-lg">
						<lable class="control-lable col-sm-2">confirem password:</lable>
						<div class=" input_container">
							<input type="password" placeholder="confrim password" class="form-control"
								name=password2>
						</div>
						<h6 class="error"><?php echo $error["pass"] ?></h6>
					</div>
					<div class="margin_bottom">
						<input type="submit" class="btn  login_btn btn-sm m-2" name="send" value='send'>
					</div>
					<h6 class="mt-3"><a href="login.php">i have a count ?</a></h6>
				</form>
			</div>
		</div>
	</div>
</div>

<?php
include "include/footer.php";