<?php
if (isset($_GET['post_id'])) {
	$title = 'نقره | المقالات';
	include 'includes/init.php';
	$id = $_GET['post_id'];
	$artical_bool = checkExist('*', 'articals', 'a_id = ' . $id);
	if ($artical_bool) {
		$artical_indexed = checkExist('*', 'articals', 'a_id = ' . $id, true);
		$artical = $artical_indexed[0];

		$q = $con->prepare('UPDATE articals SET view = view + 1 WHERE a_id = ' . $artical['a_id']);
		$q->execute();

		$q2 = $con->prepare('select * from articals where a_status = 1 limit 4');
		$q2->execute();
		$other_artical = $q2->fetchAll();

		$tags = explode(' ', $artical['a_hint']);
		$user = checkExist('*', 'users', 'id = ' . $artical['a_user'], true);
		if ($user[0]['photo'] == null) {
			$user[0]['photo'] = 'profile.svg';
		}
		$artical_section = explode('...', $artical['a_content']);

?>
<div class="custom_container">
	<div class="content">
		<div class="artical_header">
			<div class="show_artical_data">
				<h3>
					<?php echo $artical['a_head']; ?>
				</h3>
				<h5><?php echo $artical['a_desc']	 ?></h5>
				<h5> <?php echo $artical['created_at']; ?> | <?php echo $artical['a_date']; ?></h5>
				<h5 class="tags">
					<ul class='tags_ul'>
						<?php foreach ($tags as $tag) { ?>
						<li>
							<a href="articals.php?search=<?php echo $tag ?>"><?php echo $tag ?></a>
						</li>
						<?php } ?>
					</ul>
				</h5>
			</div>
			<div class="show_artical_img">
				<img src="articals_photo/<?php echo $artical['a_photo']; ?>" alt="">
			</div>
		</div>
		<div class="content">
			<!-- /this i spost here  -->
			<?php foreach ($artical_section as $section) { ?>
			<p class="artical_content">
				<?php echo $section; ?>
			</p>
			<?php } ?>

			<!-- some articals  -->
			<div class="content">
				<h1 class="custom_head">
					<span>
						مواضيع ذات صلة
					</span>
				</h1>
				<div>
					<?php foreach ($other_artical as $post) { ?>
					<div class="latest_post">
						<div class="latest_post_data">
							<a href="showArticals.php?post_id=<?php echo  $post['a_id'] ?>" class="index_link">
								<?php echo  $post['a_head'] ?>
							</a>
						</div>
						<div class='latest_post_img'>
							<img src="articals_photo/<?php echo  $post['a_photo'] ?>"
								style="max-width: 60px;  max-height:50px;margin:3px 0px 3px 10px"
								alt="jksa altigani">
						</div>
					</div>
					<?php } ?>

				</div>

			</div>


		</div>

		<!-- user information  -->
		<div class="auther_data">

			<div class="auther_desc">
				<?php echo $user[0]['descr'] ?>
			</div>
			<div class="auther_img text-center">
				<img src="user_photo/<?php echo $user[0]['photo'] ?>" alt="" class="user_profile mb-1">
				<h5 class="text-center"><?php echo $user[0]['name'] ?></h5>
			</div>
		</div>
	</div>
</div>

</div>

<?php
	}
} else {
	header('location: index.php');
}
include 'includes/footer.php';