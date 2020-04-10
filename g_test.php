<?php
include("db.php");
 header('Access-Control-Allow-Origin: *');  
$i = '0';
if(isset($_GET['end'])){
$date_from =  date('Y-m-d', strtotime($_GET['start']));
$date_to =  date('Y-m-d', strtotime($_GET['end']));
}else{
$date_to = date('Y-m-d');
$date_from  = date('Y-m-d', strtotime($date_to. ' -180 days'));
}
$total_balance = '0';
$sqlsa = $conn->query("SELECT * FROM `customer` WHERE `company_email` = '$company_email'");
while ($r = $sqlsa->fetch_assoc()) {
$id = $r['id'];
$ias = $r['opening_balance'];
$total = $ias;
$sql_one = "SELECT * , (SELECT sum( total ) FROM transaction WHERE `date` <= '$date_to' AND `entry_type`='create sales invoice' AND `company_email` = '$company_email' AND `name_id` = t1.name_id)  AS invoice_total, ( SELECT sum( total ) FROM transaction WHERE `date` <= '$date_to' AND `entry_type`='create Customer Payment' AND `company_email` = '$company_email' AND `name_id` = t1.name_id) AS payment_total, (SELECT sum( total ) FROM transaction WHERE `date` <= '$date_to' AND `entry_type` ='create sales return' AND ( `cheque_no` = '' OR `cheque_no` = 'undefined') AND `company_email` = '$company_email' AND `name_id` = t1.name_id) AS return_total FROM transaction t1 WHERE `date` <= '$date_to' AND `company_email` = '$company_email' AND (`entry_type`='create sales invoice' OR `entry_type`='create Customer Payment' OR `entry_type`='create sales return') AND `name_id` = '$id' GROUP BY `name_id` ORDER BY `name` ASC ";
$new_one = $conn->query($sql_one);
if($new_one->num_rows > 0){
  while($row_one = $new_one->fetch_assoc()){
  $id = $row_one['name_id'];
  $total += $row_one['invoice_total'] - ($row_one['payment_total']+$row_one['return_total']);
  $total_balance += $total;
  $result[$i][0] = $row_one['name'];
  $result[$i][1] = number_format($total, 2);
  $i++;
  } 
}else{
    if ($total != 0) {
      $total_balance += $total;
      $result[$i][0] =  $r['company_name'];
      $result[$i][1] = $total;
  $i++;
    }
}

}
header('Cache-Control: no-cache, must-revalidate');
header('Expires: Mon, 26 Jul 1997 05:00:00 GMT');
header('Content-type: application/json');
echo json_encode($result);
?>