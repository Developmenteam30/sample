<?php
include("db.php");
error_reporting(1);
$result = '';
$user_role = 'admin';
$sqls = "SELECT * FROM `access_level` WHERE  `company_email` = '$company_email' AND `user_role` = '$user_role' GROUP BY `option_type`";
$news = $conn->query($sqls);
while($rows = $news->fetch_assoc()){
$option_type = $rows['option_type'];
$result[$option_type] = $rows;
}
$response = $result;

header('Cache-Control: no-cache, must-revalidate');
header('Expires: Mon, 26 Jul 1997 05:00:00 GMT');
header('Content-type: application/json');
echo json_encode($response);

?>
