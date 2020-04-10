<?php
include("db.php");
$date_to = date('Y-m-d');
error_reporting(1);
$result = '';
$id = $_GET['id'];
$end = $_REQUEST['end'];
$start = $_REQUEST['start'];
$sql = "SELECT * FROM `vendor` WHERE `company_email` = '$company_email' AND `status` = '' AND `id` = '$id'  ORDER BY `id` ASC";
$new = $conn->query($sql);
while($row = $new->fetch_assoc()){
	$result = $row;
	$ias = $row['opening_balance'];
	$total = $ias;
	$sql_one = "SELECT * , (SELECT sum( total ) FROM transaction WHERE `date` < '$date_to' AND `entry_type`='create purchase invoice' AND `company_email` = '$company_email' AND `name_id` = t1.name_id)  AS invoice_total, ( SELECT sum( total ) FROM transaction WHERE `date` < '$date_to' AND `entry_type`='create vendor payment' AND `company_email` = '$company_email' AND `name_id` = t1.name_id) AS payment_total, (SELECT sum( total ) FROM transaction WHERE `date` < '$date_to' AND `entry_type` ='create purchase return' AND ( `cheque_no` = '' OR `cheque_no` = 'undefined') AND `company_email` = '$company_email' AND `name_id` = t1.name_id) AS return_total FROM transaction t1 WHERE `date` <= '$date_to' AND `company_email` = '$company_email' AND (`entry_type`='create purchase invoice' OR `entry_type`='create vendor payment' OR `entry_type` ='create purchase return') AND `name_id` = '$id' GROUP BY `name_id` ORDER  BY `name` ASC ";
	$new_one = $conn->query($sql_one);
	if($new_one->num_rows > 0){
	  while($row_one = $new_one->fetch_assoc()){
	  $id = $row_one['name_id'];
	  $total += $row_one['invoice_total'] - ($row_one['payment_total']+$row_one['return_total']);
	  $total_balance += $total;
	  $add = $row_one['add'];
		$result['outstanding'] += $total;
		//$result['invoice_Count'] = $row_one['invoice_Count'];
	  $i++;
	  } 
	}else{
	  if ($total != 0) {
	  $total_balance += $total;
	  $result['outstanding'] = $total;
	  $i++;
	  }
	}
}

$i='0';
	$type = 'create vendor payment';
$sql = "SELECT * FROM `transaction` WHERE `entry_type` = '$type' AND `company_email` = '$company_email' AND `name_id` = '$id' LIMIT 25";
$new = $conn->query($sql);
while($row = $new->fetch_assoc()){
$result['Vendor_Payments'][$i] = $row;
$i++;
}

$result['Vendor_Account'] = file_get_contents("http://more-acc.com//account//upload//vaersion_two_Vendor_Payments.php?start=".urlencode($start)."&end=".urlencode($end)."&id=".$id."&userid=".$company_email."&name=".urlencode($name));
$result['Item_Puchase'] = file_get_contents("http://more-acc.com//account//upload//vaersion_two_Item_Puchase.php?start=".urlencode($start)."&end=".urlencode($end)."&id=".$id."&userid=".$company_email."&name=".urlencode($name));
$result['vendor_aging'] = file_get_contents("http://more-acc.com//account//upload//vaersion_two_Vendor_aging.php?start=".urlencode($start)."&end=".urlencode($end)."&id=".$id."&userid=".$company_email."&name=".urlencode($name));
$result['Vendor_payment_header'] = file_get_contents("http://more-acc.com//account//upload//header.php?start=".urlencode($start)."&end=".urlencode($end)."&id=".$id."&userid=".$company_email."&report_name=".urlencode("Vendor Payment History"));




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