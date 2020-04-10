<?php
include("db.php");
$actual_link = 'http://'.$_SERVER['HTTP_HOST'].$_SERVER["REQUEST_URI"];
$actual_link = str_replace("reports/excel","reports",$actual_link);
$url = basename($_SERVER['PHP_SELF']); 
if($url == 'vaersion_two_Vendor_Payments.php'){ $report_name = 'Vendor Wise Purchase Summary';
}elseif($url == 'vaersion_two_Item_Puchase.php'){ $report_name = 'Item Wise Purchase Summary';
}elseif($url == 'vaersion_two_Item_sales.php'){ $report_name = 'Item Wise Sales Summary';
}elseif($url == 'vaersion_two_customer_Payments.php'){ $report_name = 'Customer Wise Sales Summary';
}elseif($url == 'vaersion_two_ledger.php'){ $report_name = 'General Ledger Report';
}elseif($url == 'vaersion_two_journal.php'){ $report_name = 'Journal';
}elseif($url == 'report_purchase_summery.php'){ $report_name = 'Item Wise Purchase Summary';
}elseif($url == 'report_sales_summery.php'){ $report_name = 'Item Wise Sales Summary';
}else{
$report_name = $_GET['report_name'];
}
if(isset($_GET['end']) && isset($_GET['start'])){ $transactions = date('M d, Y' , strtotime($_GET['start']))." through ".date('M d, Y' , strtotime($_GET['end']));
}elseif(isset($_GET['end']) && !isset($_GET['start'])){ $transactions = "As of ".date('M d, Y' , strtotime($_GET['end']));
}else{ $transactions = "All Transactions";
}
$sqli = "SELECT * FROM `company` WHERE `email` = '$company_email'";
$news = $conn->query($sqli);
$rows = $news->fetch_assoc();
$account_currenccy = $rows['account_currenccy'];
$name = $rows['company_name'];


$date_time = date('h:i A');
$date = date('d/m/Y');
?>
<div class="text-muted">
<div class="col-md-12 align-center">
<h3><b><?php echo $name; ?></b></h3>
</div>
<div class="col-md-12">
<div class="col-md-3">
<b><?php echo $date_time; ?></b>
</div>
<div class="col-md-6 align-center">
<b><?php echo $report_name; ?></b>
</div>
</div>
<div class="col-md-12">
<div class="col-md-3">
<b><?php echo $date; ?></b>
</div>
<div class="col-md-6 align-center">
<b><?php echo  $transactions ; ?></b>
</div>
</div>
<div class="col-md-12">
<div class="col-md-3">
<b><?php echo 'Currency('.$account_currenccy.')'; ?></b>
</div>
</div>
</div>
