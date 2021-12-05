<?php
function checkExist($select, $form, $filed, $getdata = false)
{
	// the conection will be globl to use here 
	global $con;
	//conect with data 
	$check = $con->prepare(" SELECT $select FROM $form WHERE  $filed ");

	$check->execute();

	$row = $check->rowCount();
	$col = $check->fetchAll();
	if ($getdata == false) {
		return $row;
	} else {
		return $col;
	}
}


function get_Wirter($id)
{
	global $con;
	$q = $con->prepare('SELECT `name` from users WHERE id = ?');
	$q->execute(array($id));
	$name = $q->fetch();
	return $name['name'];
}

function GET_IMG_OF_ARTICALS($id)
{
	global $con;
	$q = $con->prepare('SELECT a_photo from articals WHERE a_id = ?');
	$q->execute(array($id));
	$photo = $q->fetch();
	return $photo['a_photo'];
}

function get_latest_articals()
{
	global $con;
	$q = $con->prepare('SELECT a_head , a_photo , a_id as id FROM articals where a_status = 0 ORDER BY `created_at` DESC  LIMIT 5 ');
	$q->execute(array());
	$row = $q->fetchall();
	return $row;
}

function get_latest_comments()
{
	global $con;
	$q = $con->prepare('SELECT  post_id , c_id , c_content FROM comments where c_status = 0 ORDER BY `created_at` DESC  LIMIT 5 ');
	$q->execute();
	$row = $q->fetchall();
	return $row;
}


// check if  user is authenticated or not 

function Authuntication()
{
	if (empty($_COOKIE['admin_id'])) {
		header('location: login.php');
	}
}
function get_all($from)
{
	global $con;
	$q = $con->prepare("SELECT * FROM   $from ");
	$q->execute();
	$reslut = $q->fetchAll();
	return $reslut;
}

function get_order($order)
{
	global $con;
	$q = $con->prepare("SELECT a_id , a_head , a_photo FROM articals where a_status = 1 ORDER BY $order DESC limit 5");
	$q->execute();
	return $q->fetchall();
}