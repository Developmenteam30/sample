<?php
include("db.php");
$i = '0';
$total = '0';
$subtotal = '0';

if(isset($_GET['date_from'])){
$date_from = $_GET['date_from'];
$date_to = $_GET['date_to'];
$date_from = date('Y-m-d', strtotime($date_from));
$date_to = date('Y-m-d', strtotime($date_to));
}else{
$date_to = date('Y-m-d');
$date_from  = date('Y-m-d', strtotime($date_to. ' -180 days'));
}

$s = " CALL  PROC_FINANCIAL_PL('PROFIT', '$date_from', '$date_to', '$company_email')";
$sql = $conn->query($s);
$ia = 0;
$new = array();
$n = array();
while($row = $sql->fetch_assoc()){
    if($row['group'] == "Income"){
      $account_id = $row['group'];
      if(!isset($new[$account_id])){
        $new[$account_id] = array();
        $new[$account_id][1] = 0;
      }
        $income = $row['credit_tot'] - $row['debit_tot'];
        $new[$account_id][0] = $row['group'];
        $new[$account_id][1] += $income;
        $total += $income;
        $subtotal += $income;
    }
    if($row['group'] == "Cost of Goods Sold"){
      $account_id = $row['group'];
      if(!isset($new[$account_id])){
        $new[$account_id] = array();
        $new[$account_id][1] = 0;
      }
        $debit_tot = $row['debit_tot'];
        $credit_tot = $row['credit_tot'];
        $income = $debit_tot - $credit_tot;
        $new[$account_id][0] = $row['group'];
        $new[$account_id][1] += $income;
        $total -= $income;
        $subtotal += $income;
    }
    if($row['group'] == "Expenses"){
      $account_id = $row['group'];
      if(!isset($new[$account_id])){
        $new[$account_id] = array();
        $new[$account_id][1] = 0;
      }
        $debit_tot = $row['debit_tot'];
        $credit_tot = $row['credit_tot'];
        $income = $debit_tot - $credit_tot;
        $new[$account_id][0] = $row['group'];
        $new[$account_id][1] += $income;
        $total -= $income;
        $subtotal += $income;
    }
}
header('Cache-Control: no-cache, must-revalidate');
header('Expires: Mon, 26 Jul 1997 05:00:00 GMT');
header('Content-type: application/json');
echo json_encode($new);
?>