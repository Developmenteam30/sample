<?php
include("db.php");
$i = '0';
error_reporting(1);
$result = '';
$vat_id = $_REQUEST['vat_id'];
$first_date = $_REQUEST['start_date'];
$mode = $_REQUEST['mode'];
if($mode == "Monthly"){
for($i = '0'; $i<12; $i++){
$first_date = date("Y-m-d", strtotime($first_date));
$date = date("Y-m-d", strtotime($first_date. ' +1 month'));
$last_date = date("Y-m-d", strtotime($date. ' -1 days'));
$sql = "SELECT SUM(credit) AS `credit` FROM `journal` WHERE `account` = '$vat_id' AND `company_email` = '$company_email' AND `date` BETWEEN '$first_date' AND '$last_date'";
$new = $conn->query($sql);
while($row = $new->fetch_assoc()){
$result[$i] = $row;
$result[$i]['first_date'] = $first_date;
$result[$i]['last_date'] = $last_date;
$first_date = $date;
}
}
}elseif($mode == "Quarterly"){
for($i = '0'; $i<4; $i++){
$first_date = date("Y-m-d", strtotime($first_date));
$date = date("Y-m-d", strtotime($first_date. ' +3 month'));
$last_date = date("Y-m-d", strtotime($date. ' -1 days'));
$sql = "SELECT SUM(credit) AS `credit` FROM `journal` WHERE `account` = '$vat_id' AND `company_email` = '$company_email' AND `date` BETWEEN '$first_date' AND '$last_date'";
$new = $conn->query($sql);
while($row = $new->fetch_assoc()){
$result[$i] = $row;
$result[$i]['first_date'] = $first_date;
$result[$i]['last_date'] = $last_date;
$first_date = $date;
}
}	
}else{
for($i = '0'; $i<1; $i++){
$first_date = date("Y-m-d", strtotime($first_date));
$date = date("Y-m-d", strtotime($first_date. ' +12 month'));
$last_date = date("Y-m-d", strtotime($date. ' -1 days'));
$sql = "SELECT SUM(credit) AS `credit` FROM `journal` WHERE `account` = '$vat_id' AND `company_email` = '$company_email' AND `date` BETWEEN '$first_date' AND '$last_date'";
$new = $conn->query($sql);
while($row = $new->fetch_assoc()){
$result[$i] = $row;
$result[$i]['first_date'] = $first_date;
$result[$i]['last_date'] = $last_date;
$first_date = $date;
}
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
