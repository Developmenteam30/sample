<?php
include("db.php");
$i = '0';
error_reporting(1);
$result = '';
$id = $_GET['id'];
$sql = "SELECT * FROM `transaction` WHERE `company_email` = '$company_email' AND (`entry_type` = 'create vendor payment') AND `name_id` = '$id' AND `credit` !='0'";
$new = $conn->query($sql);
while($row = $new->fetch_assoc()){
$result['payments'][$i] = $row;
$i++;
}
$sql = "SELECT * FROM `transaction` WHERE `company_email` = '$company_email' AND (`entry_type` = 'create purchase invoice' OR (`entry_type` = 'Journal' AND `name` = 'vendor')) AND `name_id` = '$id' AND `due_amt` !='0'";
$new = $conn->query($sql);
while($row = $new->fetch_assoc()){
$result['invoice'][$i] = $row;
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
