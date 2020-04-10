<?php
include('db_config.php');
$cookie_name = "username";
if(isset($_SESSION[$cookie_name])){
$result['value'] = 'yes';
include("db.php");
$result['userid'] = $company_email;
$user_role = $_SESSION['role'];
$sqls = "SELECT * FROM `access_level` WHERE  `company_email` = '$company_email' AND `user_role` = '$user_role'";
$news = $conn->query($sqls);
while($rows = $news->fetch_assoc()){
$option_type = $rows['option_type'];
$result[$option_type] = $rows;
}
$sqls = "SELECT * FROM `company` WHERE  `company_email` = '$company_email'";
$news = $conn->query($sqls);
while($rows = $news->fetch_assoc()){
	$date = date('Y-m-d');
	$date = date('Y-m-d', strtotime($date. ' +1 month'));

$result['expiry_date'] = $rows['expiry_date'];
if(strtotime($date)>=strtotime($rows['expiry_date'])){
	$result['expiry_now'] = 'yes';
}
}

}else{
$result['value'] = 'not';
}
$response = $result;


header('Cache-Control: no-cache, must-revalidate');
header('Expires: Mon, 26 Jul 1997 05:00:00 GMT');

//headers to tell that result is JSON
header('Content-type: application/json');

// send the result now
echo json_encode($response);

?>