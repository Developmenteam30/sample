<?php
include('../db.php');
function arraytoarray($item_name){
$a = array();
foreach($item_name as $cur)
{
 array_push($a,$cur);
}
return $a;
}
function convert_to_array($object){
    $listing_data = json_decode($object);
    $json = json_encode($listing_data);
    return $array = json_decode($json, true);
}



/*********************************************************************************************/
/*********************************************************************************************
										create purchase order
*********************************************************************************************/
/*********************************************************************************************/
if(isset($_POST['entry_type']) && $_POST['entry_type'] =='create purchase order'){
$trnsction = json_decode($_POST['trnsction']);
$trnsction_array = (array) $trnsction;
$id = $trnsction_array['id'];
$name = $trnsction_array['vendor_name'];
$name_id = $trnsction_array['name_id'];
$so_po_no = $trnsction_array['so_po_no'];
$date = $trnsction_array['date'];
$date = date('Y-m-d', strtotime($date));
$payment_term = $trnsction_array['payment_term'];
$transaction_number = $trnsction_array['transaction_number'];
$notes = $trnsction_array['notes'];
$subtotal = $trnsction_array['subtotal'];
$disc_rate = $trnsction_array['disc_rate'];
$disc_amount = $trnsction_array['disc_amount'];
$discount_account = $trnsction_array['discount_account'];
$vatt = $trnsction_array['vat'];
$total = $trnsction_array['total'];
$time_period = $trnsction_array['time_period'];
$time_period = date('Y-m-d', strtotime($time_period));
$category = $trnsction_array['category'];
$delivery_status = $trnsction_array['delivery_status'];
$billing_status = $trnsction_array['billing_status'];


$items = json_decode($_POST['items']);
$items =  arraytoarray($items);



$sql="UPDATE `transaction`   SET `entry_type` = 'create purchase order', `cat_type` = 'purchase', `name` = '$name', `name_id` = '$name_id', `so_po_no` = '$so_po_no', `date` = '$date', `payment_term` = '$payment_term', `transaction_number` = '$transaction_number', `notes` = '$notes', `subtotal` = '$subtotal', `disc_rate` = '$disc_rate', `disc_amount` = '$disc_amount', `discount_account` = '$discount_account', `vat` = '$vatt', `total` = '$total', `time_period` = '$time_period', `category` = '$category', `company_email` = '$company_email'  WHERE `id` = '$id'" ;
 

if (mysqli_query($conn, $sql)) {

    //echo "New record created successfully. Last inserted ID is: " . $last_id;
$check_size = sizeof($items);
for($i=0; $i<$check_size; $i++ ){

$item_array =  (array) $items[$i];
$purchase_id = $item_array['id'];
$item_name = $item_array['item_name'];
$item_id = $item_array['item_id'];
$item_description = $item_array['item_description'];
$item_quantity = $item_array['item_quantity'];
$price_rate = $item_array['price_rate'];
$discount_rate = $item_array['discount_rate'];
$amount = $item_array['amount'];
$vat = $item_array['vat'];
$vat_id = $item_array['vat_id'];
$vat_amount = ($amount*$vat)/100; 
$sqli="UPDATE `purchase_item` SET `date` = '$date', `item_name` = '$item_name', `item_id` = '$item_id', `item_description` = '$item_description', `item_quantity` = '$item_quantity', `price_rate` = '$price_rate', `discount_rate`= '$discount_rate', `amount` =  '$amount', `vat` = '$vat', `vat_id` = '$vat_id', `vat_amount` = '$vat_amount', `company_email` = '$company_email', `type` = 'create purchase order'  WHERE `id` = '$purchase_id'" ;


$conn->query($sqli) ;

}

} else {
    echo "Error: " . $sql . "<br>" . mysqli_error($conn);
}

}

/*********************************************************************************************/
/*********************************************************************************************
										create vendor
*********************************************************************************************/
/*********************************************************************************************/
if(isset($_POST['entry_type']) && $_POST['entry_type'] =='Create vendor'){

$id = $_POST['id'];
$company_name = $_POST['company_name'];
$email = $_POST['email'];
$address = mysqli_real_escape_string($conn, $_POST['address']);
$city = $_POST['city'];
$state = $_POST['state'];
$country = $_POST['country'];
$contact_name = $_POST['contact_name'];
$phone = $_POST['phone'];
$mobile = $_POST['mobile'];
$tax_number = $_POST['tax_number'];
$payment_term = $_POST['payment_term'];
$vat = $_POST['vat'];
$vat_number = $_POST['vat_number'];
$vendor_code = $_POST['vendor_code'];
$payable_account = $_POST['payable_account'];
$notes = $_POST['notes'];
$opening_balance = $_POST['opening_balance'];

$result="UPDATE `vendor` SET `company_name` = '$company_name', `opening_balance` = '$opening_balance', `email` = '$email', `address` = '$address', `city` = '$city', `state` = '$state', `country` = '$country', `contact_name` = '$contact_name', `phone` = '$phone', `mobile` =  '$mobile', `tax_number` = '$tax_number', `payment_term` = '$payment_term', `vat` = '$vat', `vat_number` = '$vat_number', `vendor_code` = '$vendor_code', `payable_account` = '$payable_account', `notes` = '$notes', `company_email` = '$company_email' WHERE `id` = $id'" ;



//echo "<script>alert(".$name.");</script>";

$new = $conn->query($result) or die (mysqli_error());	
$vendor_opening_balance = $_POST['vendor_opening_balance'];
$opening_balance -= $vendor_opening_balance;
$date = date('Y-m-d');
  $sqls="INSERT INTO `transaction` (`entry_type`, `cat_type`, `total`, `date`, `company_email`, `transaction_number`) VALUES ('Journal', 'Journal', '$opening_balance', '$date', '$company_email', '')";

  if (mysqli_query($conn, $sqls)) {
    echo  $last_ids = mysqli_insert_id($conn);
    ///////////////////BANK////////////////////
    $sqlsa = $conn->query("SELECT * FROM `coa_list` WHERE `accounts_name` = 'Opening Balance Equity' AND `company_email` = '$company_email' LIMIT 1");
    $r = $sqlsa->fetch_assoc();
    $ias = $r['id'];
    if($opening_balance >= 0){
      $sqli2="INSERT INTO `journal` (`date`, `number`, `account`, `credit`, `transaction_id`, `type`, `company_email`) VALUES ('$date', '', '$payable_account', '$opening_balance', '$last_ids', 'Payment', '$company_email')";
      $conn->query($sqli2) ;
      $sqli2="INSERT INTO `journal` (`date`, `number`, `account`, `debit`, `transaction_id`, `type`, `company_email`) VALUES ('$date', '', '$ias', '$opening_balance', '$last_ids', 'Payment', '$company_email')";
      $conn->query($sqli2) ;
    }else{
      $sqli2="INSERT INTO `journal` (`date`, `number`, `account`, `debit`, `transaction_id`, `type`, `company_email`) VALUES ('$date', '', '$payable_account', '$opening_balance', '$last_ids', 'Payment', '$company_email')";
      $conn->query($sqli2) ;
      $sqli2="INSERT INTO `journal` (`date`, `number`, `account`, `credit`, `transaction_id`, `type`, `company_email`) VALUES ('$date', '', '$ias', '$opening_balance', '$last_ids', 'Payment', '$company_email')";
      $conn->query($sqli2) ;
    }
    ///////////////////BANK////////////////////
  }

} 

/*********************************************************************************************/
/*********************************************************************************************
                                        Create purchase Receipt
*********************************************************************************************/
/*********************************************************************************************/
if(isset($_POST['entry_type']) && $_POST['entry_type'] =='Create purchase Receipt'){
$trnsction = json_decode($_POST['trnsction']);
$trnsction_array = (array) $trnsction;


$id = $trnsction_array['id'];
$name = $trnsction_array['vendor_name'];
$name_id = $trnsction_array['name_id'];
$date = $trnsction_array['date'];
$date = date('Y-m-d', strtotime($date));

$transaction_number = $trnsction_array['transaction_number'];
$bank_id = $trnsction_array['bank_id'];
$cheque_no = $trnsction_array['cheque_no'];
$notes = $trnsction_array['notes'];
$subtotal = $trnsction_array['subtotal'];
$disc_rate = $trnsction_array['disc_rate'];
$disc_amount = $trnsction_array['disc_amount'];
$discount_account = $trnsction_array['discount_account'];
$vatt = $trnsction_array['vat'];
$total = $trnsction_array['total'];

$bank_total = $total;


$sqlv="SELECT * FROM `vendor` WHERE `id` = '$name_id'";
$newv=$conn->query($sqlv); 
while($rowv = $newv->fetch_assoc()){
$payable_account_id = $rowv['payable_account'];
}

$items = json_decode($_POST['items']);
$items =  arraytoarray($items);

$sql="UPDATE `transaction` SET `entry_type` = 'Create purchase Receipt', `cat_type` = 'purchase', `name` = '$name', `name_id` = '$name_id', `date` = '$date', `transaction_number` = '$transaction_number', `bank_id` = '$bank_id', `cheque_no` = '$cheque_no', `notes` = '$notes', `subtotal` = '$subtotal', `disc_rate` = '$disc_rate', `disc_amount` = '$disc_amount', `discount_account` = '$discount_account', `vat` = '$vatt', `total` = '$total', `company_email` = '$company_email' WHERE `id` = '$id'";


if (mysqli_query($conn, $sql)) {
$sql20="SELECT * FROM `purchase_item` WHERE `purchase_id` = '$id'";
$new20=$conn->query($sql20); 
while($row20 = $new20->fetch_assoc()){
$reverse_item_id = $row20['item_id'];
$sql21="SELECT * FROM `items` WHERE `id` = '$reverse_item_id'";
$new21=$conn->query($sql21); 
while($row21 = $new21->fetch_assoc()){
if($row21['category']=='Inventory'){
$reverse_qty = $row21['stock'] - $row20['item_quantity'];
$reverse_asset_value = $row21['asset_value'] - $row20['cogs'];
$reverse_weighted_price = $reverse_asset_value/$reverse_qty;
$sqli = "UPDATE `items` SET `stock` = '$reverse_qty', `asset_value` = '$reverse_asset_value', `weighted_price` = '$reverse_weighted_price' WHERE `id` = '$reverse_item_id' ";
$conn->query($sqli) ;
}
}
}
$conn->query("DELETE FROM `purchase_item` WHERE `purchase_id` = '$id'"); 
$check_size = sizeof($items);
for($i=0; $i<$check_size; $i++ ){

$item_array =  (array) $items[$i];
//$purchase_id = $item_array['id'];
$item_name = $item_array['item_name'];
$item_id = $item_array['item_id'];
$item_description = $item_array['item_description'];
$item_quantity = $item_array['item_quantity'];
$price_rate = $item_array['price_rate'];
$discount_rate = $item_array['discount_rate'];
$amount = $item_array['amount'];
$vat = $item_array['vat'];
$vat_id = $item_array['vat_id'];
$vat_amount = ($amount*$vat)/100; 

$sql21="SELECT * FROM `items` WHERE `id` = '$item_id'";
$new21=$conn->query($sql21); 
while($row21 = $new21->fetch_assoc()){
$type = $row21['category']; 
$cogs_id = $row21['cogs'];
$inv_asset_id = $row21['inv_asset'];
$inc_account_id = $row21['inc_account'];
$exp_account_id = $row21['exp_account'];
if($row21['category']=='Inventory'){
$qty = $row21['stock'] + $item_quantity;
$cogs = $price_rate * $item_quantity;
$asset_value = $row21['asset_value'] + $cogs;
$weight_avg = $asset_value/$qty;
}
}


$sqli="INSERT INTO `purchase_item` (`date` , `item_name`, `item_id`, `item_category`, `item_description`, `item_quantity`, `price_rate`, `discount_rate`, `amount`, `vat`, `vat_id`, `vat_amount`, `asset_value`, `qty`, `cogs`, `weight_avg`, `exp_account_id`, `income_account_id`, `cogs_id`, `inventory_id`, `company_email`, `type`, `purchase_id`) VALUES ('$date', '$item_name', '$item_id', '$type', '$item_description', '$item_quantity', '$price_rate', '$discount_rate', '$amount', '$vat', '$vat_id', '$vat_amount', '$asset_value', '$qty', '$cogs', '$weight_avg', '$exp_account_id', '$inc_account_id', '$cogs_id', '$inv_asset_id', '$company_email', 'Create purchase Receipt', '$id')" ;

$conn->query($sqli) ;
if($type=='Inventory'){
$sqli = "UPDATE `items` SET `stock` = '$qty', `asset_value` = '$asset_value', `weighted_price` = '$weight_avg' WHERE `id` = '$item_id' ";
$conn->query($sqli) ;
$cogs = '0';
$asset_value = '0';
$weight_avg = '0';
$qty = '0';
}

}

///////////////////*****************/////////////// DELETE JOURNAL///////////////////*****************///////////////
$sqli="DELETE FROM `journal` WHERE `transaction_id` = '$id'" ;
$conn->query($sqli) or die(mysqli_error());
///////////////////*****************/////////////// DELETE JOURNAL///////////////////*****************///////////////

/***********************************************************JOURNAL ENTRIES****************************************************/
///////////////////BANK/CASH////////////////////
$sqli1="INSERT INTO `journal` (`date`, `number`, `account`, `credit`, `transaction_id`, `type`, `company_email`) VALUES ('$date', '$transaction_number', '$bank_id', '$bank_total', '$id', 'Receipt', '$company_email')";
$conn->query($sqli1) ;
///////////////////BANK/CASH////////////////////

///////////////////ACCOUNTS PAYABLE////////////////////
$sqli1="INSERT INTO `journal` (`date`, `number`, `account`, `debit`, `transaction_id`, `type`, `company_email`) VALUES ('$date', '$transaction_number', '$payable_account_id', '$bank_total', '$id', 'Receipt', '$company_email')";
$conn->query($sqli1) ;
///////////////////ACCOUNTS PAYABLE////////////////////

///////////////////DISCOUNT////////////////////
$sqli4="INSERT INTO `journal` (`date`, `number`, `account`, `credit`, `transaction_id`, `type`, `company_email`) VALUES ('$date', '$transaction_number', '$discount_account', '$disc_amount', '$id', 'Receipt', '$company_email')";
$conn->query($sqli4) ;
///////////////////DISCOUNT////////////////////

///////////////////INVENTORY////////////////////
$sql_new = "SELECT SUM(cogs) AS `cost_of_gs`, `inventory_id` FROM `purchase_item` WHERE `purchase_id` = '$id' AND `item_category` = 'Inventory' GROUP BY `inventory_id`";
$new_new = $conn->query($sql_new) ;
while($row = $new_new->fetch_assoc()){
  $cost_of_gs = $row['cost_of_gs'];
  $inventory_id = $row['inventory_id'];
$sqli2="INSERT INTO `journal` (`date`, `number`, `account`, `debit`, `transaction_id`, `type`, `company_email`) VALUES ('$date',  '$transaction_number', '$inventory_id', '$cost_of_gs', '$id', 'Receipt', '$company_email')";
$conn->query($sqli2) ;
}
///////////////////INVENTORY////////////////////

///////////////////ACCOUNTS PAYABLE////////////////////
$sqli1="INSERT INTO `journal` (`date`, `number`, `account`, `credit`, `transaction_id`, `type`, `company_email`) VALUES ('$date', '$transaction_number', '$payable_account_id', '$cost_of_gs', '$id', 'Receipt', '$company_email')";
$conn->query($sqli1) ;
///////////////////ACCOUNTS PAYABLE////////////////////

///////////////////EXPENSE////////////////////
$sql_new = "SELECT SUM(amount) AS `amount_one`, `exp_account_id` FROM `purchase_item` WHERE `purchase_id` = '$id' AND `item_category` != 'Inventory' GROUP BY `cogs_id`";
$new_new = $conn->query($sql_new) ;
while($row = $new_new->fetch_assoc()){
  $amount_one = $row['amount_one'];
  $exp_account_ids = $row['exp_account_id'];
$sqli3="INSERT INTO `journal` (`date`, `number`, `account`, `debit`, `transaction_id`, `type`, `company_email`) VALUES ('$date', '$transaction_number', '$exp_account_ids', '$amount_one', '$id', 'Receipt', '$company_email')";
$conn->query($sqli3) ;
}
///////////////////EXPENSE////////////////////

///////////////////ACCOUNTS PAYABLE////////////////////
$sqli1="INSERT INTO `journal` (`date`, `number`, `account`, `credit`, `transaction_id`, `type`, `company_email`) VALUES ('$date', '$transaction_number', '$payable_account_id', '$amount_one', '$id', 'Receipt', '$company_email')";
$conn->query($sqli1) ;
///////////////////ACCOUNTS PAYABLE////////////////////

///////////////////VAT////////////////////
$sql_new = "SELECT SUM(vat_amount) AS `vat_amount_tot`, `vat_id` FROM `purchase_item` WHERE `purchase_id` = '$id' GROUP BY `vat_id`";
$new_new = $conn->query($sql_new) ;
while($row = $new_new->fetch_assoc()){
$vat_amount_tot = $row['vat_amount_tot'];
$vat_id = $row['vat_id'];
$sql = "SELECT * FROM `vat` WHERE `id` = '$vat_id' AND `category` = 'purchase' AND `company_email` = '$company_email'";
$new = $conn->query($sql) ;
while($rowsd = $new->fetch_assoc()){
$vat_number_id = $rowsd['account'];
$sqli4="INSERT INTO `journal` (`date`, `number`, `account`, `debit`, `transaction_id`, `type`, `company_email`) VALUES ('$date', '$transaction_number', '$vat_number_id', '$vat_amount_tot', '$id', 'Receipt', '$company_email')";
$conn->query($sqli4) ;
}
}
///////////////////VAT////////////////////

///////////////////ACCOUNTS PAYABLE////////////////////
$sqli1="INSERT INTO `journal` (`date`, `number`, `account`, `credit`, `transaction_id`, `type`, `company_email`) VALUES ('$date', '$transaction_number', '$payable_account_id', '$vatt', '$id', 'Receipt', '$company_email')";
$conn->query($sqli1) ;
///////////////////ACCOUNTS PAYABLE////////////////////

/***********************************************************JOURNAL ENTRIES****************************************************/

} else {
    echo "Error: " . $sql . "<br>" . mysqli_error($conn);
}
}

/*********************************************************************************************/
/*********************************************************************************************
                                        create purchase invoice
*********************************************************************************************/
/*********************************************************************************************/
if(isset($_POST['entry_type']) && $_POST['entry_type'] =='create purchase invoice'){
$trnsction = json_decode($_POST['trnsction']);
$trnsction_array = (array) $trnsction;

$id = $trnsction_array['id'];
$name = $trnsction_array['vendor_name'];
$name_id = $trnsction_array['name_id'];
$so_po_no = $trnsction_array['so_po_no'];
$date = $trnsction_array['date'];
$date = date('Y-m-d', strtotime($date));

$transaction_number = $trnsction_array['transaction_number'];
$payment_term = $trnsction_array['payment_term'];
$due_date = $trnsction_array['due_date'];
$notes = $trnsction_array['notes'];
$subtotal = $trnsction_array['subtotal'];
$disc_rate = $trnsction_array['disc_rate'];
$disc_amount = $trnsction_array['disc_amount'];
$discount_account = $trnsction_array['discount_account'];
$vatt = $trnsction_array['vat'];
$total = $trnsction_array['total'];

$sqlv="SELECT * FROM `vendor` WHERE `id` = '$name_id'";
$newv=$conn->query($sqlv); 
while($rowv = $newv->fetch_assoc()){
$payable_account_id = $rowv['payable_account'];
}

$items = json_decode($_POST['items']);
$items =  arraytoarray($items);
$sql="UPDATE `transaction` SET `entry_type` = 'create purchase invoice', `cat_type` = 'purchase', `name`= '$name', `name_id`= '$name_id', `so_po_no` = '$so_po_no', `date` = '$date', `transaction_number` = '$transaction_number', `payment_term` = '$payment_term', `due_date` ='$due_date', `notes` = '$notes', `subtotal` = '$subtotal', `disc_rate` = '$disc_rate', `disc_amount` = '$disc_amount', `discount_account` = '$discount_account', `vat` = '$vatt',`due_amt` = `due_amt` - (`total` -'$total'), `total` = '$total', `total_no_vat` = '$total'-'$vatt', `company_email` = '$company_email'  WHERE `id` = '$id'" ;
if (mysqli_query($conn, $sql)) {
$sql20="SELECT * FROM `purchase_item` WHERE `purchase_id` = '$id'";
$new20=$conn->query($sql20); 
while($row20 = $new20->fetch_assoc()){
$reverse_item_id = $row20['item_id'];
$sql21="SELECT * FROM `items` WHERE `id` = '$reverse_item_id'";
$new21=$conn->query($sql21); 
while($row21 = $new21->fetch_assoc()){
if($row21['category']=='Inventory'){
$reverse_qty = $row21['stock'] - $row20['item_quantity'];
$reverse_asset_value = $row21['asset_value'] - $row20['cogs'];
$reverse_weighted_price = $reverse_asset_value/$reverse_qty;
$sqli = "UPDATE `items` SET `stock` = '$reverse_qty', `asset_value` = '$reverse_asset_value', `weighted_price` = '$reverse_weighted_price' WHERE `id` = '$reverse_item_id' ";
$conn->query($sqli) ;
}
}
}

$conn->query("DELETE FROM `purchase_item` WHERE `purchase_id` = '$id'"); 
$check_size = sizeof($items);
for($i=0; $i<$check_size; $i++ ){

$item_array =  (array) $items[$i];
$purchase_id = $item_array['id'];
$item_name = $item_array['item_name'];
$item_id = $item_array['item_id'];
$item_description = $item_array['item_description'];
$item_quantity = $item_array['item_quantity'];
$price_rate = $item_array['price_rate'];
$discount_rate = $item_array['discount_rate'];
$amount = $item_array['amount'];
$vat = $item_array['vat'];
$vat_id = $item_array['vat_id'];
$vat_amount = ($amount*$vat)/100; 

$sql21="SELECT * FROM `items` WHERE `id` = '$item_id'";
$new21=$conn->query($sql21); 
while($row21 = $new21->fetch_assoc()){
$type = $row21['category']; 
$cogs_id = $row21['cogs'];
$inv_asset_id = $row21['inv_asset'];
$inc_account_id = $row21['inc_account'];
$exp_account_id = $row21['exp_account'];
if($row21['category']=='Inventory'){
$qty = $row21['stock'] + $item_quantity;
$cogs = $price_rate * $item_quantity;
$asset_value = $row21['asset_value'] + $cogs;
$weight_avg = $asset_value/$qty;
}
}

$sqli="INSERT INTO `purchase_item` (`date` , `item_name`, `item_id`, `item_category`, `item_description`, `item_quantity`, `price_rate`, `discount_rate`, `amount`, `vat`, `vat_id`, `vat_amount`, `asset_value`, `qty`, `cogs`, `weight_avg`, `exp_account_id`, `income_account_id`, `cogs_id`, `inventory_id`, `company_email`, `type`, `purchase_id`) VALUES ('$date', '$item_name', '$item_id', '$type', '$item_description', '$item_quantity', '$price_rate', '$discount_rate', '$amount', '$vat', '$vat_id', '$vat_amount', '$asset_value', '$qty', '$cogs', '$weight_avg', '$exp_account_id', '$inc_account_id', '$cogs_id', '$inv_asset_id', '$company_email', 'create purchase invoice', '$id')" ;

$conn->query($sqli) ;
if($type=='Inventory'){
$sqli = "UPDATE `items` SET `stock` = '$qty', `asset_value` = '$asset_value', `weighted_price` = '$weight_avg' WHERE `id` = '$item_id' ";
$conn->query($sqli) ;
$cogs = '0';
$asset_value = '0';
$weight_avg = '0';
$qty = '0';
}

}

///////////////////*****************/////////////// DELETE JOURNAL///////////////////*****************///////////////
$sqli="DELETE FROM `journal` WHERE `transaction_id` = '$id'" ;
$conn->query($sqli) or die(mysqli_error());
///////////////////*****************/////////////// DELETE JOURNAL///////////////////*****************///////////////

/***********************************************************JOURNAL ENTRIES****************************************************/
///////////////////ACCOUNTS PAYABLE////////////////////
$sqli1="INSERT INTO `journal` (`date`, `number`, `account`, `credit`, `transaction_id`, `type`, `company_email`) VALUES ('$date', '$transaction_number', '$payable_account_id', '$total', '$id', 'Invoice', '$company_email')";
$conn->query($sqli1) ;
///////////////////ACCOUNTS PAYABLE////////////////////

///////////////////INVENTORY////////////////////
$sql_new = "SELECT SUM(cogs) AS `cost_of_gs`, `inventory_id` FROM `purchase_item` WHERE `purchase_id` = '$id' AND `item_category` = 'Inventory' GROUP BY `inventory_id`";
$new_new = $conn->query($sql_new) ;
while($row = $new_new->fetch_assoc()){
 $cost_of_gs = $row['cost_of_gs'];
  $inventory_id = $row['inventory_id'];
$sqli2="INSERT INTO `journal` (`date`, `number`, `account`, `debit`, `transaction_id`, `type`, `company_email`) VALUES ('$date', '$transaction_number', '$inventory_id', '$cost_of_gs', '$id', 'Invoice', '$company_email')";
$conn->query($sqli2) ;
}
///////////////////INVENTORY////////////////////

///////////////////DISCOUNT////////////////////
$sqli4="INSERT INTO `journal` (`date`, `number`, `account`, `credit`, `transaction_id`, `type`, `company_email`) VALUES ('$date', '$transaction_number', '$discount_account', '$disc_amount', '$id', 'Invoice', '$company_email')";
$conn->query($sqli4) ;
///////////////////DISCOUNT////////////////////


///////////////////VAT////////////////////
$sql_new = "SELECT SUM(vat_amount) AS `vat_amount_tot`, `vat_id` FROM `purchase_item` WHERE `purchase_id` = '$id' GROUP BY `vat_id`";
$new_new = $conn->query($sql_new) ;
while($row = $new_new->fetch_assoc()){
$vat_amount_tot = $row['vat_amount_tot'];
$vat_id = $row['vat_id'];
$sql = "SELECT * FROM `vat` WHERE `id` = '$vat_id' AND `category` = 'purchase' AND `company_email` = '$company_email'";
$new = $conn->query($sql) ;
while($rowsd = $new->fetch_assoc()){
$vat_number_id = $rowsd['account'];
$sqli4="INSERT INTO `journal` (`date`, `number`, `account`, `debit`, `transaction_id`, `type`, `company_email`) VALUES ('$date', '$transaction_number', '$vat_number_id', '$vat_amount_tot', '$id', 'Invoice', '$company_email')";
$conn->query($sqli4) ;
}
}
///////////////////VAT////////////////////

///////////////////EXPENSE////////////////////
$sql_new = "SELECT SUM(amount) AS `amount_one`, `exp_account_id` FROM `purchase_item` WHERE `purchase_id` = '$id' AND `item_category` != 'Inventory' GROUP BY `cogs_id`";
$new_new = $conn->query($sql_new) ;
while($row = $new_new->fetch_assoc()){
  $amount_one = $row['amount_one'];
  $exp_account_ids = $row['exp_account_id'];
$sqli3="INSERT INTO `journal` (`date`, `number`, `account`, `debit`, `transaction_id`, `type`, `company_email`) VALUES ('$date', '$transaction_number', '$exp_account_ids', '$amount_one', '$last_id', 'Invoice', '$company_email')";
$conn->query($sqli3) ;
}
///////////////////EXPENSE////////////////////
/***********************************************************JOURNAL ENTRIES****************************************************/

} else {
    echo "Error: " . $sql . "<br>" . mysqli_error($conn);
}

}


/*********************************************************************************************/

/*********************************************************************************************/
/*********************************************************************************************
										create vendor payment
*********************************************************************************************/
/*********************************************************************************************/
if(isset($_POST['entry_type']) && $_POST['entry_type'] =='create vendor payment'){
$trnsction = json_decode($_POST['purchase_payment']);
$trnsction_array = (array) $trnsction;

$id = $trnsction_array['id'];
if(isset($trnsction_array['vendor_name']) && $trnsction_array['vendor_name'] != ''){
$name = $trnsction_array['vendor_name'];
$name_id = $trnsction_array['vendor_id'];
}else{
$name = $trnsction_array['name'];
$name_id = $trnsction_array['name_id'];
}
$bank_id = $trnsction_array['bank_id'];
$cheque_no = $trnsction_array['cheque_no'];
$date = $trnsction_array['date'];
$date = date('Y-m-d', strtotime($date));
$sqliven="SELECT * FROM `vendor` WHERE `company_email` = '$company_email' AND `id` = '$name_id'";
$newven = $conn->query($sqliven) ;
$rowven = $newven->fetch_assoc();
$payable_account_id = $rowven['payable_account'];
$transaction_number = $trnsction_array['transaction_number'];
$notes = $trnsction_array['notes'];
$due_amt = $trnsction_array['due_amt'];
$disc_rate = $trnsction_array['disc_rate'];
$disc_amount = $trnsction_array['disc_amount'];
$discount_account = $trnsction_array['discount_account'];
$vat = $trnsction_array['vat'];
$total = $trnsction_array['total'];
$new_credit = $trnsction_array['credit'];
$datee = json_decode($_POST['invoices']);
$dates =  arraytoarray($datee);

 $sql = "UPDATE `transaction` SET `name` = '$name', `bank_id` = '$bank_id', `cheque_no` = '$cheque_no', `date` = '$date', `transaction_number` = '$transaction_number', `notes` = '$notes' , `due_amt` = '$due_amt', `disc_rate` = '$disc_rate', `disc_amount` = '$disc_amount', `discount_account` = '$discount_account', `total` = '$total', `credit` = '$new_credit' WHERE `id` = '$id' AND  `company_email` = '$company_email'" ;

 if (mysqli_query($conn, $sql)) {

$sqli="SELECT * FROM `vendor_payment_list` WHERE `company_email` = '$company_email' AND `vendor_payment_list_id` = '$id'";
$new = $conn->query($sqli) ;
while ($row = $new->fetch_assoc()) {
$delete_transaction_no = $row['invoice_no'];
$delete_discount_amount = $row['discount_amount'];
$delete_received = $row['received'];
$deduct_value = $delete_received + $delete_discount_amount;
$sqli5="UPDATE `transaction` SET , `due_amt` = `due_amt` + '$deduct_value' WHERE `company_email` = '$company_email' AND `transaction_number` = '$delete_transaction_no' AND `entry_type` = 'create purchase invoice'";
$conn->query($sqli5) ;
}
$sqli5="DELETE FROM `vendor_payment_list` WHERE `company_email` = '$company_email' AND `vendor_payment_list_id` = '$id'";
$conn->query($sqli5) ;


 $check_size = sizeof($dates);
for($i=0; $i<$check_size; $i++ ){

$date_array =  (array) $dates[$i];
  $payment_id = $date_array['id'];
// $datess = $date_array['dates'];
$invoice_no = $date_array['transaction_number'];
$total = $date_array['total'];
$discount_amount = $date_array['discount_amount'];
$due_amount = $date_array['due_amt'];
$received = $date_array['paid'];
$credit_amount = $date_array['credit_amount'];
$discount_rate = (100 * $discount_amount)/$total;


$sqli="INSERT INTO `vendor_payment_list` (`dates`, `invoice_no`, `total`, `discount_rate`, `discount_amount`, `credit_amount`, `due_amount`, `received`, `vendor_payment_list_id`, `company_email`) VALUES ('$date', '$invoice_no', '$total', '$discount_rate', '$discount_amount', '$credit_amount', '$due_amount', '$received', '$id', '$company_email')";
 $conn->query($sqli) ;
$new_due_amount = $due_amount - ($discount_amount + $received);
$sqli = "UPDATE `transaction` SET `due_amt` = '$new_due_amount' WHERE `company_email` = '$company_email' AND `transaction_number` = '$invoice_no' AND `entry_type` = 'create purchase invoice' ";
$conn->query($sqli) ;
}

///////////////////*****************/////////////// DELETE JOURNAL///////////////////*****************///////////////
$sqli="DELETE FROM `journal` WHERE `transaction_id` = '$id'" ;
$conn->query($sqli);
///////////////////*****************/////////////// DELETE JOURNAL///////////////////*****************///////////////

/***********************************************************JOURNAL ENTRIES****************************************************/
///////////////////BANK////////////////////
$sqli2="INSERT INTO `journal` (`date`, `number`, `account`, `credit`, `transaction_id`, `type`, `company_email`) VALUES ('$date', '$transaction_number', '$bank_id', '$total', '$id', 'Payment', '$company_email')";
$conn->query($sqli2) ;
///////////////////BANK////////////////////
///////////////////DISCOUNT////////////////////
$sqli2="INSERT INTO `journal` (`date`, `number`, `account`, `credit`, `transaction_id`, `type`, `company_email`) VALUES ('$date', '$transaction_number', '$discount_account', '$disc_amount', '$id', 'Payment', '$company_email')";
$conn->query($sqli2) ;
///////////////////DISCOUNT////////////////////
///////////////////RECEIVABLE////////////////////
$receivable = $total + $disc_amount;
$sqli2="INSERT INTO `journal` (`date`, `number`, `account`, `debit`, `transaction_id`, `type`, `company_email`) VALUES ('$date', '$transaction_number', '$payable_account_id', '$receivable', '$id', 'Payment', '$company_email')";
$conn->query($sqli2) ;
///////////////////RECEIVABLE////////////////////
/***********************************************************JOURNAL ENTRIES****************************************************/

} else {
  echo "hadd h yeee ab to thak gaya hu";
    echo "Error: " . $sql . "<br>" . mysqli_error($conn);
}


}

/*********************************************************************************************/
/*********************************************************************************************
										create purchase return
*********************************************************************************************/
/*********************************************************************************************/
if(isset($_POST['entry_type']) && $_POST['entry_type'] =='create purchase return'){
$trnsction = json_decode($_POST['trnsction']);
$adjustment = convert_to_array($_POST['adjustment']);
$trnsction_array = (array) $trnsction;

$id = $trnsction_array['id'];
$name = $trnsction_array['vendor_name'];
$name_id = $trnsction_array['name_id'];
$date = $trnsction_array['date'];
$date = date('Y-m-d', strtotime($date));

$transaction_number = $trnsction_array['transaction_number'];
$return_type = $trnsction_array['return_type'];
$bank_id = $trnsction_array['bank_id'];
$cheque_no = $trnsction_array['cheque_no'];
$notes = $trnsction_array['notes'];
$subtotal = $trnsction_array['subtotal'];
$disc_rate = $trnsction_array['disc_rate'];
$disc_amount = $trnsction_array['disc_amount'];
$discount_account = $trnsction_array['discount_account'];
$vatt = $trnsction_array['vat'];
$total = $trnsction_array['total'];
$credit = $trnsction_array['credit'];

$bank_total = $total - $vatt;

$sqlv="SELECT * FROM `vendor` WHERE `id` = '$name_id'";
$newv=$conn->query($sqlv); 
while($rowv = $newv->fetch_assoc()){
$payable_account_id = $rowv['payable_account'];
}

$items = json_decode($_POST['items']);
$items =  arraytoarray($items);

$date_time=time();

$sql="UPDATE `transaction` SET `entry_type` = 'create purchase return', `cat_type` = 'purchase', `name` = '$name', `name_id` = '$name_id', `date` = '$date', `transaction_number` = '$transaction_number', `return_type` = '$return_type', `bank_id` = '$bank_id', `cheque_no` = '$cheque_no', `notes` = '$notes', `subtotal` = '$subtotal', `disc_rate` = '$disc_rate' , `disc_amount` = '$disc_amount', `discount_account` = '$discount_account',  `vat` = '$vatt', `total` = '$total', `company_email` = '$company_email' WHERE `id` = '$id'" ;


if (mysqli_query($conn, $sql)) {
  $result="UPDATE `vendor` SET `credit` = `credit`+('$credit' - (SELECT `credit` FROM transaction WHERE transaction.id = '$id' AND `company_email` = '$company_email')) WHERE `company_email` = '$company_email' AND `id` = (SELECT `name_id` FROM transaction WHERE transaction.id = '$id' AND `company_email` = '$company_email')" ;
  $conn->query($result);
  $sqlasi="UPDATE transaction, invoice_adjustments SET due_amt = due_amt+ adjust_amt  WHERE transaction_id = '$id' AND invoice_id = id AND transaction.company_email = '$company_email' AND invoice_adjustments.company_email = '$company_email'";
  $conn->query($sqlasi);
  $conn->query("DELETE FROM invoice_adjustments WHERE transaction_id = '$id' AND company_email = '$company_email'");
  if($return_type == 'On Account'){
  $u = "UPDATE `transaction` SET `credit` = '$credit' WHERE `id` = '$id' AND `company_email` = '$company_email'";
  $conn->query($u);
  if (isset($adjustment)) {
    foreach ($adjustment as $c_invoice) {
      $c_invoice_paid = $c_invoice['adjust_amt'];
      $c_invoice_id = $c_invoice['id'];
      $conn->query("INSERT INTO `invoice_adjustments`(`transaction_id`, `invoice_id`, `adjust_amt`, `company_email`) VALUES ('$id', '$c_invoice_id', '$c_invoice_paid', '$company_email')");
      $sqlasi="UPDATE `transaction` SET `due_amt` = `due_amt`-'$c_invoice_paid'  WHERE `company_email` = '$company_email' AND `id` = '$c_invoice_id'";
      $conn->query($sqlasi);
    }
  }
}

$sql20="SELECT * FROM `purchase_item` WHERE `purchase_id` = '$id'";
$new20=$conn->query($sql20); 
while($row20 = $new20->fetch_assoc()){
$reverse_item_id = $row20['item_id'];
$sql21="SELECT * FROM `items` WHERE `id` = '$reverse_item_id'";
$new21=$conn->query($sql21); 
while($row21 = $new21->fetch_assoc()){
if($row21['category']=='Inventory'){
$reverse_qty = $row21['stock'] + $row20['item_quantity'];
$reverse_cogs = $row21['weighted_price'] * $row20['item_quantity'];
$reverse_asset_value = $row21['asset_value'] + $reverse_cogs;
$reverse_weighted_price = $row21['weighted_price'];
$sqli = "UPDATE `items` SET `stock` = '$reverse_qty', `asset_value` = '$reverse_asset_value', `weighted_price` = '$reverse_weighted_price' WHERE `id` = '$reverse_item_id' ";
$conn->query($sqli) ;
}
}
}

$conn->query("DELETE FROM `purchase_item` WHERE `purchase_id` = '$id'"); 
$check_size = sizeof($items);
for($i=0; $i<$check_size; $i++ ){

$item_array =  (array) $items[$i];
$purchase_id = $item_array['id'];
$item_name = $item_array['item_name'];
$item_id = $item_array['item_id'];
$item_description = $item_array['item_description'];
$item_quantity = $item_array['item_quantity'];
$price_rate = $item_array['price_rate'];
$discount_rate = $item_array['discount_rate'];
$amount = $item_array['amount'];
$vat = $item_array['vat'];
$vat_id = $item_array['vat_id'];
$vat_amount = ($amount*$vat)/100; 

$sql21="SELECT * FROM `items` WHERE `id` = '$item_id'";
$new21=$conn->query($sql21); 
while($row21 = $new21->fetch_assoc()){
$type = $row21['category']; 
$cogs_id = $row21['cogs'];
$inv_asset_id = $row21['inv_asset'];
$inc_account_id = $row21['inc_account'];
$exp_account_id = $row21['exp_account'];
if($row21['category']=='Inventory'){
$qty = $row21['stock'] - $item_quantity;
if($row21['weighted_price'] != '0'){
$cogs = $price_rate * $item_quantity;
$weight_avg = $row21['weighted_price'];
}else{
$cogs = $price_rate * $item_quantity;
$weight_avg = $price_rate;
}
$asset_value = $row21['asset_value'] - $cogs;
}
}
$sqli="INSERT INTO `purchase_item` (`date` , `item_name`, `item_id`, `item_category`, `item_description`, `item_quantity`, `price_rate`, `discount_rate`, `amount`, `vat`, `vat_id`, `vat_amount`, `asset_value`, `qty`, `cogs`, `weight_avg`, `exp_account_id`, `income_account_id`, `cogs_id`, `inventory_id`, `company_email`, `type`, `purchase_id`) VALUES ('$date', '$item_name', '$item_id', '$type', '$item_description', '$item_quantity', '$price_rate', '$discount_rate', '$amount', '$vat', '$vat_id', '$vat_amount', '$asset_value', '$qty', '$cogs', '$weight_avg', '$exp_account_id', '$inc_account_id', '$cogs_id', '$inv_asset_id', '$company_email', 'create purchase return', '$id')" ;

$conn->query($sqli) ;
if($type=='Inventory'){
$sqli = "UPDATE `items` SET `stock` = '$qty', `asset_value` = '$asset_value', `weighted_price` = '$weight_avg' WHERE `id` = '$item_id' ";
$conn->query($sqli) ;
$cogs = '0';
$asset_value = '0';
$weight_avg = '0';
$qty = '0';
}

}

///////////////////*****************/////////////// DELETE JOURNAL///////////////////*****************///////////////
$sqli="DELETE FROM `journal` WHERE `transaction_id` = '$id'" ;
$conn->query($sqli) or die(mysqli_error());
///////////////////*****************/////////////// DELETE JOURNAL///////////////////*****************///////////////

/***********************************************************JOURNAL ENTRIES****************************************************/
///////////////////ACCOUNTS PAYABLE////////////////////
$sqli1="INSERT INTO `journal` (`date`, `number`, `account`, `debit`, `transaction_id`, `type`, `company_email`) VALUES ('$date', '$transaction_number', '$payable_account_id', '$total', '$id', 'Return', '$company_email')";
$conn->query($sqli1) ;
///////////////////ACCOUNTS PAYABLE////////////////////

///////////////////INVENTORY////////////////////
$sql_new = "SELECT SUM(cogs) AS `cost_of_gs`, `inventory_id` FROM `purchase_item` WHERE `purchase_id` = '$id' AND `item_category` = 'Inventory' GROUP BY `inventory_id`";
$new_new = $conn->query($sql_new) ;
while($row = $new_new->fetch_assoc()){
  $cost_of_gs = $row['cost_of_gs'];
  $inventory_id = $row['inventory_id'];
echo $sqli2="INSERT INTO `journal` (`date`, `number`, `account`, `credit`, `transaction_id`, `type`, `company_email`) VALUES ('$date', '$transaction_number', '$inventory_id', '$cost_of_gs', '$id', 'Return', '$company_email')";
$conn->query($sqli2) ;
}
///////////////////INVENTORY////////////////////

///////////////////DISCOUNT////////////////////
$sqli4="INSERT INTO `journal` (`date`, `number`, `account`, `debit`, `transaction_id`, `type`, `company_email`) VALUES ('$date', '$transaction_number', '$discount_account', '$disc_amount', '$id', 'Return', '$company_email')";
$conn->query($sqli4) ;
///////////////////DISCOUNT////////////////////

///////////////////VAT////////////////////
$sql_new = "SELECT SUM(vat_amount) AS `vat_amount_tot`, `vat_id` FROM `purchase_item` WHERE `purchase_id` = '$id' GROUP BY `vat_id`";
$new_new = $conn->query($sql_new) ;
while($row = $new_new->fetch_assoc()){
$vat_amount_tot = $row['vat_amount_tot'];
$vat_id = $row['vat_id'];
$sql = "SELECT * FROM `vat` WHERE `id` = '$vat_id' AND `category` = 'purchase' AND `company_email` = '$company_email'";
$new = $conn->query($sql) ;
while($rowsd = $new->fetch_assoc()){
$vat_number_id = $rowsd['account'];
$sqli4="INSERT INTO `journal` (`date`, `number`, `account`, `credit`, `transaction_id`, `type`, `company_email`) VALUES ('$date', '$transaction_number', '$vat_number_id', '$vat_amount_tot', '$id', 'Return', '$company_email')";
$conn->query($sqli4) ;
}
}
///////////////////VAT////////////////////

///////////////////EXPENSE////////////////////
$sql_new = "SELECT SUM(amount) AS `amount_one`, `exp_account_id` FROM `purchase_item` WHERE `purchase_id` = '$id' AND `item_category` != 'Inventory' GROUP BY `cogs_id`";
$new_new = $conn->query($sql_new) ;
while($row = $new_new->fetch_assoc()){
  $amount_one = $row['amount_one'];
  $exp_account_ids = $row['exp_account_id'];
$sqli3="INSERT INTO `journal` (`date`, `number`, `account`, `credit`, `transaction_id`, `type`, `company_email`) VALUES ('$date', '$transaction_number', '$exp_account_ids', '$amount_one', '$id', 'Return', '$company_email')";
$conn->query($sqli3) ;
}
///////////////////EXPENSE////////////////////

if($_POST['return_type'] != 'On Account'){
$sqli1="INSERT INTO `journal` (`date`, `number`, `account`, `credit`, `transaction_id`, `type`, `company_email`) VALUES ('$date', '$transaction_number', '$payable_account_id', '$bank_total', '$id', 'Return', '$company_email')";
$conn->query($sqli1) ;

$sqli11="INSERT INTO `journal` (`date`, `number`, `account`, `debit`, `transaction_id`, `type`, `company_email`) VALUES ('$date', '$transaction_number', '$bank_id', '$bank_total', '$id', 'Return', '$company_email')";
$conn->query($sqli11) ;
}

/***********************************************************JOURNAL ENTRIES****************************************************/

} else {
    echo "Error: " . $sql . "<br>" . mysqli_error($conn);
}

}

/*********************************************************************************************/

/******************************DELETE JORNAL ZERO COLOUMN//////////////////////////////////******/
$sqli="DELETE FROM `journal` WHERE `debit` = '0' AND `credit` = '0'" ;
$conn->query($sqli) or die(mysqli_error());
/******************************DELETE JORNAL ZERO COLOUMN//////////////////////////////////******/

?>

