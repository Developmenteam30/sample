<?php
include("db.php");
$i = '0';
error_reporting(1);
$result = '';
if(isset($_GET['page'])){
	$page = ($_GET['page']-1)*9;
}else{
	$page = '0';
}

if(isset($_GET['filter'])){
	$filter = $_GET['filter'];
$sql = "SELECT * FROM `transaction` WHERE `entry_type` = 'create purchase order' AND `company_email` = '$company_email'  ORDER BY `$filter` ASC LIMIT 9 OFFSET $page";

}else{
$sql = "SELECT * FROM `transaction` WHERE `entry_type` = 'create purchase order' AND `company_email` = '$company_email'  ORDER BY `id` DESC LIMIT 9 OFFSET $page";
}

$new = $conn->query($sql);
while($row = $new->fetch_assoc()){
$result[$i] = $row;
$i++;
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