<?php
session_start();
include  'include/function.php';
Authuntication();
$action = isset($_GET['action']) ? $_GET['action'] : 'mange';
if ($action == 'mange') {
	$title = 'mange comments';
	include 'include/init.php';
	$q = $con->prepare('SELECT * from comments');
	$q->execute();
	$comments = $q->fetchall();
?>
<div class="content">
	<h3 class='text-right'>mange comments</h3>
	<h5 class="text-right">
		mange articals - <a href="index.php">dashboard</a>
	</h5>

	<div class="custom_card mt-5">
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
			<h3 class='text-right'>mange comments</h3>
			<div class="articals_table">
				<div class="custom_table_user table_head">
					<div> name</div>
					<div> pic</div>
					<div> writer</div>
					<div> opration</div>
				</div>
				<?php
					if (count($comments) > 0) {
						foreach ($comments as $comment) {
					?>
				<div class="custom_table_user ">
					<div> <?php echo $comment['c_content'] ?></div>
					<div> <img src="../articals_photo/<?php echo GET_IMG_OF_ARTICALS($comment['post_id']) ?>"
							alt="" style='max-width:100px ;max-height:100px;'>
					</div>
					<div> <?php echo $comment['c_user']; ?></div>
					<div>
						<a href="comments.php?action=apply&id=<?php echo $comment['c_id'] ?>"
							class="opration_btn edit">
							<?php echo $var  = $comment['c_status'] ? 'un applay' : 'applay'; ?>
						</a>
						<a href="comments.php?action=delete&id=<?php echo $comment['c_id'] ?>"
							class="opration_btn delete">delete</a>
						<a href="comments.php?action=show&id=<?php echo $comment['c_id'] ?>"
							class="opration_btn primary">show</a>


					</div>
					<?php
						}
					} else { ?>
					<div class="custom_table_user table_head">
						<div> we have now comments</div>
						<div> pic</div>
						<div> writer</div>
						<div> <a href="index.php" class="opration_btn primary">dashboard</a></div>
					</div>
					<?php
					}
						?>
				</div>
			</div>
		</div>
		</h5>
	</div>
</div>
<?php
} elseif ($action == 'show') {
} elseif ($action == 'delete') {
	if (isset($_GET['id'])) {

		include 'include/init.php';
		$id = $_GET['id'];
		$com = checkExist('c_id', 'comments', 'c_id =' . $id);
		if ($com) {
			$q = $con->prepare('DELETE  FROM comments where c_id = ?');
			$q->execute(array($id));
			$_SESSION['OPRATION'] = 'done';
			$_SESSION['MESSAGE']   = 'delete done successfuly successfuly ..';
			header('location: comments.php');
		} else {
			$_SESSION['OPRATION'] = 'error';
			$_SESSION['MESSAGE']   = 'some thing went worng <br>';
			header('location: comments.php');
		}
	} else {
		$_SESSION['OPRATION'] = 'error';
		$_SESSION['MESSAGE']   = 'some thing went worng <br>';
		header('location: comments.php');
	}
} elseif ($action == 'apply') {
	if (isset($_GET['id'])) {
		include 'include/init.php';
		$id = $_GET['id'];
		$com = checkExist('c_id', 'comments', 'c_id =' . $id);
		if ($com) {
			$q = $con->prepare('UPDATE comments SET c_status = ! c_status where c_id = ?');
			$q->execute(array($id));
			$_SESSION['OPRATION'] = 'done';
			$_SESSION['MESSAGE']   = 'the comment activated successfuly ..';
			header('location: comments.php');
		} else {
			$_SESSION['OPRATION'] = 'error';
			$_SESSION['MESSAGE']   = 'some thing went worng <br>';
			header('location: comments.php');
		}
	} else {
		$_SESSION['OPRATION'] = 'error';
		$_SESSION['MESSAGE']   = 'some thing went worng <br>';
		header('location: comments.php');
	}
}