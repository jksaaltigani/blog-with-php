<?php
$new_title = isset($title) ?  $title :  'defualt title';

?>
<!DOCTYPE html>

<html lang="en">

<head>
	<meta charset="UTF-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<title><?php echo  $new_title ?></title>
	<link rel="shortcut icon" href="design/img/fav.png" type="image/x-icon">
	<link rel="stylesheet" href="design/css/bootstrap.min.css">
	<link rel="stylesheet" href="design/css/custom_style.css">
	<link rel="preconnect" href="https://fonts.googleapis.com">
	<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
	<link href="https://fonts.googleapis.com/css2?family=Changa:wght@300&display=swap" rel="stylesheet">
	<link href="https://fonts.googleapis.com/css2?family=Cairo&display=swap" rel="stylesheet">
	<script src="design/index.js"></script>
</head>

<body>
	<?php include 'includes/navigation.php'; ?>