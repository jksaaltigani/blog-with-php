<?php
session_start();

include  'include/function.php';
Authuntication();

$action =  isset($_GET["action"]) ? $_GET["action"] : "mange";

if ($action == 'mange') {
	$title = 'mange articals';
	include 'include/init.php';

	$q = $con->prepare('SELECT * FROM  articals ORDER BY a_id DESC');
	$q->execute();
	$posts = $q->fetchall();
?>
	<!-- start mange section -->
	<section class="content">
		<h3 class='text-right'>mange articals</h3>
		<h5 class="text-right">
			mange articals - <a href="index.php">dashboard</a>
		</h5>
		<div class="custom_card">
			<div class="over_flow_scroll">
				<!-- custom alert if danger or succusess message -->
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
				<!-- end custom message -->
				<div class="custom_headding_add">
					<h3>articals post</h3>
					<a href="articals.php?action=add" class="opration_btn active"> add new articals </a>
				</div>
				<div class="articals_table">
					<div class="custom_table_user head_table">
						<div> name</div>
						<div> pic</div>
						<div> writer</div>
						<div> opration</div>
					</div>
					<?php foreach ($posts as $post) { ?>
						<div class="custom_table_user ">
							<div>
								<?php echo $post['a_head']; ?>
							</div>
							<div>
								<img src="../articals_photo/<?php echo $post['a_photo'];  ?>" alt="<?php echo $post['a_desc'] ?>" class='user_table_img_class' style='max-width:100px ;max-height:100px;'>
							</div>
							<div>
								<?php echo (get_Wirter($post['a_user'])); ?></div>
							<div> <a href="articals.php?action=edit&id=<?php echo $post['a_id'] ?>" class="opration_btn edit">edit</a>
								<a href="articals.php?action=delete&id=<?php echo $post['a_id'] ?>" class="opration_btn delete">delete</a>
								<a href="articals.php?action=active&id=<?php echo $post['a_id'] ?>" class="opration_btn active">
									<?php echo $var  = $post['a_status'] ? 'un active' : 'active'; ?></a>
								<a href="../showArticals.php?action=show&post_id=<?php echo $post['a_id'] ?>" class="opration_btn active">show</a>
							</div>
						</div>
					<?php } ?>
				</div>
			</div>
	</section>
<?php
} elseif ($action == 'add') {
	$title = 'add new artical';
	include 'include/init.php';
	$q = $con->prepare('select * from categories where active = 1');
	$q->execute();
	$cats = $q->fetchall();
?>
	<div class="content">
		<h3 class='text-right'>add new articals</h3>
		<h5 class="text-right">
			add new articals - <a href="index.php">dashboard</a>
		</h5>
		<div class="custom_card">
			<div class="custom_headding_add">
				<h3>add new artical</h3>
				<a href="articals.php" class="opration_btn active"> show articals </a>
			</div>
			<form action="articals.php?action=insert" method="POST" enctype="multipart/form-data">
				<div class="row">
					<div class="col-md-6 mt-1">
						<div class=" form-group-lg">
							<lable class="control-lable col-sm-2 ">articals head:</lable>
							<div class=" input_container">
								<input type="text" placeholder="type yor head of post here" class="form-control" name=head>
							</div>
						</div>
					</div>
					<div class="col-md-6 mt-1">
						<div class=" form-group-lg">
							<lable class="control-lable col-sm-2 ">some description:</lable>
							<div class=" input_container">
								<input type="text" placeholder="type some description" class="form-control" name=descr>
							</div>
						</div>
					</div>
					<div class="col-md-6 mt-1">
						<div class=" form-group-lg">
							<lable class="control-lable col-sm-2 ">hinting word:</lable>
							<div class=" input_container">
								<input type="text" placeholder="type hinnting word to ease to get your post" class="form-control" name=hint>
							</div>

						</div>
					</div>
					<div class="col-md-6">
						<div class=" form-group-lg">
							<lable class="control-lable col-sm-2 ">artical photo:</lable>
							<div class=" input_container">
								<input type="file" placeholder="enter your pass word" class="form-control" name=photo>
							</div>
							<h6></h6>
						</div>
					</div>
					<div class="col-md-6">
						<lable class="control-lable col-sm-2 ">artical section:</lable>

						<select name="cat" id="" class='form-control'>
							<?php foreach ($cats as $cat) { ?>
								<option value="<?php echo $cat['id'] ?>">
									<?php echo $cat['name'] ?>
								</option>
							<?php  } ?>
						</select>

					</div>
					<div class="col-md-6">
						<div class=" form-group-lg">
							<lable class="control-lable col-sm-2 ">artical content:</lable>
							<div class=" input_container">
								<textarea name="content" class="form-control" rows="10">type your content here</textarea>
							</div>
							<h6></h6>
						</div>
					</div>
				</div>
				<div>
					<button class="opration_btn success_btn"> save</button>
					<button class="opration_btn danger_btn"> cancel</button>
				</div>
			</form>
		</div>
	</div>
	<?php
} elseif ($action == 'insert') {
	if ($_SERVER["REQUEST_METHOD"] == "POST") {
		include 'include/init.php';


		print_r($_POST);
		$name = filter_var($_POST["head"], FILTER_SANITIZE_STRING);
		$desc = filter_var($_POST["descr"], FILTER_SANITIZE_STRING);
		$hint = filter_var($_POST["hint"], FILTER_SANITIZE_STRING);
		$content = filter_var($_POST["content"], FILTER_SANITIZE_STRING);
		$cat_id = filter_var($_POST["cat"], FILTER_SANITIZE_NUMBER_INT);
		$id = $_COOKIE["admin_id"];
		$photo = $_FILES["photo"];

		$a_date = date('Y - M - D');
		$PhotoName = $photo["name"];
		$PhotoType = $photo["type"];
		$PhotoTemp = $photo["tmp_name"];
		$PhotoSize = $photo["size"];


		$aarayExtintion = array("jpg", "jpeg", "png", "svg");

		(@$nameofpic = strtolower(end(explode(".", $PhotoName))));
		$new_pic_name = date('ymdis');
		$full_name_pic = $new_pic_name . '.' . $nameofpic;

		move_uploaded_file($PhotoTemp,  $_SERVER["DOCUMENT_ROOT"] . "/project/articals_photo/" . $full_name_pic);


		// 	// ############################# start vaildation ###############

		$erro = array();
		if (empty($name)) {
			$erro[]  = '<div class="alert alert-danger"> post name can\'t be emty</div>';
		}
		if (empty($desc)) {
			$erro[]  = '<div class="alert alert-danger"> post content can\'t be emty</div>';
		}
		if (empty($desc)) {
			$erro[]  = '<div class="alert alert-danger"> post content can\'t be emty</div>';
		}
		######################### prirnt un error on screen ##################
		foreach ($erro as $err) {
			echo $err;
		}
		if (count($erro) == 0) {
			// 		// increse the user post in user table 
			$up = $con->prepare("UPDATE users SET articals = articals + 1 WHERE id = ?");
			$up->execute(array($_COOKIE["admin_id"]));

			##################################insert artical to database #################
			$q = $con->prepare("INSERT INTO articals (a_head ,  a_desc , a_hint  , a_content ,  a_photo,  a_user , cat_id , a_date )  VALUES  
				(? , ? , ? , ? , ? , ? , ? , ? )");
			$q->execute(array($name, $desc, $hint, $content, $full_name_pic,  $id, $cat_id, $a_date));
			$_SESSION['OPRATION'] = 'done';
			$_SESSION['MESSAGE'] = 'insert was done succuess';
			echo $massege . '<meta http-equiv="refresh" content="0 url=articals.php">';
		}
	} else {
		$_SESSION['OPRATION'] = 'error';
		$_SESSION['MESSAGE']   = 'cant use that page directly';
		echo '<meta http-equiv="refresh" content="0 url=articals.php">';
	}
} elseif ($action == 'edit') {
	include 'include/init.php';
	if (isset($_GET['id'])) {
		$post_id = filter_var($_GET['id'], FILTER_SANITIZE_NUMBER_INT);
		$Post_bool_value = checkExist('*', 'articals', 'a_id = ' . $post_id);
		if ($Post_bool_value) {
			//get the value of post from data base
			$Post_value = checkExist('*', 'articals', 'a_id = ' . $post_id, true);
			$Post = $Post_value[0];

	?>
			<div class="content">
				<h3 class='text-right'>add new articals</h3>
				<h5 class="text-right">
					add new articals - <a href="index.php">dashboard</a>
				</h5>
				<div class="custom_card">
					<div class="custom_headding_add">
						<h3>add new artical</h3>
						<a href="articals.php" class="opration_btn active"> show articals </a>
					</div>
					<form action="articals.php?action=update" method="POST" enctype="multipart/form-data">
						<div class="row">
							<input type="hidden" value='<?php echo $Post['a_id'] ?>' name='post_id'>
							<div class="col-md-6 mt-1">
								<div class=" form-group-lg">
									<lable class="control-lable col-sm-2 ">articals head:</lable>
									<div class=" input_container">
										<input type="text" class="form-control" name=head value='<?php echo $Post['a_head'] ?>'>
									</div>
								</div>
							</div>
							<div class="col-md-6 mt-1">
								<div class=" form-group-lg">
									<lable class="control-lable col-sm-2 ">some description:</lable>
									<div class=" input_container">
										<input type="text" value='<?php echo $Post['a_desc'] ?>' placeholder="type some description" class="form-control" name=descr>
									</div>
								</div>
							</div>
							<div class="col-md-6 mt-1">
								<div class=" form-group-lg">
									<lable class="control-lable col-sm-2 ">hinting word:</lable>
									<div class=" input_container">
										<input type="text" value='<?php echo $Post['a_hint'] ?>' placeholder="type hinnting word to ease to get your post" class="form-control" name=hint>
									</div>
								</div>
							</div>
						</div>
						<div class="row">
							<div class="col-md-6">
								<div class=" form-group-lg">
									<lable class="control-lable col-sm-2 ">artical content:</lable>
									<div class=" input_container">
										<textarea name="content" class="form-control" rows="10"><?php echo $Post['a_content'] ?> </textarea>
									</div>
								</div>
							</div>
							<div class="col-md-6">
								<div class=" form-group-lg">
									<img style="max-width: 300px; margin-top:30px;
						max-height:300px" src="../articals_photo/<?php echo $Post['a_photo'] ?>" alt="not found now">
								</div>
							</div>
							<div>
								<div class='m-1 ml-3 '>
									<button class="opration_btn success_btn"> save</button>
									<button class="opration_btn danger_btn"> cancel</button>
								</div>
							</div>
					</form>
				</div>
			</div>

			</div>

<?php	} else {
			$_SESSION['OPRATION'] = 'not';
			$_SESSION['MESSAGE'] = 'un error happened';
			header('location: articals.php');
		}
	} else {
		$_SESSION['OPRATION'] = 'not';
		$_SESSION['MESSAGE'] = 'cant use that page directly';
		echo $massege . '<meta http-equiv="refresh" content="0 url=articals.php">';
	}
} elseif ($action == 'update') {
	if ($_SERVER["REQUEST_METHOD"] == "POST") {
		include 'include/connect.php';
		$name = filter_var($_POST["head"], FILTER_SANITIZE_STRING);
		$desc = filter_var($_POST["descr"], FILTER_SANITIZE_STRING);
		$hint = filter_var($_POST["hint"], FILTER_SANITIZE_STRING);
		$content = filter_var($_POST["content"], FILTER_SANITIZE_STRING);
		$id = filter_var($_POST["post_id"], FILTER_SANITIZE_STRING);
		// ############################# start vaildation ###############
		$erro = array();
		if (empty($name)) {
			$erro[]  = '<div class="alert alert-danger"> post name can\'t be emty</div>';
		}
		if (empty($desc)) {
			$erro[]  = '<div class="alert alert-danger"> post content can\'t be emty</div>';
		}
		if (empty($desc)) {
			$erro[]  = '<div class="alert alert-danger"> post content can\'t be emty</div>';
		}
		######################### prirnt un error on screen ##################
		foreach ($erro as $err) {
			echo $err;
		}
		if (count($erro) == 0) {
			##################################insert artical to database #################

			$q = $con->prepare("UPDATE `articals` SET a_head  = ?, a_desc  = ?, a_hint = ? , a_content = ?    WHERE a_id = ?");
			$q->execute(array($name, $desc, $hint, $content,  $id));
			$_SESSION['OPRATION'] = 'done';
			$_SESSION['MESSAGE'] = 'update was done was done succuess';
			echo $massege . '<meta http-equiv="refresh" content="0 url=articals.php">';
		}
	} else {
		$_SESSION['OPRATION'] = 'error';
		$_SESSION['MESSAGE']   = 'un erro happend <br>' . $erro[0];
		echo $massege . '<meta http-equiv="refresh" content="0 url=articals.php">';
	}
} elseif ($action == 'delete') {
	if (isset($_GET['id'])) {
		include 'include/init.php';
		$post = checkExist('*', 'articals', $_GET['id']);
		if ($post) {
			$q  = $con->prepare('DELETE FROM articals where a_id = ?');
			$q->execute(array($_GET['id']));
			$_SESSION['OPRATION'] = 'done';
			$_SESSION['MESSAGE'] = 'delete  was done succuess';
			echo $massege . '<meta http-equiv="refresh" content="0 url=articals.php">';
		} else {
			$_SESSION['OPRATION'] = 'not';
			$_SESSION['MESSAGE'] = 'some thing went worng';
			echo $massege . '<meta http-equiv="refresh" content="0 url=articals.php">';
		}
	} else {
		$_SESSION['OPRATION'] = 'error';
		$_SESSION['MESSAGE']   = 'some thing went worng <br>';
		echo $massege . '<meta http-equiv="refresh" content="0 url=articals.php">';
	}
} elseif ($action == 'active') {
	if (isset($_GET['id'])) {
		include 'include/init.php';
		$post = checkExist('*', 'articals', $_GET['id']);
		if ($post) {
			$q  = $con->prepare('UPDATE articals SET a_status = ! a_status where a_id = ?');
			$q->execute(array($_GET['id']));
			$_SESSION['OPRATION'] = 'done';
			$_SESSION['MESSAGE'] = 'delete  was done succuess';
			echo $massege . '<meta http-equiv="refresh" content="0 url=articals.php">';
		} else {
			$_SESSION['OPRATION'] = 'not';
			$_SESSION['MESSAGE'] = 'some thing went worng';
			echo $massege . '<meta http-equiv="refresh" content="0 url=articals.php">';
		}
	} else {
		$_SESSION['OPRATION'] = 'error';
		$_SESSION['MESSAGE']   = 'some thing went worng <br>';
		echo $massege . '<meta http-equiv="refresh" content="0 url=articals.php">';
	}
}
