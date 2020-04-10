<?php
include('db_config.php');
$cookie_name = "username";
if(isset($_SESSION[$cookie_name])){
$company_email = $_SESSION[$cookie_name];
}
if(isset($_GET['userid'])){
$company_email = $_GET['userid'];
}
if(isset($company_email)){
$s_c = "SELECT * FROM `company` WHERE `email` = '$company_email'";
$r_c = $conn->query($s_c);
$row_c = $r_c->fetch_assoc();
$ac_curr = $row_c['account_currenccy'];
}

?>