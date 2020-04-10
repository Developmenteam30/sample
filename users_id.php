<?php
include("db.php");
$i = '0';
error_reporting(1);
$result = '';

if(isset($_GET['u_id'])){
	$u_id = $_GET['u_id'];
$sql = "SELECT * FROM `user` WHERE `id` = '$u_id'";
$new = $conn->query($sql);
while($row = $new->fetch_assoc()){
$result = $row;
$j='0';
$sqli = "SELECT `user_role` FROM `access_level` WHERE `company_email` = '$company_email' GROUP BY `user_role`";
$news = $conn->query($sqli);
while($rows = $news->fetch_assoc()){
$result['user_roles'][$j] = $rows['user_role'];
$j++;
}
$i++;
}
}
$response = $result;
//	print_r($row); 


// Collect what you need in the $data variable.
// headers for not caching the results
header('Cache-Control: no-cache, must-revalidate');
header('Expires: Mon, 26 Jul 1997 05:00:00 GMT');

// headers to tell that result is JSON
header('Content-type: application/json');

// send the result now
echo json_encode($response);

?>