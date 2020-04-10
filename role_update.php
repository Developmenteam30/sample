<?php
include('db.php');

$id = $_POST['id'];
$name = $_POST['name'];
$value = $_POST['value'];
echo $sqli="UPDATE `access_level` SET `$name` = '$value' WHERE `company_email` = '$company_email' AND `id` = '$id'";
$conn->query($sqli);
?>