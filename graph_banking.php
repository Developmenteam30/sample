<?php 
include("db.php");
$date_to = date('Y-m').'-01';
$date = $date_to;
$diff = 'month';
if(isset($_GET['date_from'])){
$date_from = $_GET['date_from'];
$date_to = $_GET['date_to'];
$date_from = date('Y-m-d', strtotime($date_from));
$date_to = date('Y-m-d', strtotime($date_to));
}else{
$date_to = date('Y-m-d');
$date_from = date('Y-m-d', strtotime($date_from. ' -3 '.$diff.''));
}
$i=0;
$s = " CALL  PROC_FINANCIAL_GENLEDGER('$company_email', '$date_from', '$date_to', '', '', '', '')";
$sql = $conn->query($s);
$new = array();
$total = 0;
$sub_total = 0;
while($rows = $sql->fetch_assoc()){
  if($rows['group']=='Bank'){
    $account_id = $rows['account_id'];
    if(!isset($row[$account_id])){
      $row[$account_id] = array();
      $row[$account_id][1] = 0;
    }
    $row[$account_id][0] = $rows['accounts_name'];
    $row[$account_id][1] += $rows['Debit']-$rows['Credit'];
    $r[$i] = $rows;
    $i++;
  }
}
header('Cache-Control: no-cache, must-revalidate');
header('Expires: Mon, 26 Jul 1997 05:00:00 GMT');
header('Content-type: application/json');
echo json_encode($row);
?>