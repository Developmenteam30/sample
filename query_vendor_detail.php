<?php
include("db.php");
$i = '0';
error_reporting(1);
$result = '';

if(isset($_GET['id'])){
	$id = $_GET['id'];
$sql = "SELECT * FROM `vendor` WHERE `company_email` = '$company_email' AND `id` = '$id'  ORDER BY `id` ASC";
}elseif(isset($_REQUEST['name'])){
	$name = $_GET['name'];
$sql = "SELECT * FROM `vendor` WHERE `company_email` = '$company_email' AND `company_name` = '$name'  ORDER BY `id` ASC";
}

$new = $conn->query($sql);
while($row = $new->fetch_assoc()){
$result = $row;
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
