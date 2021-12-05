<?php
$title = ' نقره | المقالات ';
// this varibale to activeated nav link
$nav_id = 3;
include 'includes/init.php';

// $articals = get_all('articals');
$categories = get_all('categories');

//if i use the page normaly
$where = 'where a_status = 1 ';


// if i use page with  categories
if (isset($_GET['cat'])) {
	$where = 'where a_status = 1 and cat_id =' . $_GET['cat'];
}

// if is use this page to search 
if (isset($_GET['search'])) {
	$where = 'where  a_status = 1 and a_head like "%_' . $_GET['search'] . '_%" or a_content like "%_' . $_GET['search'] . '_%"';
}

$q = $con->prepare('SELECT * from articals ' . $where);
$q->execute();
$articals = $q->fetchall();
?>
<div class="custom_container">
	<div class="content">
		<h1 class='custom_head'><span>المقالات</span></h1>
		<div class="links">
			<ul class='category_links'>
				<?php foreach ($categories as $category) { ?>
				<li class='<?php $className = $category['id'] == $_GET['cat'] ? 'active' : ' not';
								echo $className  ?>'><a
						href="articals.php?cat=<?php echo $category['id'] ?>"><?php echo $category['name'] ?></a>
				</li>
				<?php } ?>
			</ul>
			<div class="search_box">
				<form action="articals.php" method="get">
					<div class="custom_search_input ">
						<input type="search" name='search' class="custom_input" placeholder="عن ماذا تبحث ؟" />
						<div class="count_articals text-center">
							<span><?php echo count($articals) ?></span>
						</div>
					</div>
				</form>
			</div>
		</div>
	</div>
	<div class="articals articlas_content">
		<?php foreach ($articals as $artical) { ?>
		<div class="artical_container">
			<div class="artical_data">
				<div class="artical_head">
					<h5>
						<a href="showArticals.php?post_id=<?php echo $artical['a_id'] ?>">
							<?php echo $artical['a_head'] ?>
						</a>
					</h5>
				</div>
				<div class="artical_date">
					<h5><?php echo $artical['a_date'] ?></h5>
				</div>
			</div>
			<div class="artical_img">
				<a href="showArticals.php?post_id=<?php echo $artical['a_id'] ?>">
					<img src="articals_photo/<?php echo $artical['a_photo'] ?>" alt=" not found now">
				</a>
			</div>
		</div>
		<hr>
		<?php } ?>
	</div>
</div>
<?php include 'includes/footer.php' ?>