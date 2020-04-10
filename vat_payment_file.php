<?php
include("db.php");
$i = '0';
error_reporting(1);
$result = '';
if(isset($_GET['status'])){
$status = $_GET['status'];
$sql = "SELECT * FROM `vat_return_items` WHERE `status` = '$status' AND `company_email` = '$company_email'";

$new = $conn->query($sql);
while($row = $new->fetch_assoc()){
$result[$i] = $row;
$i++;
}
}else{
$sql = "SELECT * FROM `vat_return_items` AND `company_email` = '$company_email'";

$new = $conn->query($sql);
while($row = $new->fetch_assoc()){
$result[$i] = $row;
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
