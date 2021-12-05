<?php
$action = isset($_GET['action']) ? $_GET['action'] : 'mange';
if ($action == 'mange') {
	include 'include/init.php';
	$q = $con->prepare('SELECT * FROM `categories`');
	$q->execute();
	$cats = $q->fetchall();
?>

<div class="content">
	<h3 class='text-right'>mange categories</h3>
	<h5 class="text-right">
		mange categories - <a href="index.php">dashboard</a>
	</h5>

	<div class="custom_card mt-5">
		<div class="custom_headding_add">
			<h3>categories post</h3>
			<a href="categories.php?action=add" class="opration_btn active"> add new category </a>
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
				<div class="custom_table_user table_head">
					<div> name</div>
					<div> pic</div>
					<div> writer</div>
					<div> opration</div>
				</div>
				<?php
					if (count($cats) > 0) {
						foreach ($cats as $cat) {
					?>
				<div class="custom_table_user ">
					<div> <?php echo $cat['name'] ?></div>
					<div> null</div>
					<div> </div>
					<div>
						<a href="categories.php?action=active&id=<?php echo $cat['id'] ?>"
							class="opration_btn edit">
							<?php echo $var  = $cat['active'] ? 'un activated' : 'activeated'; ?>
						</a>
						<a href="categories.php?action=delete&id=<?php echo $cat['id'] ?>"
							class="opration_btn delete">delete</a>
						<a href="categories.php?action=edit&id=<?php echo $cat['id'] ?>"
							class="opration_btn primary">edit</a>
					</div>
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
} elseif ($action == 'add') {
	include 'include/init.php';
?>
<div class="content">
	<h3 class='text-right'>add new articals</h3>
	<h5 class="text-right">
		add new articals - <a href="index.php">dashboard</a>
	</h5>
	<div class="custom_card">
		<div class="custom_headding_add">
			<h3>add new artical</h3>
			<a href="categories.php" class="opration_btn active"> show articals </a>
		</div>
		<form action="categories.php?action=insert" method="POST" enctype="multipart/form-data">
			<div class="row">
				<div class="col-md-6 mt-1">
					<div class=" form-group-lg">
						<lable class="control-lable col-sm-2 ">categories name:</lable>
						<div class=" input_container">
							<input type="text" placeholder="type yor head of post here" class="form-control"
								name=name>
						</div>

					</div>
				</div>
			</div>
			<div class="mt-3">
				<button class="opration_btn success_btn"> save</button>
				<button class="opration_btn danger_btn"> cancel</button>
			</div>
	</div>
	</form>
</div>

<?php } elseif ($action == 'insert') {
	include 'include/connect.php';
	if ($_SERVER["REQUEST_METHOD"] == "POST") {
		$name = filter_var($_POST["name"], FILTER_SANITIZE_STRING);
		$q = $con->prepare('INSERT INTO categories (`name`) VALUES (?)');
		$q->execute(array($name));
		$_SESSION['OPRATION'] = 'done';
		$_SESSION['MESSAGE'] = 'insert was done successfuly';
		header('location: categories.php');
	}
	$_SESSION['OPRATION'] = 'error';
	$_SESSION['MESSAGE'] = 'cant use that page directory';
	header('location: categories.php');

?>

<?php } elseif ($action == 'edit') {
	include 'include/init.php';
	if (isset($_GET['id'])) {
		$id = $_GET['id'];
		$cat = checkExist('*', 'categories', 'id =' . $id);
		if ($cat) {
			$cat_value_index = checkExist('*', 'categories', 'id =' . $id, true);
			$cat_value = $cat_value_index[0];
	?>
<div class="content">
	<h3 class='text-right'>edit new articals</h3>
	<h5 class="text-right">
		edit new articals - <a href="index.php">dashboard</a>
	</h5>
	<div class="custom_card">
		<div class="custom_headding_add">
			<h3>add new artical</h3>
			<a href="categories.php" class="opration_btn active"> show articals </a>
		</div>
		<form action="categories.php?action=update" method="POST" enctype="multipart/form-data">
			<div class="row">
				<input type="hidden" name="id" value='<?php echo $cat_value['id'] ?>'>
				<div class="col-md-6 mt-1">
					<div class=" form-group-lg">
						<lable class="control-lable col-sm-2 ">categories name:</lable>
						<div class=" input_container">
							<input type="text" placeholder="type yor head of post here" class="form-control"
								name=name value="<?php echo $cat_value['name'] ?>">
						</div>
					</div>
				</div>
			</div>
			<div class="mt-3">
				<button class="opration_btn success_btn"> save</button>
				<button class="opration_btn danger_btn"> cancel</button>
			</div>
	</div>
	</form>
</div>
<?php }
	} else {
		$_SESSION['OPRATION'] = 'error';
		$_SESSION['MESSAGE'] = 'some thing went worng';
		header('location: categories.php');
	}
} elseif ($action == 'update') {
	include 'include/connect.php';
	if ($_SERVER["REQUEST_METHOD"] == "POST") {
		$name = filter_var($_POST["name"], FILTER_SANITIZE_STRING);
		$id = filter_var($_POST["id"], FILTER_SANITIZE_NUMBER_INT);
		$q = $con->prepare('UPDATE  categories SET name = ?  WHERE id = ?');
		$q->execute(array($name, $id));
		$_SESSION['OPRATION'] = 'done';
		$_SESSION['MESSAGE'] = 'insert was done successfuly';
		header('location: categories.php');
	}
	$_SESSION['OPRATION'] = 'error';
	$_SESSION['MESSAGE'] = 'cant use that page directory';
	header('location: categories.php');

	?>


<?php } elseif ($action == 'delete') {
	if (isset($_GET['id'])) {
		include 'include/init.php';
		$id = $_GET['id'];
		$com = checkExist('id', 'categories', 'id =' . $id);
		if ($com) {
			$q = $con->prepare('DELETE  FROM categories where id = ?');
			$q->execute(array($id));
			$_SESSION['OPRATION'] = 'done';
			$_SESSION['MESSAGE']   = 'delete done successfuly  ..';
			echo $massege . '<meta http-equiv="refresh" content="0 url=categories.php">';
		} else {
			$_SESSION['OPRATION'] = 'error';
			$_SESSION['MESSAGE']   = 'some thing went worng <br>';
			echo $massege . '<meta http-equiv="refresh" content="0 url=categories.php">';
		}
	} else {
		$_SESSION['OPRATION'] = 'error';
		$_SESSION['MESSAGE']   = 'some thing went worng <br>';
		echo $massege . '<meta http-equiv="refresh" content="0 url=categories.php">';
	} ?>





<?php } elseif ($action == 'active') {
	if (isset($_GET['id'])) {
		include 'include/init.php';
		$id = $_GET['id'];
		$com = checkExist('id', 'categories', 'id =' . $id);
		if ($com) {
			$q = $con->prepare('UPDATE categories SET active = ! active where id = ?');
			$q->execute(array($id));
			$_SESSION['OPRATION'] = 'done';
			$_SESSION['MESSAGE']   = 'the comment activated successfuly ..';
			echo $massege . '<meta http-equiv="refresh" content="0 url=categories.php">';
		} else {
			$_SESSION['OPRATION'] = 'error';
			$_SESSION['MESSAGE']   = 'some thing went worng <br>';
			echo $massege . '<meta http-equiv="refresh" content="0 url=categories.php">';
		}
	} else {
		$_SESSION['OPRATION'] = 'error';
		$_SESSION['MESSAGE']   = 'some thing went worng <br>';
		echo $massege . '<meta http-equiv="refresh" content="0 url=categories.php">';
	} ?>
<?php } ?>