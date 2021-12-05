<div class="top_header">
	<div class="info_option">
		<div class="information_side">
			<ul class="information_side_ul">
				<li class="d_none_mdm custom_padding">
					<span class="material-icons">
						edit_notifications
					</span>
				</li>
				<li class="d_none_md custom_padding">
					<span class="material-icons">
						markunread
					</span>
				</li>
				<li class="user_info">
					<h5>
						<img style='max-width:40px; max-height:40px; margin-right:10px '
							src="<?php echo $img ?>profile.svg" alt="" class="login_profile sing_up">
						<?php echo $_COOKIE['admin_name'] ?>
					</h5>
					<ul class="user_option">
						<li>
							<span class="material-icons user_option_icons">
								person
							</span>
							<a href="profile.php">profile</a>
						</li>
						<li>
							<a href="logout.php" class=""> logout</a>
						</li>
					</ul>
				</li>

			</ul>
		</div>
		<div class="option_side">
			<ul>
				<li>

				</li>
				<li>
					<span class="material-icons p-0">
						menu
					</span>
				</li>

				<li class='custom_padding f_30'>
					<span class="material-icons md-24">
						<i class="fa fa-meun"></i>
					</span>
				</li>
			</ul>
		</div>
	</div>
</div>
<div class="top_bar_navigation">
	<ul class="top_main_links">
		<li><span> <a href="index.php">dashboard</a></span></li>
		<li>
			<span>
				<a href="profile.php">my articlas</a>
			</span>
		</li>
		<li class='top_sub_links'>
			<span>articlas </span>
			<ul class='top_sub_links_ul' data-count='32'>
				<li><span><a href="articals.php"> show articals </a></span></li>
				<li><span><a href="articals.php?action=add">add articals</a> </span></li>
			</ul>
		</li>

		<li class='top_sub_links'>

			<span>comments </span>
			<ul class='top_sub_links_ul'>
				<li><span><a href="comments.php">show comments</a> </span></li>
			</ul>
		</li>
		<li class='top_sub_links'>

			<span>users </span>
			<ul class='top_sub_links_ul'>
				<li><span><a href="users.php"> show users </a></span></li>
				<li><span><a href="users.php?action=add">add users</a> </span></li>
			</ul>
		</li>
		<li class='top_sub_links'>

			<span>categories </span>
			<ul class='top_sub_links_ul'>
				<li><span><a href="categories.php"> show category </a></span></li>
				<li><span><a href="xategories.php?action=add">add category</a> </span></li>
			</ul>
		</li>

	</ul>
</div>
</div>


<div class="side_bar_navigation">
	<div class="logo">
		<h3><a href="index.php"><img src='design/img/logo.png' alt="" class="nav_img mr-5 ml-5"></a> </h3>
	</div>
	<ul class="main_links">
		<li>
			<div> <a href="index.php">
					<span class="material-icons">
						dashboard
					</span>
					dashboard</a></div>
		</li>
		<li>
			<div>
				<a href="profile.php">my articlas</a>
			</div>
		</li>
		<li class='sub_links'>
			<span class="material-icons custom_arrow">
				arrow_forward_ios
			</span>
			<div>articlas <span class="count_span orange"><?php echo ClacData('a_id', 'articals') ?></span></div>
			<ul class='sub_links_ul' data-count='32'>
				<li>
					<div><a href="articals.php"> show articals </a></div>
				</li>
				<li>
					<div><a href="articals.php?action=add">add articals</a> </div>
				</li>
			</ul>
		</li>

		<li class='sub_links'>
			<span class="material-icons custom_arrow">
				arrow_forward_ios
			</span>
			<div>comments <span class="count_span primary"><?php echo ClacData('c_id', 'comments') ?></span></div>
			<ul class='sub_links_ul'>
				<li>
					<div><a href="comments.php">show comments</a> </div>
				</li>
			</ul>
		</li>
		<li class='sub_links'>
			<span class="material-icons custom_arrow">
				arrow_forward_ios
			</span>
			<div>users <span class="count_span danger">0<?php echo ClacData('id', 'users') ?></span></div>
			<ul class='sub_links_ul'>
				<li>
					<div><a href="users.php"> show users </a></div>
				</li>
				<li>
					<div><a href="users.php?action=add">add users</a> </div>
				</li>
			</ul>
		</li>
		<li class='sub_links'>
			<span class="material-icons custom_arrow">
				arrow_forward_ios
			</span>
			<div>categories <span
					class="count_span success">0<?php echo ClacData('id', 'categories') ?></span></span>
			</div>
			<ul class='sub_links_ul'>
				<li>
					<div><a href="categories.php"> show category </a></div>
				</li>
				<li>
					<div><a href="categories.php?action=add">add category</a> </div>
				</li>
			</ul>
		</li>

	</ul>
</div>