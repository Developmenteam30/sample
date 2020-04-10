<?php
include('db.php');
if(isset($_GET['do']) && $_GET['do'] != '1'){
	$do = $_GET['do'];
}else{
	$do = '2';
}

$result="CALL Company_D_Bakup('$company_email', '$do')";
$new = $conn->query($result) or die (mysqli_error());	

/*$result="DELETE FROM `transaction` WHERE company_email = '$company_email'";
$new = $conn->query($result) or die (mysqli_error());	
$result="DELETE FROM `journal` WHERE company_email = '$company_email'";
$new = $conn->query($result) or die (mysqli_error());	
$result="DELETE FROM `purchase_item` WHERE company_email = '$company_email'";
$new = $conn->query($result) or die (mysqli_error());	
$result="DELETE FROM `sales_item` WHERE company_email = '$company_email'";
$new = $conn->query($result) or die (mysqli_error());	
$result="DELETE FROM `bank_payment` WHERE company_email = '$company_email'";
$new = $conn->query($result) or die (mysqli_error());	
$result="DELETE FROM `customer_payment_list` WHERE company_email = '$company_email'";
$new = $conn->query($result) or die (mysqli_error());	
$result="DELETE FROM `vendor_payment_list` WHERE company_email = '$company_email'";
$new = $conn->query($result) or die (mysqli_error());	
$result="DELETE FROM `inventory_goods` WHERE company_email = '$company_email'";
$new = $conn->query($result) or die (mysqli_error());	
$result="DELETE FROM `items` WHERE `company_email` = '$company_email'";
$new = $conn->query($result) or die (mysqli_error());	
*/
//$result="UPDATE `items` SET `weighted_price` = `pr_price`, `stock` = '0', `asset_value` = '0' WHERE company_email = '$company_email'";
//$new = $conn->query($result) or die (mysqli_error());	

?>