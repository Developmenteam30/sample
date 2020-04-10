<?php
include("db.php");
$result = '';
$diff = 'month';
$date_to = date('Y-m').'-01';
$date = $date_to;
if(isset($_GET['date_from'])){
$date_from = $_GET['date_from'];
$date_to = $_GET['date_to'];
$date_from = date('Y-m-d', strtotime($date_from));
$date_to = date('Y-m-d', strtotime($date_to));
}else{
$date_to = date('Y-m-d');
$date_from = date('Y-m-d', strtotime($date_to. ' -6 '.$diff.''));
}
$i=0;
$tot = '0';
$sql = "SELECT `name`, `name_id`, `id`, (SELECT SUM(total) FROM `transaction` WHERE `name_id` = t1.name_id AND (`entry_type` = 'create sales invoice' OR `entry_type` = 'create sales Receipt') AND `company_email` = '$company_email' AND `date` BETWEEN '$date_from' AND '$date_to') AS `add`, (SELECT SUM(total) FROM `transaction` WHERE `name_id` = t1.name_id AND `entry_type` = 'create sales return' AND `company_email` = '$company_email' AND `date` BETWEEN '$date_from' AND '$date_to') AS `less` FROM `transaction` t1 WHERE (`entry_type` = 'create sales invoice' OR `entry_type` = 'create sales Receipt' OR `entry_type` = 'create sales return') AND `company_email` = '$company_email' AND `date` BETWEEN '$date_from' AND '$date_to' GROUP BY `name`";
$new = $conn->query($sql);
while($row = $new->fetch_assoc()){
  $id = $row['name_id'];
  $total = $row['add'] - $row['less'];
  $result[$i][0]=$row['name'];
  $result[$i][1]=$total;
  $i++;
  $tot += $total;
}
header('Cache-Control: no-cache, must-revalidate');
header('Expires: Mon, 26 Jul 1997 05:00:00 GMT');
header('Content-type: application/json');
echo json_encode($result);
?>