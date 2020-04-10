<?php
include("db.php");
$date_to = date('Y-m-d');
//error_reporting(1);
$result = array();
$id = $_GET['id'];
$end = $_REQUEST['end'];
$start = $_REQUEST['start'];
$sql = "SELECT * FROM `customer` WHERE `company_email` = '$company_email' AND `id` = '$id'  ORDER BY `id` ASC";
$new = $conn->query($sql);
while($row = $new->fetch_assoc()){
$result = $row;
	$ias = $row['opening_balance'];
	$total = $ias;
$sql_one = "SELECT * , (SELECT sum( total ) FROM transaction WHERE `date` <= '$date_to' AND `entry_type`='create sales invoice' AND `company_email` = '$company_email' AND `name_id` = t1.name_id)  AS invoice_total, ( SELECT sum( total ) FROM transaction WHERE `date` <= '$date_to' AND `entry_type`='create Customer Payment' AND `company_email` = '$company_email' AND `name_id` = t1.name_id) AS payment_total, (SELECT sum( total ) FROM transaction WHERE `date` <= '$date_to' AND `entry_type` ='create sales return' AND ( `cheque_no` = '' OR `cheque_no` = 'undefined') AND `company_email` = '$company_email' AND `name_id` = t1.name_id) AS return_total FROM transaction t1 WHERE `date` <= '$date_to' AND `name_id` = '$id' AND `company_email` = '$company_email' AND (`entry_type`='create sales invoice' OR `entry_type`='create Customer Payment' OR `entry_type`='create sales return') GROUP BY `name_id` ORDER BY `name` ASC ";

$new_one = $conn->query($sql_one);
while($row_one = $new_one->fetch_assoc()){
$name = $row_one['name'];
$total += $row_one['invoice_total'] - ($row_one['payment_total']+$row_one['return_total']);
}
$result['outstanding'] = number_format($total, 2);
}
$i='0';
	$type = 'create Customer Payment';
$sql = "SELECT * FROM `transaction` WHERE `entry_type` = '$type' AND `company_email` = '$company_email' AND `name_id` = '$id' LIMIT 25";
$new = $conn->query($sql);
while($row = $new->fetch_assoc()){
$result['customer_Payments'][$i] = $row;
$i++;
}

$one = "http://more-acc.com//account//upload//vaersion_two_customer_aging.php?id=".$id."&userid=".$company_email."&name=".urlencode($name);
$result['customer_aging'] = file_get_contents($one);

$result['customer_Account'] = file_get_contents("http://more-acc.com//account//upload//vaersion_two_customer_Payments.php?start=".urlencode($start)."&end=".urlencode($end)."&id=".$id."&userid=".$company_email."&name=".urlencode($name));
$result['Item_sales'] = file_get_contents("http://more-acc.com//account/upload/vaersion_two_Item_sales.php?start=".urlencode($start)."&end=".urlencode($end)."&id=".$id."&userid=".$company_email."&name=".urlencode($name));
$result['Customer_payment_header'] = file_get_contents("http://more-acc.com//account//upload//header.php?start=".urlencode($start)."&end=".urlencode($end)."&id=".$id."&userid=".$company_email."&report_name=".urlencode("Customer Payment History"));





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