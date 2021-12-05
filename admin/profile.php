<?php
$title = 'profile';
include 'include/init.php';
$user_info = checkExist('*', 'users', 'id = ' . $_COOKIE['admin_id'], true);
$profile_img  = $user_info[0]['photo'] == null ? 'profile.svg' : $user_info[0]['photo'];
$action = isset($_GET['action']) ? $_GET['action'] : 'mange';
$q = $con->prepare('SELECT * FROM articals where a_user = ' . $_COOKIE['admin_id']);
$q->execute();
$user_post = $q->fetchall();
if ($action == 'mange') {
?>
<div class="content">
	<h3 class='text-right'>user profile</h3>
	<h5 class="text-right">
		user profile - <a href="index.php">dashboard</a>
	</h5>
	<div class="row">
		<div class="col-md-7">
			<div class="user_info_profile">
				<div class="blank_space">
					<div class="absolute_div">
						<img src="../user_photo/<?php echo $profile_img ?>" alt="" class>
						<h5 class='mt-3'><?php echo $user_info[0]['name'] ?></h5>
					</div>
				</div>
				<div class="user_info_desc mt-5 text-right">
					<div>
						<span>المهنه</span> : <?php echo $user_info[0]['job']   ?>
					</div>
					<div>
						<span>الوصف</span> : <?php echo $user_info[0]['descr']   ?>
					</div>
					<div>
						<span> الوظيفه</span> : <?php echo $user_info[0]['admin'] == 1 ? 'مدير' : 'محرر';   ?>
					</div>
					<div>
						<span> الحاله</span> : <?php echo $user_info[0]['active'] == 1 ? 'نشط' : 'غير نشط';   ?>
					</div>
					<div>
						<span> المقالات</span> : <?php echo $user_info[0]['articals'] ?>
					</div>
					<div>
						<span> تاريخ الانضمام</span> : <?php echo $user_info[0]['created_at'] ?>

					</div>
				</div>
			</div>
		</div>
		<div class="col-md-5">
			<div class="custom_card">
				<form action="profile.php?action=desc" method='POST'>
					<div class="m-1">
						<div class=" form-group-lg">
							<lable class="control-lable col-sm-2 ">your job:</lable>
							<div class=" input_container">
								<input type="text" placeholder="type some description" class="form-control"
									name=job>
							</div>
						</div>
					</div>
					<div class="m-1">
						<div class=" form-group-lg">
							<lable class="control-lable col-sm-2 ">some description:</lable>
							<div class=" input_container">
								<input type="text" placeholder="type some description or information about you"
									class="form-control" name=descr>
							</div>
						</div>
					</div>
					<div class="m-4">
						<button class="opration_btn success_btn"> save</button>
					</div>
				</form>
			</div>
			<div class="custom_card mt-5">
				<h5>change your profile</h5>
				<form action="profile.php?action=profile" method='POST' enctype="multipart/form-data">
					<div class="m-1">
						<div class=" form-group-lg">
							<lable class="control-lable col-sm-2 ">select pic:</lable>
							<div class=" input_container">
								<input type="file" class="form-control" name=photo>
							</div>
						</div>
					</div>
					<div class="m-4">
						<button class="opration_btn success_btn"> save</button>
					</div>
				</form>
			</div>
		</div>
		<div class="custom_card mt-5">
			<div class="articals_table">
				<div class="custom_table_user head_table">
					<div> name</div>
					<div> pic</div>
					<div> writer</div>
					<div> opration</div>
				</div>
				<?php if (count($user_post) > 0) { ?>
				<?php foreach ($user_post as $post) { ?>
				<div class="custom_table_user ">
					<div> <?php echo $post['a_head']; ?>
					</div>
					<div> <img src="../articals_photo/<?php echo $post['a_photo'];  ?>"
							alt="<?php echo $post['a_desc'] ?>" class='user_table_img_class'
							style='max-width:100px ;max-height:100px;'></div>
					<div> <?php echo (get_Wirter($post['a_user'])); ?></div>
					<div> <a href="articals.php?action=edit&id=<?php echo $post['a_id'] ?>"
							class="opration_btn edit">edit</a>
						<a href="articals.php?action=delete&id=<?php echo $post['a_id'] ?>"
							class="opration_btn delete">delete</a>
						<a href="articals.php?action=active&id=<?php echo $post['a_id'] ?>"
							class="opration_btn active">
							<?php echo $var  = $post['a_status'] ? 'un active' : 'active'; ?></a>
						<a href="articals.php?action=show&id=<?php echo $post['a_id'] ?>"
							class="opration_btn active">show</a>
					</div>
				</div>
				<?php } ?>
				<?php } else {	?>
				<div class="custom_table_user">
					<div> you are not have artical to show it </div>
					<div class="not_border"> </div>
					<div class="not_border"> </div>
					<div>
						<a href="articals.php?action=add" class="opration_btn active">add new</a>
					</div>
				</div>
				<?php } ?>
			</div>
		</div>
	</div>
</div>
</div>
<?php } elseif ($action == 'desc') {

	if ($_SERVER['REQUEST_METHOD'] == 'POST') {
		include 'include/init.php';
		$job = $_POST['job'];
		$descr = $_POST['descr'];
		$id = $_COOKIE['admin_id'];
		$q = $con->prepare('UPDATE users SET job= ? , descr = ? WHERE id = ?');
		$q->execute(array($job, $descr, $id));
		// header('location: profile.php');
		echo $massege . '<meta http-equiv="refresh" content="0 url=profile.php">';
	}
?>
<?php } elseif ($action == 'profile') {
	if ($_SERVER['REQUEST_METHOD'] == 'POST') {
		$photo = $_FILES["photo"];
		$a_date = date('Y - M - D');
		$PhotoName = $photo["name"];
		$PhotoType = $photo["type"];
		$PhotoTemp = $photo["tmp_name"];
		$PhotoSize = $photo["size"];

		(@$nameofpic = strtolower(end(explode(".", $PhotoName))));
		$new_pic_name = date('ymdis');
		$full_name_pic = $new_pic_name . '.' . $nameofpic;

		move_uploaded_file($PhotoTemp,  $_SERVER["DOCUMENT_ROOT"] . "/project/user_photo/" . $full_name_pic);

		$id = $_COOKIE['admin_id'];
		$q = $con->prepare('UPDATE users SET photo= ? WHERE id = ?');
		$q->execute(array($full_name_pic, $id));
		// header('location: profile.php');
		echo $massege . '<meta http-equiv="refresh" content="0 url=profile.php">';

		// header('location: profile.php');
	}
} ?>