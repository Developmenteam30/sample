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
										Create sales order
*********************************************************************************************/
/*********************************************************************************************/
if(isset($_POST['entry_type']) && $_POST['entry_type'] =='Create sales order'){
$trnsction = json_decode($_POST['trnsction']);
$trnsction_array = (array) $trnsction;

$id = $trnsction_array['id'];
$name = $trnsction_array['customer_name'];
$name_id = $trnsction_array['name_id'];
$so_po_no = $trnsction_array['so_po_no'];
$date = $trnsction_array['date'];
$date = date('Y-m-d', strtotime($date));

$transaction_number = $trnsction_array['transaction_number'];
$payment_term = $trnsction_array['payment_term'];
$notes = $trnsction_array['notes'];
$subtotal = $trnsction_array['subtotal'];
$disc_rate = $trnsction_array['disc_rate'];
$disc_amount = $trnsction_array['disc_amount'];
$discount_account = $trnsction_array['discount_account'];
$vatt = $trnsction_array['vat'];
$total = $trnsction_array['total'];

$items = json_decode($_POST['items']);
$items =  arraytoarray($items);



$sql="UPDATE `transaction` SET `entry_type` = 'Create sales order' , `cat_type` = 'sales', `name` = '$name', `name_id` = '$name_id', `so_po_no` = '$so_po_no', `date` =  '$date', `transaction_number` = '$transaction_number', `payment_term` = '$payment_term', `notes` = '$notes', `subtotal` = '$subtotal', `disc_rate` = '$disc_rate', `disc_amount` = '$disc_amount', `discount_account` = '$discount_account', `vat` =  '$vatt', `total` = '$total', `company_email` = '$company_email'  WHERE `id` = '$id'" ;



if (mysqli_query($conn, $sql)) {

    //echo "New record created successfully. Last inserted ID is: " . $last_id;
$check_size = sizeof($items);
for($i=0; $i<$check_size; $i++ ){

$item_array =  (array) $items[$i];
$sales_id = $item_array['id'];
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
$sqli="UPDATE `sales_item` SET `date` =  '$date', `item_name` = '$item_name', `item_id` = '$item_id', `item_description` = '$item_description', `item_quantity` = '$item_quantity', `price_rate` = '$price_rate', `discount_rate`= '$discount_rate', `amount` =  '$amount', `vat` = '$vat', `vat_id` = '$vat_id', `vat_amount` = '$vat_amount', `company_email` = '$company_email', `type` = 'Create sales order'  WHERE `id` = '$sales_id'" ;


$conn->query($sqli) ;

}

} else {
    echo "Error: " . $sql . "<br>" . mysqli_error($conn);
}

}

/*********************************************************************************************/
/*********************************************************************************************
										create customer
*********************************************************************************************/
/*********************************************************************************************/
if(isset($_POST['entry_type']) && $_POST['entry_type'] =='create customer'){

$company_name = $_POST['company_name'];
$id = $_POST['id'];
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
$customer_code = $_POST['customer_code'];
$payable_account = $_POST['payable_account'];
$notes = $_POST['notes'];
$opening_balance = $_POST['opening_balance'];
$opening_date = date('Y-m-d', $_POST['opening_date']);


 $result="UPDATE `customer` SET `company_name` = '$company_name', `opening_balance` = '$opening_balance', `opening_date` = '$opening_date', `email` = '$email', `address` = '$address', `city` = '$city', `state` = '$state', `country` = '$country', 
`contact_name` = '$contact_name', `phone` = '$phone', `mobile` = '$mobile', `tax_number` = '$tax_number', `payment_term` = '$payment_term', `vat` = '$vat', `vat_number` = '$vat_number', `customer_code` = '$customer_code', `payable_account` = '$payable_account', `notes`  = '$notes', `company_email` = '$company_email'  WHERE `id` = '$id'" ;

   
//echo "<script>alert(".$name.");</script>";

echo $new = $conn->query($result) or die (mysqli_error());	
$vendor_opening_balance = $_POST['vendor_opening_balance'];
$date = $opening_date;
$conn->query("DELETE FROM `transaction` WHERE `entry_type` = 'Journal' AND `cat_type` =  'Journal' AND `name_id` = '$id' AND `name` =  'customer' AND `company_email` = '$company_email'");
  $sqls="INSERT INTO `transaction` (`entry_type`, `cat_type`, `name_id`, `name`, `total`, `date`, `company_email`, `transaction_number`) VALUES ('Journal', 'Journal', '$id', 'customer', '$opening_balance', '$date', '$company_email', '')";

  if (mysqli_query($conn, $sqls)) {
    echo  $last_ids = mysqli_insert_id($conn);
    ///////////////////BANK////////////////////
    $sqlsa = $conn->query("SELECT * FROM `coa_list` WHERE `accounts_name` = 'Opening Balance Equity' AND `company_email` = '$company_email' LIMIT 1");
    $r = $sqlsa->fetch_assoc();
    $ias = $r['id'];
    if($opening_balance < 0){
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
                    create sales Receipt
*********************************************************************************************/
/*********************************************************************************************/
if(isset($_POST['entry_type']) && $_POST['entry_type'] =='create sales Receipt'){
$trnsction = json_decode($_POST['trnsction']);
$trnsction_array = (array) $trnsction;

$id = $trnsction_array['id'];
$names = $trnsction_array['customer_name'];
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

$bank_total = $total - $vatt;

$sqlv="SELECT * FROM `customer` WHERE `id` = '$name_id'";
$newv=$conn->query($sqlv); 
while($rowv = $newv->fetch_assoc()){
$receivable_account_id = $rowv['payable_account'];
}

$items = json_decode($_POST['items']);
$items =  arraytoarray($items);

$sql="UPDATE `transaction`  SET `entry_type` = 'create sales Receipt', `cat_type` = 'sales', `name` = '$names', `name_id` = '$name_id', `date` = '$date', `transaction_number` = '$transaction_number', `bank_id` = '$bank_id', `cheque_no` = '$cheque_no', `notes` = '$notes', `subtotal` = '$subtotal' , `disc_rate` = '$disc_rate', `disc_amount` = '$disc_amount', `discount_account` = '$discount_account', `vat` = '$vatt', `total` = '$total', `company_email` = '$company_email' WHERE `id` = '$id'" ;



if (mysqli_query($conn, $sql)) {
$sql20="SELECT * FROM `sales_item` WHERE `sales_id` = '$id'";
$new20=$conn->query($sql20); 
while($row20 = $new20->fetch_assoc()){
$reverse_item_id = $row20['item_id'];
$sql21="SELECT * FROM `items` WHERE `id` = '$reverse_item_id'";
$new21=$conn->query($sql21); 
while($row21 = $new21->fetch_assoc()){
if($row21['category']=='Inventory'){
$reverse_qty = $row21['stock'] + $row20['item_quantity'];
$reverse_asset_value = $row21['asset_value'] + $row20['cogs'];
$reverse_weighted_price = $reverse_asset_value/$reverse_qty;
$sqli = "UPDATE `items` SET `stock` = '$reverse_qty', `asset_value` = '$reverse_asset_value', `weighted_price` = '$reverse_weighted_price' WHERE `id` = '$reverse_item_id' ";
$conn->query($sqli) ;
}
}
}
$conn->query("DELETE FROM `sales_item` WHERE `sales_id` = '$id'"); 
$check_size = sizeof($items);
for($i=0; $i<$check_size; $i++ ){

$item_array =  (array) $items[$i];
$sales_id = $item_array['id'];
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
$cogs = $row21['weighted_price'] * $item_quantity;
$asset_value = $row21['asset_value'] - $cogs;
$weight_avg = $row21['weighted_price'];
}
}

$sqli="INSERT INTO `sales_item` (`date` , `item_name`, `item_id`, `item_category`, `item_description`, `item_quantity`, `price_rate`, `discount_rate`, `amount`, `vat`, `vat_id`, `vat_amount`, `asset_value`, `qty`, `cogs`, `weight_avg`, `exp_account_id`, `income_account_id`, `cogs_id`, `inventory_id`, `company_email`, `type`, `sales_id`) VALUES ('$date', '$item_name', '$item_id', '$type', '$item_description', '$item_quantity', '$price_rate', '$discount_rate', '$amount', '$vat', '$vat_id', '$vat_amount', '$asset_value', '$qty', '$cogs', '$weight_avg', '$exp_account_id', '$inc_account_id', '$cogs_id', '$inv_asset_id', '$company_email', 'create sales Receipt', '$id')" ;

$conn->query($sqli) or die(mysqli_error());
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
///////////////////BANK////////////////////
$sqli1="INSERT INTO `journal` (`date`, `number`, `account`, `debit`, `transaction_id`, `type`, `company_email`) VALUES ('$date', '$transaction_number', '$bank_id', '$bank_total', '$id', 'Receipt', '$company_email')";
$conn->query($sqli1) ;
///////////////////BANK////////////////////

///////////////////DISCOUNT////////////////////
$sqli2="INSERT INTO `journal` (`date`, `number`, `account`, `debit`, `transaction_id`, `type`, `company_email`) VALUES ('$date', '$transaction_number', '$discount_account', '$disc_amount', '$id', 'Receipt', '$company_email')";
$conn->query($sqli2) ;
///////////////////DISCOUNT////////////////////

///////////////////INCOME////////////////////
$sql_new = "SELECT SUM(amount) AS `amount_one`, `income_account_id` FROM `sales_item` WHERE `sales_id` = '$id' AND `item_category` = 'Inventory' GROUP BY `cogs_id`";
$new_new = $conn->query($sql_new) ;
while($row = $new_new->fetch_assoc()){
  $amount_one = $row['amount_one'];
  $income_account_id = $row['income_account_id'];
$sqli3="INSERT INTO `journal` (`date`, `number`, `account`, `credit`, `transaction_id`, `type`, `company_email`) VALUES ('$date', '$transaction_number', '$income_account_id', '$amount_one', '$id', 'Receipt', '$company_email')";
$conn->query($sqli3) ;
}
///////////////////INCOME////////////////////

///////////////////SERVICE////////////////////EXPENCE ID INSERTED
$sql_new = "SELECT SUM(amount) AS `amount_one`, `exp_account_id` FROM `sales_item` WHERE `sales_id` = '$id' AND `item_category` != 'Inventory' GROUP BY `cogs_id`";
$new_new = $conn->query($sql_new) ;
while($row = $new_new->fetch_assoc()){
  $amount_one = $row['amount_one'];
  $exp_account_ids = $row['exp_account_id'];
$sqli4="INSERT INTO `journal` (`date`, `number`, `account`, `credit`, `transaction_id`, `type`, `company_email`) VALUES ('$date', '$transaction_number', '$exp_account_ids', '$amount_one', '$id', 'Receipt', '$company_email')";
$conn->query($sqli4) ;
}
///////////////////SERVICE////////////////////EXPENCE ID INSERTED

///////////////////VAT////////////////////
$sql_new = "SELECT SUM(vat_amount) AS `vat_amount_tot`, `vat_id` FROM `sales_item` WHERE `sales_id` = '$id' GROUP BY `vat_id`";
$new_new = $conn->query($sql_new) ;
while($row = $new_new->fetch_assoc()){
$vat_amount_tot = $row['vat_amount_tot'];
$vat = $row['vat_id'];
$sql = "SELECT * FROM `vat` WHERE `id` = '$vat' AND `category` = 'sales' AND `company_email` = '$company_email'";
$new = $conn->query($sql) ;
while($rowsd = $new->fetch_assoc()){
$vat_number_id = $rowsd['account'];
$sqli4="INSERT INTO `journal` (`date`, `number`, `account`, `credit`, `transaction_id`, `type`, `company_email`) VALUES ('$date', '$transaction_number', '$vat_number_id', '$vat_amount_tot', '$id', 'Receipt', '$company_email')";
$conn->query($sqli4) ;
}
}
///////////////////VAT////////////////////

///////////////////ACCOUNT RECEIVABLE////////////////////
$sqli6="INSERT INTO `journal` (`date`, `number`, `account`, `debit`, `transaction_id`, `type`, `company_email`) VALUES ('$date', '$transaction_number', '$receivable_account_id', '$vatt', '$id', 'Receipt', '$company_email')";
$conn->query($sqli6) ;
///////////////////ACCOUNT RECEIVABLE////////////////////
///////////////////COGS////////////////////
$sql_new = "SELECT SUM(cogs) AS `cost_of_gs`, `cogs_id` FROM `sales_item` WHERE `sales_id` = '$id' AND `item_category` = 'Inventory' GROUP BY `cogs_id`";
$new_new = $conn->query($sql_new) ;
while($row = $new_new->fetch_assoc()){
  $cost_of_gs = $row['cost_of_gs'];
  $cogs_id = $row['cogs_id'];
$sqli7="INSERT INTO `journal` (`date`, `number`, `account`, `debit`, `transaction_id`, `type`, `company_email`) VALUES ('$date', '$transaction_number', '$cogs_id', '$cost_of_gs', '$id', 'Invoice', '$company_email')";
$conn->query($sqli7) ;
}
///////////////////COGS////////////////////
///////////////////INVENTORY////////////////////
$sql_new = "SELECT SUM(cogs) AS `cost_of_gs`, `inventory_id` FROM `sales_item` WHERE `sales_id` = '$id' AND `item_category` = 'Inventory' GROUP BY `inventory_id`";
$new_new = $conn->query($sql_new) ;
while($row = $new_new->fetch_assoc()){
  $cost_of_gs = $row['cost_of_gs'];
  $inventory_id = $row['inventory_id'];
$sqli6="INSERT INTO `journal` (`date`, `number`, `account`, `credit`, `transaction_id`, `type`, `company_email`) VALUES ('$date', '$transaction_number', '$inventory_id', '$cost_of_gs', '$id', 'Invoice', '$company_email')";
$conn->query($sqli6) ;
}
///////////////////INVENTORY////////////////////
/***********************************************************JOURNAL ENTRIES****************************************************/

} else {
    echo "Error: " . $sql . "<br>" . mysqli_error($conn);
}

}

/*********************************************************************************************/
/*********************************************************************************************
                    create sales invoice
*********************************************************************************************/
/*********************************************************************************************/
if(isset($_POST['entry_type']) && $_POST['entry_type'] =='create sales invoice'){
$trnsction = json_decode($_POST['trnsction']);
$trnsction_array = (array) $trnsction;

$id = $trnsction_array['id'];
$name = $trnsction_array['customer_name'];
$name_id = $trnsction_array['name_id'];
$payment_term = $trnsction_array['payment_term'];
$date = $trnsction_array['date'];
$date = date('Y-m-d', strtotime($date));

$transaction_number = $trnsction_array['transaction_number'];
$so_po_no = $trnsction_array['so_po_no'];
$due_date = $trnsction_array['due_date'];
$due_date = date('Y-m-d', strtotime($due_date));
$notes = $trnsction_array['notes'];
$subtotal = $trnsction_array['subtotal'];
$disc_rate = $trnsction_array['disc_rate'];
$disc_amount = $trnsction_array['disc_amount'];
$discount_account = $trnsction_array['discount_account'];
$vatt = $trnsction_array['vat'];
$total = $trnsction_array['total'];

$bank_total = $total - $vatt;

$sqlv="SELECT * FROM `customer` WHERE `id` = '$name_id'";
$newv=$conn->query($sqlv); 
while($rowv = $newv->fetch_assoc()){
$receivable_account_id = $rowv['payable_account'];
}

$items = json_decode($_POST['items']);
$items =  arraytoarray($items);

$sql="UPDATE `transaction` SET `entry_type` = 'create sales invoice', `cat_type` = 'sales', `name` = '$name', `name_id` = '$name_id', `payment_term` = '$payment_term', `date` = '$date', `transaction_number` = '$transaction_number', `so_po_no` = '$so_po_no', `due_date` = '$due_date', `notes` = '$notes', `subtotal` = '$subtotal', `disc_rate` = '$disc_rate', `disc_amount` = '$disc_amount', `discount_account` = '$discount_account', `vat` = '$vatt',`due_amt` = `due_amt` - (`total` -'$total'), `total` = '$total', `total_no_vat` = '$total'-'$vatt',  `company_email` = '$company_email'  WHERE `id` = '$id'" ;

if (mysqli_query($conn, $sql)) {
$sql20="SELECT * FROM `sales_item` WHERE `sales_id` = '$id'";
$new20=$conn->query($sql20); 
while($row20 = $new20->fetch_assoc()){
$reverse_item_id = $row20['item_id'];
$sql21="SELECT * FROM `items` WHERE `id` = '$reverse_item_id'";
$new21=$conn->query($sql21); 
while($row21 = $new21->fetch_assoc()){
if($row21['category']=='Inventory'){
$reverse_qty = $row21['stock'] + $row20['item_quantity'];
$reverse_asset_value = $row21['asset_value'] + $row20['cogs'];
$reverse_weighted_price = $reverse_asset_value/$reverse_qty;
$sqli = "UPDATE `items` SET `stock` = '$reverse_qty', `asset_value` = '$reverse_asset_value', `weighted_price` = '$reverse_weighted_price' WHERE `id` = '$reverse_item_id' ";
$conn->query($sqli) ;
}
}
}

$conn->query("DELETE FROM `sales_item` WHERE `sales_id` = '$id'"); 

$check_size = sizeof($items);
for($i=0; $i<$check_size; $i++ ){

$item_array =  (array) $items[$i];
$sales_id = $item_array['id'];
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
$cogs = $row21['weighted_price'] * $item_quantity;
$asset_value = $row21['asset_value'] - $cogs;
$weight_avg = $row21['weighted_price'];
}
}


$sqli="INSERT INTO `sales_item` (`date` , `item_name`, `item_id`, `item_category`, `item_description`, `item_quantity`, `price_rate`, `discount_rate`, `amount`, `vat`, `vat_id`, `vat_amount`, `asset_value`, `qty`, `cogs`, `weight_avg`, `exp_account_id`, `income_account_id`, `cogs_id`, `inventory_id`, `company_email`, `type`, `sales_id`) VALUES ('$date', '$item_name', '$item_id', '$type', '$item_description', '$item_quantity', '$price_rate', '$discount_rate', '$amount', '$vat', '$vat_id', '$vat_amount', '$asset_value', '$qty', '$cogs', '$weight_avg', '$exp_account_id', '$inc_account_id', '$cogs_id', '$inv_asset_id', '$company_email', 'create sales invoice', '$id')" ;

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
///////////////////ACCOUNT RECEIVABLE////////////////////
$sqli1="INSERT INTO `journal` (`date`, `number`, `account`, `debit`, `transaction_id`, `type`, `company_email`) VALUES ('$date', '$transaction_number', '$receivable_account_id', '$total', '$id', 'Invoice', '$company_email')";
$conn->query($sqli1) ;
///////////////////ACCOUNT RECEIVABLE////////////////////

///////////////////DISCOUNT////////////////////
$sqli2="INSERT INTO `journal` (`date`, `number`, `account`, `debit`, `transaction_id`, `type`, `company_email`) VALUES ('$date', '$transaction_number', '$discount_account', '$disc_amount', '$id', 'Invoice', '$company_email')";
$conn->query($sqli2) ;
///////////////////DISCOUNT////////////////////

///////////////////INCOME////////////////////
$sql_new = "SELECT SUM(amount) AS `amount_one`, `income_account_id` FROM `sales_item` WHERE `sales_id` = '$id' AND `item_category` = 'Inventory' GROUP BY `cogs_id`";
$new_new = $conn->query($sql_new) ;
while($row = $new_new->fetch_assoc()){
  $amount_one = $row['amount_one'];
  $income_account_id = $row['income_account_id'];
$sqli3="INSERT INTO `journal` (`date`, `number`, `account`, `credit`, `transaction_id`, `type`, `company_email`) VALUES ('$date', '$transaction_number', '$income_account_id', '$amount_one', '$id', 'Invoice', '$company_email')";
$conn->query($sqli3) ;
}
///////////////////INCOME////////////////////

///////////////////EXPENSE////////////////////
$sql_new = "SELECT SUM(amount) AS `amount_one`, `exp_account_id` FROM `sales_item` WHERE `sales_id` = '$id' AND `item_category` != 'Inventory' GROUP BY `cogs_id`";
$new_new = $conn->query($sql_new) ;
while($row = $new_new->fetch_assoc()){
  $amount_one = $row['amount_one'];
  $exp_account_ids = $row['exp_account_id'];
$sqli4="INSERT INTO `journal` (`date`, `number`, `account`, `credit`, `transaction_id`, `type`, `company_email`) VALUES ('$date', '$transaction_number', '$exp_account_ids', '$amount_one', '$id', 'Invoice', '$company_email')";
$conn->query($sqli4) ;
}
///////////////////EXPENSE////////////////////

///////////////////VAT////////////////////
$sql_new = "SELECT SUM(vat_amount) AS `vat_amount_tot`, `vat_id` FROM `sales_item` WHERE `sales_id` = '$id' GROUP BY `vat_id`";
$new_new = $conn->query($sql_new) ;
while($row = $new_new->fetch_assoc()){
$vat_amount_tot = $row['vat_amount_tot'];
$vat = $row['vat_id'];
$sql = "SELECT * FROM `vat` WHERE `id` = '$vat' AND `category` = 'sales' AND `company_email` = '$company_email'";
$new = $conn->query($sql) ;
while($rowsd = $new->fetch_assoc()){
$vat_number_id = $rowsd['account'];
$sqli4="INSERT INTO `journal` (`date`, `number`, `account`, `credit`, `transaction_id`, `type`, `company_email`) VALUES ('$date', '$transaction_number', '$vat_number_id', '$vat_amount_tot', '$id', 'Invoice', '$company_email')";
$conn->query($sqli4) ;
}
}
///////////////////VAT////////////////////

///////////////////INVENTORY////////////////////
$sql_new = "SELECT SUM(cogs) AS `cost_of_gs`, `inventory_id` FROM `sales_item` WHERE `sales_id` = '$id' AND `item_category` = 'Inventory' GROUP BY `inventory_id`";
$new_new = $conn->query($sql_new) ;
while($row = $new_new->fetch_assoc()){
  $cost_of_gs = $row['cost_of_gs'];
  $inventory_id = $row['inventory_id'];
$sqli6="INSERT INTO `journal` (`date`, `number`, `account`, `credit`, `transaction_id`, `type`, `company_email`) VALUES ('$date', '$transaction_number', '$inventory_id', '$cost_of_gs', '$id', 'Invoice', '$company_email')";
$conn->query($sqli6) ;
}
///////////////////INVENTORY////////////////////

///////////////////COGS////////////////////
$sql_new = "SELECT SUM(cogs) AS `cost_of_gs`, `cogs_id` FROM `sales_item` WHERE `sales_id` = '$id' AND `item_category` = 'Inventory' GROUP BY `cogs_id`";
$new_new = $conn->query($sql_new) ;
while($row = $new_new->fetch_assoc()){
  $cost_of_gs = $row['cost_of_gs'];
  $cogs_id = $row['cogs_id'];
$sqli7="INSERT INTO `journal` (`date`, `number`, `account`, `debit`, `transaction_id`, `type`, `company_email`) VALUES ('$date', '$transaction_number', '$cogs_id', '$cost_of_gs', '$id', 'Invoice', '$company_email')";
$conn->query($sqli7) ;
}
///////////////////COGS////////////////////
/***********************************************************JOURNAL ENTRIES****************************************************/

} else {
    echo "Error: " . $sqli . "<br>" . mysqli_error($conn);
}

}


/*********************************************************************************************/

/*********************************************************************************************/
/*********************************************************************************************
										create Customer Payment
*********************************************************************************************/
/*********************************************************************************************/
if(isset($_POST['entry_type']) && $_POST['entry_type'] =='create Customer Payment'){

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
$sqliven="SELECT * FROM `customer` WHERE `company_email` = '$company_email' AND `id` = '$name_id'";
$newven = $conn->query($sqliven);
$rowven = $newven->fetch_assoc();
$receivable_account_id = $rowven['payable_account'];

$transaction_number = $trnsction_array['transaction_number'];
$notes = $trnsction_array['notes'];
$due_amt = $trnsction_array['due_amt'];
$disc_rate = $trnsction_array['disc_rate'];
$disc_amount = $trnsction_array['disc_amount'];
$discount_account = $trnsction_array['discount_account'];
$vat = $trnsction_array['vat'];
$total = $trnsction_array['total'];
$credit = $trnsction_array['credit'];

$datee = json_decode($_POST['invoices']);
$dates =  arraytoarray($datee);





 $sql = "UPDATE `transaction` SET `name` = '$name', `bank_id` = '$bank_id', `cheque_no` = '$cheque_no', `date` = '$date', `transaction_number` = '$transaction_number', `notes` = '$notes' , `due_amt` = '$due_amt', `disc_rate` = '$disc_rate', `disc_amount` = '$disc_amount', `discount_account` = '$discount_account', `total` = '$total', `credit` = '$credit' WHERE `id` = '$id' AND  `company_email` = '$company_email'" ;

 if (mysqli_query($conn, $sql)) {

$sqli="SELECT * FROM `customer_payment_list` WHERE `company_email` = '$company_email' AND `customer_payment_list_id` = '$id'";
$new = $conn->query($sqli) ;
while ($row = $new->fetch_assoc()) {
$delete_transaction_no = $row['invoice_no'];
$delete_discount_amount = $row['discount_amount'];
$delete_received = $row['received'];
$deduct_value = $delete_received + $delete_discount_amount;
$sqli5="UPDATE `transaction` SET , `due_amt` = `due_amt` + '$deduct_value' WHERE `company_email` = '$company_email' AND `transaction_number` = '$delete_transaction_no' AND `entry_type` = 'create Customer Payment'";
$conn->query($sqli5) ;
}
$sqli5="DELETE FROM `customer_payment_list` WHERE `company_email` = '$company_email' AND `customer_payment_list_id` = '$id'";
$conn->query($sqli5) ;

 $check_size = sizeof($dates);
for($i=0; $i<$check_size; $i++ ){

$date_array =  (array) $dates[$i];
  $payment_id = $date_array['id'];
$invoice_no = $date_array['transaction_number'];
$total = $date_array['total'];
$discount_amount = $date_array['discount_amount'];
 $due_amount = $date_array['due_amt'];
$received = $date_array['paid'];
$credit_amount = $date_array['credit_amount'];
$discount_rate = (100 * $discount_amount)/$total;

 


$sqli="INSERT INTO `customer_payment_list` (`dates`, `invoice_no`, `total`, `discount_rate`, `discount_amount`, `credit_amount`, `due_amount`, `received`, `customer_payment_list_id`, `company_email`) VALUES ('$date', '$invoice_no', '$total', '$discount_rate', '$discount_amount', '$credit_amount', '$due_amount', '$received', '$id', '$company_email')";
 $conn->query($sqli) ;
$new_due_amount = $due_amount - ($discount_amount + $received);
$sqli = "UPDATE `transaction` SET `due_amt` = '$new_due_amount' WHERE `company_email` = '$company_email' AND `transaction_number` = '$invoice_no' AND `entry_type` = 'create purchase invoice' ";
$conn->query($sqli) ;
}
///////////////////*****************/////////////// DELETE JOURNAL///////////////////*****************///////////////
$sqli="DELETE FROM `journal` WHERE `transaction_id` = '$id'" ;
$conn->query($sqli) or die(mysqli_error());
///////////////////*****************/////////////// DELETE JOURNAL///////////////////*****************///////////////

///////////////////BANK////////////////////
$sqli2="INSERT INTO `journal` (`date`, `number`, `account`, `debit`, `transaction_id`, `type`, `company_email`) VALUES ('$date', '$transaction_number', '$bank_id', '$total', '$id', 'Payment', '$company_email')";
$conn->query($sqli2) ;
///////////////////BANK////////////////////
///////////////////DISCOUNT////////////////////
$sqli2="INSERT INTO `journal` (`date`, `number`, `account`, `debit`, `transaction_id`, `type`, `company_email`) VALUES ('$date', '$transaction_number', '$discount_account', '$disc_amount', '$id', 'Payment', '$company_email')";
$conn->query($sqli2) ;
///////////////////DISCOUNT////////////////////
///////////////////RECEIVABLE////////////////////
$receivable = $total + $disc_amount;
$sqli2="INSERT INTO `journal` (`date`, `number`, `account`, `credit`, `transaction_id`, `type`, `company_email`) VALUES ('$date', '$transaction_number', '$receivable_account_id', '$total', '$id', 'Payment', '$company_email')";
$conn->query($sqli2) ;
///////////////////RECEIVABLE////////////////////

} else {
  echo "hadd h yeee ab to thak gaya hu";
    echo "Error: " . $sql . "<br>" . mysqli_error($conn);
}

}
/*********************************************************************************************/
/*********************************************************************************************
										create sales return
*********************************************************************************************/
/*********************************************************************************************/
if(isset($_POST['entry_type']) && $_POST['entry_type'] =='create sales return'){
$trnsction = json_decode($_POST['trnsction']);
$adjustment = convert_to_array($_POST['adjustment']);

$trnsction_array = (array) $trnsction;

$id = $trnsction_array['id'];
$name = $trnsction_array['customer_name'];
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

$sqlv="SELECT * FROM `customer` WHERE `id` = '$name_id'";
$newv=$conn->query($sqlv); 
while($rowv = $newv->fetch_assoc()){
$receivable_account_id = $rowv['payable_account'];
}

$items = json_decode($_POST['items']);
$items =  arraytoarray($items);
$sql="UPDATE `transaction` SET  `entry_type` = 'create sales return', `cat_type` = 'sales', `name` = '$name', `name_id` = '$name_id', `date` = '$date', `transaction_number` = '$transaction_number', `return_type` = '$return_type', `bank_id` =  '$bank_id', `cheque_no` = '$cheque_no',  
`notes` = '$notes', `subtotal` = '$subtotal', `disc_rate` =  '$disc_rate', `disc_amount` = '$disc_amount', `discount_account` = '$discount_account', `vat` =  '$vatt' ,`total` = '$total', `company_email` = '$company_email' WHERE `id` = '$id'" ;


if (mysqli_query($conn, $sql)) {
  $result="UPDATE `customer` SET `credit` = `credit`+('$credit' - (SELECT `credit` FROM transaction WHERE id = '$id' AND `company_email` = '$company_email')) WHERE `company_email` = '$company_email' AND `id` = (SELECT `name_id` FROM transaction WHERE transaction.id = '$id' AND `company_email` = '$company_email')" ;
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

$sql20="SELECT * FROM `sales_item` WHERE `sales_id` = '$id'";
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

$conn->query("DELETE FROM `sales_item` WHERE `sales_id` = '$id'"); 
$check_size = sizeof($items);
for($i=0; $i<$check_size; $i++ ){

$item_array =  (array) $items[$i];
$sales_id = $item_array['id'];
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
$cogs = $row21['weighted_price'] * $item_quantity;
$asset_value = $row21['asset_value'] + $cogs;
$weight_avg = $row21['weighted_price'];
}
}
$sqli="INSERT INTO `sales_item` (`date` , `item_name`, `item_id`, `item_category`, `item_description`, `item_quantity`, `price_rate`, `discount_rate`, `amount`, `vat`, `vat_id`, `vat_amount`, `asset_value`, `qty`, `cogs`, `weight_avg`, `exp_account_id`, `income_account_id`, `cogs_id`, `inventory_id`, `company_email`, `type`, `sales_id`) VALUES ('$date', '$item_name', '$item_id', '$type', '$item_description', '$item_quantity', '$price_rate', '$discount_rate', '$amount', '$vat', '$vat_id', '$vat_amount', '$asset_value', '$qty', '$cogs', '$weight_avg', '$exp_account_id', '$inc_account_id', '$cogs_id', '$inv_asset_id', '$company_email', 'create sales return', '$id')" ;
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

///////////////////ACCOUNT RECEIVABLE////////////////////
$sqli1="INSERT INTO `journal` (`date`, `number`, `account`, `credit`, `transaction_id`, `type`, `company_email`) VALUES ('$date', '$transaction_number', '$receivable_account_id', '$total', '$id', 'Return', '$company_email')";
$conn->query($sqli1);
///////////////////ACCOUNT RECEIVABLE////////////////////

///////////////////DISCOUNT////////////////////
$sqli2="INSERT INTO `journal` (`date`, `number`, `account`, `credit`, `transaction_id`, `type`, `company_email`) VALUES ('$date', '$transaction_number', '$discount_account', '$disc_amount', '$id', 'Return', '$company_email')";
$conn->query($sqli2) ;
///////////////////DISCOUNT////////////////////

///////////////////INCOME////////////////////
$sql_new = "SELECT SUM(amount) AS `amount_one`, `income_account_id` FROM `sales_item` WHERE `sales_id` = '$id' AND `item_category` = 'Inventory' GROUP BY `cogs_id`";
$new_new = $conn->query($sql_new) ;
while($row = $new_new->fetch_assoc()){
  $amount_one = $row['amount_one'];
  $income_account_id = $row['income_account_id'];
$sqli3="INSERT INTO `journal` (`date`, `number`, `account`, `debit`, `transaction_id`, `type`, `company_email`) VALUES ('$date', '$transaction_number', '$income_account_id', '$amount_one', '$id', 'Return', '$company_email')";
$conn->query($sqli3) ;
}
///////////////////INCOME////////////////////

///////////////////VAT////////////////////
$sql_new = "SELECT SUM(vat_amount) AS `vat_amount_tot`, `vat_id` FROM `sales_item` WHERE `sales_id` = '$id' GROUP BY `vat_id`";
$new_new = $conn->query($sql_new) ;
while($row = $new_new->fetch_assoc()){
$vat_amount_tot = $row['vat_amount_tot'];
$vat = $row['vat_id'];
$sql = "SELECT * FROM `vat` WHERE `id` = '$vat' AND `category` = 'sales' AND `company_email` = '$company_email'";
$new = $conn->query($sql) ;
while($rowsd = $new->fetch_assoc()){
$vat_number_id = $rowsd['account'];
$sqli4="INSERT INTO `journal` (`date`, `number`, `account`, `debit`, `transaction_id`, `type`, `company_email`) VALUES ('$date', '$transaction_number', '$vat_number_id', '$vat_amount_tot', '$id', 'Return', '$company_email')";
$conn->query($sqli4) ;
}
}
///////////////////VAT////////////////////

///////////////////COGS////////////////////
$sql_new = "SELECT SUM(cogs) AS `cost_of_gs`, `cogs_id` FROM `sales_item` WHERE `sales_id` = '$id' AND `item_category` = 'Inventory' GROUP BY `cogs_id`";
$new_new = $conn->query($sql_new) ;
while($row = $new_new->fetch_assoc()){
  $cost_of_gs = $row['cost_of_gs'];
  $cogs_id = $row['cogs_id'];
$sqli6="INSERT INTO `journal` (`date`, `number`, `account`, `credit`, `transaction_id`, `type`, `company_email`) VALUES ('$date', '$transaction_number', '$cogs_id', '$cost_of_gs', '$id', 'Return', '$company_email')";
$conn->query($sqli6) ;
}
///////////////////COGS////////////////////

///////////////////INVENTORY////////////////////
$sql_new = "SELECT SUM(cogs) AS `cost_of_gs`, `inventory_id` FROM `sales_item` WHERE `sales_id` = '$id' AND `item_category` = 'Inventory' GROUP BY `inventory_id`";
$new_new = $conn->query($sql_new) ;
while($row = $new_new->fetch_assoc()){
  $cost_of_gs = $row['cost_of_gs'];
  $inventory_id = $row['inventory_id'];
$sqli5="INSERT INTO `journal` (`date`, `number`, `account`, `debit`, `transaction_id`, `type`, `company_email`) VALUES ('$date', '$transaction_number', '$inventory_id', '$cost_of_gs', '$id', 'Return', '$company_email')";
$conn->query($sqli5) ;
}
///////////////////INVENTORY////////////////////

///////////////////EXPENSE////////////////////
$sql_new = "SELECT SUM(amount) AS `amount_one`, `exp_account_id` FROM `sales_item` WHERE `sales_id` = '$id' AND `item_category` != 'Inventory' GROUP BY `cogs_id`";
$new_new = $conn->query($sql_new) ;
while($row = $new_new->fetch_assoc()){
  $amount_one = $row['amount_one'];
  $exp_account_ids = $row['exp_account_id'];
$sqli4="INSERT INTO `journal` (`date`, `number`, `account`, `debit`, `transaction_id`, `type`, `company_email`) VALUES ('$date', '$transaction_number', '$exp_account_ids', '$amount_one', '$id', 'Return', '$company_email')";
$conn->query($sqli4) ;
}
///////////////////EXPENSE////////////////////

if($_POST['return_type'] != 'On Account'){
$sqli1="INSERT INTO `journal` (`date`, `number`, `account`, `debit`, `transaction_id`, `type`, `company_email`) VALUES ('$date', '$transaction_number', '$receivable_account_id', '$bank_total', '$id', 'Return', '$company_email')";
$conn->query($sqli1) ;

$sqli11="INSERT INTO `journal` (`date`, `number`, `account`, `credit`, `transaction_id`, `type`, `company_email`) VALUES ('$date', '$transaction_number', '$bank_id', '$bank_total', '$id', 'Return', '$company_email')";
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

