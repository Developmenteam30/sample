<?php
include("db.php");
$i = '0';
error_reporting(1);
$result = '';

$status = $_GET['status'];
$id = $_GET['id'];
$sql = "UPDATE  `vat_return_items` SET  `status` =  '$status' WHERE  `id` ='$id'";
$new = $conn->query($sql) or die(mysqli_error());
if($new){
$response = "update";
}

if($status == 'refund'){
$sqli = "SELECT * FROM `vat_return_items` WHERE `id` = '$id'";
$news = $conn->query($sqli);
while ($row = $news->fetch_assoc()) {
$account = $row['account'];
$transaction_id = $row['transaction_id'];
$amount = $row['amount'];
}
$sqli = "SELECT * FROM `transaction` WHERE `id` = '$transaction_id'";
$news = $conn->query($sqli);
while ($row = $news->fetch_assoc()) {
$bank_id = $row['bank_id'];
$transaction_number = $row['transaction_number'];
}
///////////////////BANK////////////////////
$date = date('Y-m-d');
$sqli1="INSERT INTO `journal` (`date`, `number`, `account`, `credit`, `transaction_id`, `type`, `company_email`) VALUES ('$date', '$transaction_number', '$bank_id', '$amount', '$transaction_id', 'vat_payment', '$company_email')";
$conn->query($sqli1) ;
///////////////////BANK////////////////////
///////////////////VAT////////////////////
$sqli1="INSERT INTO `journal` (`date`, `number`, `account`, `debit`, `transaction_id`, `type`, `company_email`) VALUES ('$date', '$transaction_number', '$account', '$amount', '$transaction_id', 'vat_payment', '$company_email')";
$conn->query($sqli1) ;
///////////////////VAT////////////////////

}
if($status == 'refund'){
$sqli = "SELECT * FROM `vat_return_items` WHERE `id` = '$id'";
$news = $conn->query($sqli);
while ($row = $news->fetch_assoc()) {
	$s_date = $row['s_date'];
	$e_date = $row['e_date'];
}
$sqli = "UPDATE `transaction` SET `lock` = '1' WHERE `date` BETWEEN '$s_date' AND '$e_date'";
$conn->query($sqli);
}


// Collect what you need in the $data variable.
// headers for not caching the results
header('Cache-Control: no-cache, must-revalidate');
header('Expires: Mon, 26 Jul 1997 05:00:00 GMT');

// headers to tell that result is JSON
header('Content-type: application/json');

// send the result now
echo json_encode($response);

?>
