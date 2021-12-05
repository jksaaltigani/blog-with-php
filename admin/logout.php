<?php
setcookie("admin_name", '',  time() - 100, "/");
setcookie("admin_id",   '',  time() - 100, "/");
setcookie("admin_group", '',  time() - 100, "/");
header('location: login.php');