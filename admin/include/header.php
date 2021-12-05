<?php
$new_title =	isset($title) ? $title :   'default title';
?>
<!DOCTYPE html>
<html lang="en">

<head>
	<meta charset="UTF-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<link rel="shortcut icon" href="design/img/face.png" type="image/x-icon">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<title><?php
			echo $new_title
			?>
	</title>

	<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
	<link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">

	<link rel="stylesheet" href="design/css/bootstrap.min.css">
	<link rel="stylesheet" href="design/css/custom_style.css">
	<link rel="stylesheet" href="design/css/all.min.css">
	<link rel="stylesheet" href="design/css/fontawesome.min.css">


</head>

<body>
	<?php
	if (!isset($noHeader)) {
		include 'navigation.php';
	}
	?>