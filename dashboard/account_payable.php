<?php
include("../db.php");
$i = '0';
error_reporting(1);
$result = '';

$sql = "SELECT * ,SUM(due_amt) AS `add` FROM `transaction` WHERE `entry_type` = 'create purchase invoice'";
$new = $conn->query($sql);
while($row = $new->fetch_assoc()){
$result = $row['add'];
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
