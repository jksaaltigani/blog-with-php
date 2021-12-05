<?php
$title = 'مدونه نقره البرمجيه';
include 'includes/init.php';

// this varibale to show latest post

$latest_post = get_order('created_at');
$viewed = get_order('view');
$users = get_all('users');

// start view 
?>
<div class="custom_container">
	<div class="content">
		<h2 class="custom_head"><span>نقره</span></h2>
	</div>
	<div class="row pb-5">
		<div class="col-md-6 text-center p-3 ">
			<img src="design/img/index.svg" class='index_img' alt="">
		</div>
		<div class="col-md-6">
			<p class='artical_content'>الويب يعني ثقافة المشاركة، لذلك نعتقد في مدونة توتومينا بأن المعلومة مهما كانت
				بسيطة لا يجب أن تبقى
				حكرا على أشخاص معينين بل يجب مشاركتها مع الآخرين وبذلك نرتقي بأنفسنا وبمحتوى لغتنا العربية العزيزة
				على الإنترنت.</p>
		</div>
	</div>
	<hr />
	<div class="pb-5">
		<h2 class="custom_head"><span> اخر التدوينات</span></h2>
		<div class="latest_post_container">
			<?php foreach ($latest_post as $post) { ?>
			<div class="latest_post">
				<div class="latest_post_data">
					<a href="showArticals.php?post_id=<?php echo  $post['a_id'] ?>" class="index_link">
						<?php echo  $post['a_head'] ?>
					</a>
				</div>
				<div class='latest_post_img'>
					<a href="showArticals.php?post_id=<?php echo  $post['a_id'] ?>" class="index_link">
						<img src="articals_photo/<?php echo  $post['a_photo'] ?>"
							style="max-width: 60px;  max-height:50px;margin:3px 0px 3px 10px" alt="not found">

					</a>
				</div>
			</div>
			<?php } ?>
		</div>
	</div>

	<hr />
	<div class="pb-5">
		<h2 class="custom_head"><span> الاكثر مشاهده </span></h2>
		<div class="latest_post_container">
			<?php foreach ($viewed as $post) { ?>
			<div class="latest_post">
				<div class="latest_post_data">
					<a href="showArticals.php?post_id=<?php echo  $post['a_id'] ?>" class="index_link">
						<?php echo  $post['a_head'] ?>
					</a>
				</div>
				<div class='latest_post_img'>
					<img src="articals_photo/<?php echo  $post['a_photo'] ?>"
						style="max-width: 60px;  max-height:50px;margin:3px 0px 3px 10px" alt="jksa altigani">
				</div>
			</div>
			<?php } ?>
		</div>
	</div>
	<hr />
	<div class="pb-5">
		<h2 class="custom_head"><span> المحررين </span></h2>
		<div class="auther_row">
			<?php foreach ($users as $user) {
				$user_photo =	empty($user['photo']) ? 'profile.svg' : $user['photo'];


			?>
			<div class="auth text-center">
				<img src="user_photo/<?php echo $user_photo ?>"
					style='max-width:100px ; max-height:100px; min-width:99px ; min-height:99px ; border-radius:50%'
					alt="">
				<h5 class='text-center mt-2'><?php echo $user['name'] ?></h5>
				<h5 class='text-center'>
					<?php $user_do = $user['admin']  == 1 ? ' مدير لي <a href="index.php">مدونه نقره</a>' : ' محرر لي <a href="index.php">مدونه نقره</a>';
						echo $user_do ?></h5>
			</div>
			<?php } ?>

		</div>
	</div>
</div>
<?php
include 'includes/footer.php';
?>