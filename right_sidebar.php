<?php
include("db.php");
$sql = "SELECT COUNT(*) AS `items` FROM `items` WHERE `company_email` = '$company_email'";
$new = $conn->query($sql);
while($row = $new->fetch_assoc()){
$result['items'] = $row['items'];
}
$sql = "SELECT COUNT(*) AS `users` FROM `user` WHERE `company_email` = '$company_email'";
$new = $conn->query($sql);
while($row = $new->fetch_assoc()){
$result['users'] = $row['users'];
}
$sql = "SELECT COUNT(*) AS `customers` FROM `customer` WHERE `company_email` = '$company_email'";
$new = $conn->query($sql);
while($row = $new->fetch_assoc()){
$result['customers'] = $row['customers'];
}
$sql = "SELECT COUNT(*) AS `vendors` FROM `vendor` WHERE `company_email` = '$company_email'";
$new = $conn->query($sql);
while($row = $new->fetch_assoc()){
$result['vendors'] = $row['vendors'];
}


if(isset($_GET['date_from'])){
$date_to = $_GET['date_from'];
$date_to = date('Y-m-d', strtotime($date_to));
}else{
$date_to = date('Y-m-d');
}
$tot = '0';

$sql = "SELECT * , (SELECT sum( total ) FROM transaction WHERE `date` <= '$date_to' AND `entry_type`='create sales invoice' AND `company_email` = '$company_email' AND `name_id` = t1.name_id)  AS invoice_total, ( SELECT sum( total ) FROM transaction WHERE `date` <= '$date_to' AND `entry_type`='create Customer Payment' AND `company_email` = '$company_email' AND `name_id` = t1.name_id) AS payment_total, (SELECT sum( total ) FROM transaction WHERE `date` <= '$date_to' AND `entry_type` ='create sales return' AND ( `cheque_no` = '' OR `cheque_no` = 'undefined') AND `company_email` = '$company_email' AND `name_id` = t1.name_id) AS return_total FROM transaction t1 WHERE `date` <= '$date_to' AND `company_email` = '$company_email' AND (`entry_type`='create sales invoice' OR `entry_type`='create Customer Payment' OR `entry_type`='create sales return') GROUP BY `name_id` ORDER BY `name` ASC  LIMIT 10";
$new = $conn->query($sql);
while($row = $new->fetch_assoc()){
$total = $row['invoice_total'] - ($row['payment_total']+$row['return_total']);
$tot += $total;
}
$result['recievables'] = $tot;

$tot = '0';
$sql = "SELECT * , (SELECT sum( total ) FROM transaction WHERE `date` < '$date_to' AND `entry_type`='create purchase invoice' AND `company_email` = '$company_email' AND `name_id` = t1.name_id)  AS invoice_total, ( SELECT sum( total ) FROM transaction WHERE `date` < '$date_to' AND `entry_type`='create vendor payment' AND `company_email` = '$company_email' AND `name_id` = t1.name_id) AS payment_total, (SELECT sum( total ) FROM transaction WHERE `date` < '$date_to' AND `entry_type` ='create purchase return' AND ( `cheque_no` = '' OR `cheque_no` = 'undefined') AND `company_email` = '$company_email' AND `name_id` = t1.name_id) AS return_total FROM transaction t1 WHERE `date` <= '$date_to' AND `company_email` = '$company_email' AND (`entry_type`='create purchase invoice' OR `entry_type`='create vendor payment' OR `entry_type` ='create purchase return') GROUP BY `name_id` ORDER  BY `name` ASC";
$new = $conn->query($sql);
while($row = $new->fetch_assoc()){
$total = $row['invoice_total'] - ($row['payment_total']+$row['return_total']);
$tot += $total;
}
$result['payble'] = $tot;



$response = $result;
header('Cache-Control: no-cache, must-revalidate');
header('Expires: Mon, 26 Jul 1997 05:00:00 GMT');
header('Content-type: application/json');
echo json_encode($response);

?>
