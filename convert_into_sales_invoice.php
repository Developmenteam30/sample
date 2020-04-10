<?php
include('db.php');
$id = $_GET['id'];
$sql = "INSERT INTO `transaction` (`entry_type`, `cat_type`, `name`, `name_id`, `so_po_no`, `date`, `payment_term`, `transaction_number`, `notes`, `subtotal`, `disc_rate`, `disc_amount`, `discount_account`, `vat`, `total`, `total_no_vat`, `due_amt`, `due_date`, `category`, `status`, `lock`, `company_email`) SELECT 'create sales invoice', 'purchase invoice', `name`, `name_id`, `so_po_no`, `date`, `payment_term`, `transaction_number`, `notes`, `subtotal`, `disc_rate`, `disc_amount`, `discount_account`, `vat`, `total`, `total_no_vat`, `total`, `time_period`, `category`, 'delivered', '1', `company_email` FROM `transaction` WHERE id = '$id'";
if (mysqli_query($conn, $sql)) {
  $last_id = mysqli_insert_id($conn);

$sqli = "INSERT INTO `sales_item` (`date`, `item_name`, `item_id`, `item_category`, `item_description`, `item_quantity`, `price_rate`, `discount_rate`, `amount`, `vat`, `vat_amount`, `sales_id`, `company_email`, `date_time`, `type`) SELECT `date`, `item_name`, `item_id`, `item_category`, `item_description`, `item_quantity`, `price_rate`, `discount_rate`, `amount`, `vat`, `vat_amount`, '$last_id', `company_email`, `date_time`, 'create sales invoice' FROM `sales_item` WHERE `sales_id` = '$id'";
$conn->query($sqli);
}
$sqlw = "SELECT * FROm `sales_item` WHERE `sales_id` = '$id'";
$new_new = $conn->query($sqlw);
while($row = $new_new->fetch_assoc()){
$row_id = $row['id'];	
$product_id = $row['item_id'];
$sqla = "SELECT * FROm `items` WHERE `id` = '$product_id'";
$newa = $conn->query($sqla);
while($item_row = $newa->fetch_assoc()){
if($row['item_category']=='Inventory'){
$qty = $item_row['stock'] - $row['item_quantity'];
$cogs = $item_row['weighted_price'] * $row['item_quantity'];
$asset_value = $item_row['asset_value'] - $cogs;
$weight_avg = $item_row['weighted_price'];
}
$inv_asset_id = $item_row['inv_asset'];
$cogs_id = $item_row['cogs'];
$exp_account_id = $item_row['exp_account'];
}
$sqli25="UPDATE `sales_item` SET `asset_value` = '$asset_value', `qty` = '$qty', `cogs` = '$cogs', `weight_avg` = '$weight_avg', `exp_account_id` = '$exp_account_id', `income_account_id` = '$inc_account_id', `cogs_id` = '$cogs_id', `inventory_id` = '$inv_asset_id'  WHERE `id` = '$row_id'";
$conn->query(sqli25) ;
$sqli = "UPDATE `items` SET `stock` = '$qty', `asset_value` = '$asset_value', `weighted_price` = '$weight_avg' WHERE `id` = '$product_id' ";
$conn->query($sqli) ;
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
$cust="SELECT * FROM `customer` WHERE `id` = '$name_id'";
$new_new = $conn->query($cust);
while($row = $new_new->fetch_assoc()){
$receivable_account_id = $row['payable_account'];
}
/***********************************************************JOURNAL ENTRIES****************************************************/
///////////////////ACCOUNT RECEIVABLE////////////////////
$sqli1="INSERT INTO `journal` (`date`, `number`, `account`, `debit`, `transaction_id`, `type`, `company_email`) VALUES ('$date', '$transaction_number', '$receivable_account_id', '$total', '$last_id', 'Invoice', '$company_email')";
$conn->query($sqli1) ;
///////////////////ACCOUNT RECEIVABLE////////////////////

///////////////////DISCOUNT////////////////////
$sqli2="INSERT INTO `journal` (`date`, `number`, `account`, `debit`, `transaction_id`, `type`, `company_email`) VALUES ('$date', '$transaction_number', '$discount_account', '$disc_amount', '$last_id', 'Invoice', '$company_email')";
$conn->query($sqli2) ;
///////////////////DISCOUNT////////////////////

///////////////////INCOME////////////////////
$sql_new = "SELECT SUM(amount) AS `amount_one`, `income_account_id` FROM `sales_item` WHERE `sales_id` = '$last_id' AND `item_category` = 'Inventory' GROUP BY `cogs_id`";
$new_new = $conn->query($sql_new) ;
while($row = $new_new->fetch_assoc()){
  $amount_one = $row['amount_one'];
  $income_account_id = $row['income_account_id'];
$sqli3="INSERT INTO `journal` (`date`, `number`, `account`, `credit`, `transaction_id`, `type`, `company_email`) VALUES ('$date', '$transaction_number', '$income_account_id', '$amount_one', '$last_id', 'Invoice', '$company_email')";
$conn->query($sqli3) ;
}
///////////////////INCOME////////////////////

///////////////////EXPENSE////////////////////
$sql_new = "SELECT SUM(amount) AS `amount_one`, `exp_account_id` FROM `sales_item` WHERE `sales_id` = '$last_id' AND `item_category` != 'Inventory' GROUP BY `cogs_id`";
$new_new = $conn->query($sql_new) ;
while($row = $new_new->fetch_assoc()){
  $amount_one = $row['amount_one'];
  $exp_account_ids = $row['exp_account_id'];
$sqli4="INSERT INTO `journal` (`date`, `number`, `account`, `credit`, `transaction_id`, `type`, `company_email`) VALUES ('$date', '$transaction_number', '$exp_account_ids', '$amount_one', '$last_id', 'Invoice', '$company_email')";
$conn->query($sqli4) ;
}
///////////////////EXPENSE////////////////////

///////////////////VAT////////////////////
$sql_new = "SELECT SUM(vat_amount) AS `vat_amount_tot`, `vat` FROM `sales_item` WHERE `sales_id` = '$last_id' GROUP BY `vat`";
$new_new = $conn->query($sql_new) ;
while($row = $new_new->fetch_assoc()){
$vat_amount_tot = $row['vat_amount_tot'];
$vat = $row['vat'];
$sql = "SELECT * FROM `vat` WHERE `rate` = '$vat' AND `category` = 'sales'";
$new = $conn->query($sql) ;
while($rowsd = $new->fetch_assoc()){
$vat_number_id = $rowsd['account'];
$sqli4="INSERT INTO `journal` (`date`, `number`, `account`, `credit`, `transaction_id`, `type`, `company_email`) VALUES ('$date', '$transaction_number', '$vat_number_id', '$vat_amount_tot', '$last_id', 'Invoice', '$company_email')";
$conn->query($sqli4) ;
}
}
///////////////////VAT////////////////////

///////////////////INVENTORY////////////////////
$sql_new = "SELECT SUM(cogs) AS `cost_of_gs`, `inventory_id` FROM `sales_item` WHERE `sales_id` = '$last_id' AND `item_category` = 'Inventory' GROUP BY `inventory_id`";
$new_new = $conn->query($sql_new) ;
while($row = $new_new->fetch_assoc()){
  $cost_of_gs = $row['cost_of_gs'];
  $inventory_id = $row['inventory_id'];
$sqli6="INSERT INTO `journal` (`date`, `number`, `account`, `credit`, `transaction_id`, `type`, `company_email`) VALUES ('$date', '$transaction_number', '$inventory_id', '$cost_of_gs', '$last_id', 'Invoice', '$company_email')";
$conn->query($sqli6) ;
}
///////////////////INVENTORY////////////////////

///////////////////COGS////////////////////
$sql_new = "SELECT SUM(cogs) AS `cost_of_gs`, `cogs_id` FROM `sales_item` WHERE `sales_id` = '$last_id' AND `item_category` = 'Inventory' GROUP BY `cogs_id`";
$new_new = $conn->query($sql_new) ;
while($row = $new_new->fetch_assoc()){
  $cost_of_gs = $row['cost_of_gs'];
  $cogs_id = $row['cogs_id'];
$sqli7="INSERT INTO `journal` (`date`, `number`, `account`, `debit`, `transaction_id`, `type`, `company_email`) VALUES ('$date', '$transaction_number', '$cogs_id', '$cost_of_gs', '$last_id', 'Invoice', '$company_email')";
$conn->query($sqli7) ;
}
///////////////////COGS////////////////////
/***********************************************************JOURNAL ENTRIES****************************************************/


echo "Converted Into Invoice";
?>