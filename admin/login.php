<?php
$noHeader = "";
session_start();
if (isset($_COOKIE["admin_name"])) {
	header("location: index.php");
}
include 'include/init.php';

?>
<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
	$error = array();

	$email = filter_var($_POST["email"], FILTER_SANITIZE_STRING);
	$pass = filter_var($_POST["pass"], FILTER_SANITIZE_STRING);
	$q = $con->prepare("SELECT * FROM users WHERE email = ? ");
	$q->execute(array($email));
	$result = $q->rowCount();
	$user = $q->fetch();
	if ($result == 1) {
		if (password_verify($pass, $user["pass"])) {
			setcookie("admin_name",   $user["name"],  time() + (20000  * 10000), "/");
			setcookie("admin_id",     $user["id"],  time() + (200000 * 10000), "/");
			setcookie("admin_group",  $user["admin"],  time() + (200000 * 10000), "/");
			header("location: index.php");
		} else {
			$_SESSION['OPRATION'] = 'error';
			$_SESSION['MESSAGE']  = "يوجد خطاء في كلمه المرور ";
		}
	} else {
		$_SESSION['OPRATION'] = 'error';
		$_SESSION['MESSAGE'] = " لايوجد مستخدم بهذا العنوان ";
	}
}



?>
<div class="container">
	<div class="form_container col-sm-5 offset-md-4 mt-5  p-4  ">
		<div class="custom_card m-0 login_form">
			<div class="text-center">
				<img class='login_img mt-4' src="<?php echo $img ?>profile.svg" alt="" class="login_profile">
			</div>
			<h3 class="text-center">login </h3>
			<!-- error fr login opration  -->
			<?php
			if (!empty($_SESSION['OPRATION'])) {
				if ($_SESSION['OPRATION'] == 'done') {
					echo '<div class="custom_success">' . $_SESSION['MESSAGE'] . '</div>';
				} else {
					echo '<div class="custom_danger">' . $_SESSION['MESSAGE'] . '</div>';
				}

				$_SESSION['OPRATION']  = null;
			}
			?>


			<!-- end section for error opration  -->
			<form class="form-horizontal  " action=<?php echo $_SERVER["PHP_SELF"]; ?> method="post">

				<div class="form-group form-group-lg mt-5">

					<lable class="control-lable col-sm-2">email:</lable>
					<div class=" input_container">
						<input type="email" placeholder="enter your email" class=form-control name=email required>
					</div>
					<h6><?php if (isset($_SESSION["user"])) {
							echo $_SESSION["usererror"];
							$_SESSION["usererror"] = "";
						} ?></h6>
				</div>
				<div class=" form-group-lg">
					<lable class="control-lable col-sm-2 ">password:</lable>
					<div class=" input_container">
						<input type="text" placeholder="enter your pass word" class="form-control" name=pass>
					</div>
					<h6><?php if (isset($_SESSION["pwerror"])) {
							echo $_SESSION["pwerror"];
							$_SESSION["pwerror"] = "";
						} ?></h6>
				</div>
				<div class="margin_bottom">
					<input type="submit" class="btn login_btn  bg_main btn-login btn-sm mt-3 mb-2" name="send"
						value='login' />
				</div>
				<h6 class="mt-3"><a href="#">did you forget password</a></h6>
				<h6><a href="sing.php">i dont have acount</a></h6>
			</form>
		</div>
	</div>
</div>