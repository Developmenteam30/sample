<?php
include("db.php");
$id = $_GET['id'];
$sql = "DELETE FROM `transaction` WHERE id = '$id' AND `company_email` = '$company_email'";
$conn->query($sql);
$sql = "DELETE FROM `journal` WHERE transaction_id = '$id' AND `company_email` = '$company_email'";
$conn->query($sql);
$sql = "DELETE FROM `purchase_item` WHERE purchase_id = '$id' AND `company_email` = '$company_email'";
$conn->query($sql);
$sql = "DELETE FROM `sales_item` WHERE sales_id = '$id' AND `company_email` = '$company_email'";
$conn->query($sql);
$sql = "DELETE FROM `inventory_goods` WHERE goods_id = '$id' AND `company_email` = '$company_email'";
$conn->query($sql);
$sql = "DELETE FROM `bank_payment` WHERE transaction_id = '$id' AND `company_email` = '$company_email'";
$conn->query($sql);
$sql = "DELETE FROM `customer_payment_list` WHERE customer_payment_list_id = '$id' AND `company_email` = '$company_email'";
$conn->query($sql);
$sql = "DELETE FROM `vendor_payment_list` WHERE vendor_payment_list_id = '$id' AND `company_email` = '$company_email'";
$conn->query($sql);
echo "Transaction Deleted";
?>