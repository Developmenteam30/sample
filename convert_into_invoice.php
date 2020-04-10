<?php
include('db.php');
$id = $_GET['id'];
$sql = "INSERT INTO `transaction` (`entry_type`, `cat_type`, `name`, `name_id`, `so_po_no`, `date`, `payment_term`, `transaction_number`, `notes`, `subtotal`, `disc_rate`, `disc_amount`, `discount_account`, `vat`, `total`, `total_no_vat`, `due_amt`, `due_date`, `category`, `status`, `lock`, `company_email`) SELECT 'create purchase invoice', 'purchase invoice', `name`, `name_id`, `so_po_no`, `date`, `payment_term`, `transaction_number`, `notes`, `subtotal`, `disc_rate`, `disc_amount`, `discount_account`, `vat`, `total`, `total_no_vat`, `total`, `time_period`, `category`, 'delivered', '1', `company_email` FROM `transaction` WHERE id = '$id'";
if (mysqli_query($conn, $sql)) {
  $last_id = mysqli_insert_id($conn);

$sqli = "INSERT INTO `purchase_item` (`date`, `item_name`, `item_id`, `item_category`, `item_description`, `item_quantity`, `price_rate`, `discount_rate`, `amount`, `vat`, `vat_amount`, `purchase_id`, `company_email`, `date_time`, `type`) SELECT `date`, `item_name`, `item_id`, `item_category`, `item_description`, `item_quantity`, `price_rate`, `discount_rate`, `amount`, `vat`, `vat_amount`, '$last_id', `company_email`, `date_time`, 'create purchase invoice' FROM `purchase_item` WHERE `purchase_id` = '$id'";
$conn->query($sqli);
$sqlw = "SELECT * FROm `purchase_item` WHERE `purchase_id` = '$id'";
$new_new = $conn->query($sqlw);
while($row = $new_new->fetch_assoc()){
$row_id = $row['id'];	
$product_id = $row['item_id'];
$sqla = "SELECT * FROm `items` WHERE `id` = '$product_id'";
$newa = $conn->query($sqla);
while($item_row = $newa->fetch_assoc()){
if($item_row['item_category']=='Inventory'){
$qty = $item_row['stock'] + $row['item_quantity'];
$cogs = $row['price_rate'] * $row['item_quantity'];
$asset_value = $item_row['asset_value'] + $cogs;
$weight_avg = $asset_value/$qty;
}
$inv_asset_id = $item_row['inv_asset'];
$cogs_id = $item_row['cogs'];
$exp_account_id = $item_row['exp_account'];
}
$sqli25="UPDATE `purchase_item` SET `asset_value` = '$asset_value', `qty` = '$qty', `cogs` = '$cogs', `weight_avg` = '$weight_avg', `exp_account_id` = '$exp_account_id', `income_account_id` = '$inc_account_id', `cogs_id` = '$cogs_id', `inventory_id` = '$inv_asset_id'  WHERE `id` = '$row_id'";
$conn->query(sqli25) ;
$sqli = "UPDATE `items` SET `stock` = '$qty', `asset_value` = '$asset_value', `weighted_price` = '$weight_avg' WHERE `id` = '$product_id' ";
$conn->query($sqli) ;
}
}
$sql = "UPDATE  `transaction` SET  `status` =  'delivered', `lock` =  '1' WHERE  `id` = '$id'";
$conn->query($sql);

$trns1="SELECT * FROM `transaction` WHERE `id` = '$last_id'";
$new_new = $conn->query($trns1) ;
while($row = $new_new->fetch_assoc()){
$name_id  = $row['name_id'];	
$total  = $row['total'];	
$discount_account  = $row['discount_account'];	
$disc_amount  = $row['disc_amount'];	
}
$ven="SELECT * FROM `vendor` WHERE `id` = '$name_id'";
$new_new = $conn->query($ven);
while($row = $new_new->fetch_assoc()){
$payable_account_id = $row['payable_account'];
}
/***********************************************************JOURNAL ENTRIES****************************************************/
///////////////////ACCOUNTS PAYABLE////////////////////
$sqli1="INSERT INTO `journal` (`date`, `number`, `account`, `credit`, `transaction_id`, `type`, `company_email`) VALUES ('$date', '$transaction_number', '$payable_account_id', '$total', '$last_id', 'Invoice', '$company_email')";
$conn->query($sqli1) ;
///////////////////ACCOUNTS PAYABLE////////////////////

///////////////////INVENTORY////////////////////
$sql_new = "SELECT SUM(cogs) AS `cost_of_gs`, `inventory_id` FROM `purchase_item` WHERE `purchase_id` = '$last_id' AND `item_category` = 'Inventory' GROUP BY `inventory_id`";
$new_new = $conn->query($sql_new) ;
while($row = $new_new->fetch_assoc()){
 $cost_of_gs = $row['cost_of_gs'];
  $inventory_id = $row['inventory_id'];
$sqli2="INSERT INTO `journal` (`date`, `number`, `account`, `debit`, `transaction_id`, `type`, `company_email`) VALUES ('$date', '$transaction_number', '$inventory_id', '$cost_of_gs', '$last_id', 'Invoice', '$company_email')";
$conn->query($sqli2) ;
}
///////////////////INVENTORY////////////////////

///////////////////DISCOUNT////////////////////
$sqli4="INSERT INTO `journal` (`date`, `number`, `account`, `credit`, `transaction_id`, `type`, `company_email`) VALUES ('$date', '$transaction_number', '$discount_account', '$disc_amount', '$last_id', 'Invoice', '$company_email')";
$conn->query($sqli4) ;
///////////////////DISCOUNT////////////////////


///////////////////VAT////////////////////
$sql_new = "SELECT SUM(vat_amount) AS `vat_amount_tot`, `vat` FROM `purchase_item` WHERE `purchase_id` = '$last_id' GROUP BY `vat`";
$new_new = $conn->query($sql_new) ;
while($row = $new_new->fetch_assoc()){
$vat_amount_tot = $row['vat_amount_tot'];
$vat = $row['vat'];
$sql = "SELECT * FROM `vat` WHERE `rate` = '$vat' AND `category` = 'purchase'";
$new = $conn->query($sql) ;
while($rowsd = $new->fetch_assoc()){
$vat_number_id = $rowsd['account'];
$sqli4="INSERT INTO `journal` (`date`, `number`, `account`, `debit`, `transaction_id`, `type`, `company_email`) VALUES ('$date', '$transaction_number', '$vat_number_id', '$vat_amount_tot', '$last_id', 'Invoice', '$company_email')";
$conn->query($sqli4) ;
}
}
///////////////////VAT////////////////////

///////////////////EXPENSE////////////////////
$sql_new = "SELECT SUM(amount) AS `amount_one`, `exp_account_id` FROM `purchase_item` WHERE `purchase_id` = '$last_id' AND `item_category` != 'Inventory' GROUP BY `cogs_id`";
$new_new = $conn->query($sql_new) ;
while($row = $new_new->fetch_assoc()){
  $amount_one = $row['amount_one'];
  $exp_account_ids = $row['exp_account_id'];
$sqli3="INSERT INTO `journal` (`date`, `number`, `account`, `debit`, `transaction_id`, `type`, `company_email`) VALUES ('$date', '$transaction_number', '$exp_account_ids', '$amount_one', '$last_id', 'Invoice', '$company_email')";
$conn->query($sqli3) ;
}
///////////////////EXPENSE////////////////////
/***********************************************************JOURNAL ENTRIES****************************************************/
echo "Converted Into Invoice";
?>