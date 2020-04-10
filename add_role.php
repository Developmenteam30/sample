<?php 
include('db.php');
$name = $_POST['roleName'];
$sql="INSERT INTO `access_level` (`user_role`, `company_email`, `option_type`) VALUES ('$name', '$company_email', 'read')";
$conn->query($sql) or die(mysql_error()) ;
$sql="INSERT INTO `access_level` (`user_role`, `company_email`, `option_type`) VALUES ('$name', '$company_email', 'write')";
$conn->query($sql) or die(mysql_error()) ;
$sql="INSERT INTO `access_level` (`user_role`, `company_email`, `option_type`) VALUES ('$name', '$company_email', 'edit')";
$conn->query($sql) or die(mysql_error()) ;
$sql="INSERT INTO `access_level` (`user_role`, `company_email`, `option_type`) VALUES ('$name', '$company_email', 'delete')";
$conn->query($sql) or die(mysql_error()) ;
?>