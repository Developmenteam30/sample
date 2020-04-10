<?php
include("db.php");
$i = '0';
error_reporting(1);
$result = '';


$sql = "SELECT * FROM `items` WHERE `company_email` = '$company_email'  ORDER BY `id` DESC LIMIT 1";

$new = $conn->query($sql);
while($row = $new->fetch_assoc()){
$result = $row['category'];
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
