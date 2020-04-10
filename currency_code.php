<?php
include("db.php");
error_reporting(1);
$result = '';
$sql = "SELECT `account_currenccy` FROM `company` WHERE `email` = '$company_email'";
$new = $conn->query($sql);
while($row = $new->fetch_assoc()){
$result = $row['account_currenccy'];
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
