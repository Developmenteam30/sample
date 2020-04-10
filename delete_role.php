<?php 
include('db.php');
$name = $_POST['Name'];
$sql="DELETE FROM `access_level` WHERE `user_role` = '$name' AND `company_email` = '$company_email' AND `user_role` != 'admin'";
$conn->query($sql) or die(mysql_error()) ;
?>