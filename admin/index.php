<?php
$title = 'dashboard';
include 'include/init.php';
Authuntication();
if (empty($_COOKIE['admin_id'])) {
}
//###################### well come the new user 

// t################# this is vribale to this table under the statical 
$articals = get_latest_articals();
$comments = get_latest_comments();


if (isset($_GET['welcome']) && $_GET['welcome'] == 1) {
?>

<script>
alert(' hello ' + $_COOKIE['admin_name'] + 'welcome in our controll panle')
</script>
<?php
}
// ################################# end welcome  #################
?>
<div class="content">
	<h3 class='text-right p-3'>dashboard</h3>
	<div class="row">
		<div class="col-sm-4">
			<div class="custom_card br_10 primary">
				<div class="mathmatic_div  ">
					<div class=" desc">
						<h1 class="mathmatic_div_h1 c_f"><?php echo ClacData('c_id', 'comments') ?></h1>
						<h3 class="mathmatic_div_h3 c_f">comments</h3>
					</div>
					<div class="icon overflow_hidden">
						<span class="material-icons c_f f_100">
							question_answer
						</span>
					</div>
				</div>
			</div>
		</div>
		<div class="col-sm-4">
			<div class="custom_card br_10 orange">
				<div class="mathmatic_div">
					<div class="desc">
						<h1 class="mathmatic_div_h1 c_f"><?php echo ClacData('a_id', 'articals') ?></h1>
						<h3 class="mathmatic_div_h3 c_f">articals</h3>
					</div>
					<div class="icon">
						<span class="material-icons c_f f_100">
							post_add
						</span>
					</div>
				</div>
			</div>
		</div>
		<div class="col-sm-4">
			<div class="custom_card br_10 success">
				<div class="mathmatic_div">
					<div class="desc">
						<h1 class="mathmatic_div_h1 c_f"><?php echo ClacData('id', 'users') ?></h1>
						<h3 class="mathmatic_div_h3 c_f">users</h3>
					</div>
					<div class="icon">
						<span class="material-icons c_f f_100">
							people
						</span>
					</div>
				</div>
			</div>
		</div>
	</div>

	<section class='chart_section'>
		<div class="row">
			<div class="col-md-6">
				<div class="custom_card">
					<div>
						<canvas id="myChartt" width="400" height="250"></canvas>
						<script>
						var ctx = document.getElementById('myChartt').getContext('2d');
						var myChart = new Chart(ctx, {
							type: 'line',
							data: {
								labels: ['Red', 'Blue', 'Purple', 'Orange', 'Red', 'Blue', 'Purple', 'Orange'],
								datasets: [{
									fill: true,

									label: 'comments',
									data: [20, 20, 29, 19, 15, 19, 18, 1],
									backgroundColor: [
										'rgba(75, 192, 192, 0.2)',
										'rgba(54, 162, 0, 0.2)',
										'rgba(255, 206, 86, 0.2)',
										'rgba(75, 192, 192, 0.2)',
										'rgba(153, 102, 255, 0.2)',
										'rgba(255, 159, 64, 0.2)'
									],
									borderColor: [
										'rgba(255, 99, 0, 1)',
										'rgba(54, 162, 0, 1)',
										'rgba(255, 206, 86, 1)',
										'rgba(75, 192, 192, 1)',
										'rgba(153, 102, 255, 1)',
										'rgba(255, 159, 64, 1)'
									],
									borderWidth: 3,

								}]
							},
							options: {
								scales: {
									y: {
										beginAtZero: false
									}
								}
							}
						});
						</script>
					</div>
				</div>
			</div>
			<div class="col-md-6">
				<div class="custom_card">
					<div>
						<canvas id="myChart" width="400" height="250"></canvas>
						<script>
						var ctx = document.getElementById('myChart').getContext('2d');
						var myChart = new Chart(ctx, {
							type: 'line',
							data: {
								labels: ['Red', 'Blue', 'Yellow', 'Green', 'Purple', 'Orange'],
								datasets: [{
									label: 'articals',
									fill: true,
									data: [12, 19, 3, 5, 2, 3, 20, 21],
									backgroundColor: [
										'rgba(54, 162, 0, 0.2)',
										'rgba(255, 206, 86, 0.2)',
										'rgba(75, 192, 192, 0.2)',
										'rgba(255, 99, 132, 0.2)',
										'rgba(153, 102, 255, 0.2)',
										'rgba(255, 159, 64, 0.2)'
									],
									borderColor: [
										'rgba(75, 192, 192, 1)',
										'rgba(54, 162, 0, 1)',
										'rgba(255, 206, 86, 1)',
										'rgba(75, 192, 192, 1)',
										'rgba(153, 102, 255, 1)',
										'rgba(255, 159, 64, 1)'
									],
									borderWidth: 3
								}]
							},
							options: {
								scales: {
									y: {
										beginAtZero: false
									}
								}
							}
						});
						</script>
					</div>
				</div>
			</div>
		</div>


	</section>

	<section class="latest_post">
		<div class="row">
			<div class="col-md-6">
				<h4>latest post</h4>
				<div class="custom_card">
					<div class="custom_table head_table">
						<div>name</div>
						<div> pic</div>
						<div>opration</div>
					</div>
					<hr>
					<?php
					if (count($articals)) {
						foreach ($articals as $artical) { ?>
					<div class="custom_table">
						<div><?php echo $artical['a_head'] ?></div>
						<div> <img src="../articals_photo/<?php echo $artical['a_photo'] ?>"
								style='max-width:50px ; max-height:50px;' alt=""></div>
						<div class=" text-center">
							<a href="articals.php?action=delete&id=<?php echo $artical['id'] ?>"
								class="opration_btn delete dashboard_btn">delete</a>
							<a href="articals.php?action=active&id=<?php echo $artical['id'] ?>"
								class="opration_btn active dashboard_btn">active</a>

						</div>
					</div>

					<?php	}
					} else {
						?>
					<div class="custom_table head_table">
						<div>no articals to activated </div>
						<div></div>
						<div class="text-center">
							<a href="articals.php" class="opration_btn primary_btn dashboard_btn">articals</a>
						</div>
					</div>
					<?php }
					?>
				</div>
			</div>
			<div class="col-md-6">
				<h4>latest comments</h4>
				<div class="custom_card">

					<div class="custom_table head_table">
						<div>name</div>
						<div> pic</div>
						<div>opration</div>
					</div>
					<hr>
					<?php
					if (count($comments) > 0) {
						foreach ($comments as $comment) { ?>
					<div class="custom_table">
						<div><?php echo $comment['c_content'] ?></div>
						<div> <img src="../articals_photo/<?php echo $comment['moham'] ?>"
								style='max-width:50px ; max-height:50px;' alt=""></div>
						<div class="text-center">
							<a href="comments.php?action=delete&id=<?php echo $comment['c_id'] ?>"
								class="opration_btn delete dashboard_btn">delete</a>
							<a href="comments.php?action=apply&id=<?php echo $comment['c_id'] ?>"
								class="opration_btn active dashboard_btn">active</a>
						</div>
					</div>

					<?php	}
					} else {
						?>
					<div class="custom_table head_table">
						<div>no comment to activated </div>
						<div></div>
						<div class="text-center">
							<a href="comments.php" class="opration_btn primary_btn dashboard_btn">comments</a>
						</div>
					</div>
					<?php }
					?>
				</div>
			</div>

		</div>
</div>
</section>