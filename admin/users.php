<?php
include 'include/function.php';
authuntication();

$action = isset($_GET['action']) ? $_GET['action'] : 'mange';
if ($action == 'mange') {
	$title = 'mange users';
	include 'include/init.php';
	$q = $con->prepare('SELECT * FROM users');
	$q->execute();
	$users = $q->fetchall();
?>
<div class="content">
	<h3 class='text-right'>mange users</h3>
	<h5 class="text-right">
		mange users - <a href="index.php">dashboard</a>
	</h5>
	<div class="custom_card">

		<div class="custom_headding_add">
			<h3>mange users</h3>
			<a href="articals.php?action=add" class="opration_btn active"> add new articals </a>
		</div>
		<div class="over_flow_scroll">
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
			<div class="articals_table">
				<div class="custom_table_user head_table">
					<div> name</div>
					<div> pic</div>
					<div> mobile</div>
					<div> opration</div>
				</div>
				<?php
					foreach ($users as $user) {
					?>
				<div class="custom_table_user ">
					<div> <?php echo $user['name'] ?></div>
					<div class="text-center"> <img style="max-width:60x ;max-height:60px;" src="../user_photo/"
							onerror="this.src= '../user_photo/profile.svg'" alt=""> </div>
					<div> <?php echo $user['mobile']; ?></div>
					<div>
						<a href="users.php?action=active&id=<?php echo $user['id'] ?>" class="opration_btn edit">
							<?php echo $var  = $user['active'] ? 'un active' : 'active'; ?>
						</a>
						<a href="users.php?action=delete&id=<?php echo $user['id'] ?>"
							class="opration_btn delete">delete</a>

					</div>
				</div>
				<?php

					} ?>
			</div>
		</div>
	</div>
	<?php
} elseif ($action == 'delete') {
	if (isset($_GET['id'])) {
		include 'include/init.php';
		$id = $_GET['id'];
		$com = checkExist('id', 'users', 'id =' . $id);
		if ($com) {
			$q = $con->prepare('DELETE  FROM users where id = ?');
			$q->execute(array($id));
			$_SESSION['OPRATION'] = 'done';
			$_SESSION['MESSAGE']   = 'delete done successfuly successfuly ..';
			header('location: users.php');
		} else {
			$_SESSION['OPRATION'] = 'error';
			$_SESSION['MESSAGE']   = 'some thing went worng <br>';
			header('location: users.php');
		}
	} else {
		$_SESSION['OPRATION'] = 'error';
		$_SESSION['MESSAGE']   = 'some thing went worng <br>';
		header('location: users.php');
	}
} elseif ($action == 'active') {
	if (isset($_GET['id'])) {

		include 'include/init.php';
		$id = $_GET['id'];
		$com = checkExist('id', 'users', 'id =' . $id);
		if ($com) {
			$q = $con->prepare('UPDATE users SET `active` = ! `active` where id = ?');
			$q->execute(array($id));
			$_SESSION['OPRATION'] = 'done';
			$_SESSION['MESSAGE']   = 'opration done successfuly ..';
			header('location: users.php');
		} else {
			$_SESSION['OPRATION'] = 'error';
			$_SESSION['MESSAGE']   = 'some thing went worng <br>';
			header('location: users.php');
		}
	} else {
		$_SESSION['OPRATION'] = 'error';
		$_SESSION['MESSAGE']   = 'some thing went worng <br>';
		header('location: users.php');
	}
}