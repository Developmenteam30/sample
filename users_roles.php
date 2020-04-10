<?php
$i=0;
include("db.php");

if(isset($_GET['role'])){
$role = $_GET['role'];
$sqls = "SELECT * FROM `access_level` WHERE  `company_email` = '$company_email' AND `user_role` = '$role' GROUP BY `option_type`";
error_log($sqls);
$news = $conn->query($sqls);
while($rows = $news->fetch_assoc()){
$option_type = $rows['option_type'];
$result['access'][$role][$option_type] = $rows;
}
}else{
$sql = "SELECT `user_role` FROM `access_level` WHERE  `company_email` = '$company_email' GROUP BY `user_role`";
$new = $conn->query($sql);
while($row = $new->fetch_assoc()){
$roles = $row['user_role'];
$result['roles'][$i] = $roles;
$i++;
}
}
$response = $result;


header('Cache-Control: no-cache, must-revalidate');
header('Expires: Mon, 26 Jul 1997 05:00:00 GMT');

// headers to tell that result is JSON
header('Content-type: application/json');

// send the result now
echo json_encode($response);

?>