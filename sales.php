<?php
include('db.php');
//if(isset($_POST['submit'])){
function arraytoarray($item_name){
$a = array();
foreach($item_name as $cur)
{
 array_push($a,$cur);
}
return $a;
}


/*********************************************************************************************/
/*********************************************************************************************
										Create sales order
*********************************************************************************************/
/*********************************************************************************************/
if(isset($_POST['entry_type']) && $_POST['entry_type'] =='Create sales order'){

$name = $_POST['name'];
$so_po_no = $_POST['so_po_no'];
$date = $_POST['date'];
$date = date('Y-m-d', strtotime($date));

$transaction_number = $_POST['transaction_number'];
$payment_term = $_POST['payment_term'];
$notes = $_POST['notes'];
$subtotal = $_POST['subtotal'];
if($_POST['disc_rate']=='undefined'){
    $disc_rate = 0;
}else{
    $disc_rate = $_POST['disc_rate'];
}
if($_POST['disc_amount']=='undefined'){
    $disc_amount = 0;
}else{
    $disc_amount = $_POST['disc_amount'];
}
$discount_account = $_POST['discount_account'];
$vatt = $_POST['vatt'];
$total = $_POST['total'];
$time_period = $_POST['time_period'];
$category = $_POST['category'];
$delivery_status = $_POST['delivery_status'];
$billing_status = $_POST['billing_status'];

$sub_disc = $subtotal - $disc_amount;

$item_name = json_decode($_POST['item_name']);
$item_names =  arraytoarray($item_name);
$customer = json_decode($_POST['customer']);
$customer =  (array) $customer;
$name_id = $customer['id'];


$sql="INSERT INTO `transaction` (`entry_type`, `cat_type`, `name`, `name_id`, `so_po_no`, `date`, `transaction_number`, `payment_term`, `notes`, `subtotal`, `disc_rate`, `disc_amount`, `discount_account`, `vat`, `total`, `company_email`) VALUES ('Create sales order', 'sales order', '$name', '$name_id', '$so_po_no', '$date', '$transaction_number', '$payment_term', '$notes', '$subtotal', '$disc_rate', '$disc_amount', '$discount_account', '$vatt', '$total', '$company_email')";
//error_log($sql);
if (mysqli_query($conn, $sql)) {
echo $last_id = mysqli_insert_id($conn);

//////////////////////////////////////////////////////////////////////////////////////////
$condition = basename($_FILES["file"]["name"]);
if(isset($condition)){
$target_dir = "emoji/".$name.'/';
$target_file = $target_dir.$last_id. basename($_FILES["file"]["name"]);
if (!file_exists('/'.$target_dir)) {
mkdir('./'.$target_dir, 0777, true);
move_uploaded_file($_FILES["file"]["tmp_name"], $target_file);
} else {
move_uploaded_file($_FILES["file"]["tmp_name"], $target_file);
}
$fname = $target_file;
$sqlz="UPDATE `transaction` SET `file_url` = '$fname' WHERE `id` = '$last_id'";
$conn->query($sqlz);
}
//////////////////////////////////////////////////////////////////////////////////////////

 $check_size = sizeof($item_names);
for($i = 0; $i < $check_size; $i++ ){
$item_row = (array)$item_names[$i];
if ($item_row['name'] != '') {
$item_name = $item_row['name'];
$item_id = $item_row['id '];
$item_category = $item_row['category'];
$item_description = $item_row['description'];
$item_quantity = $item_row['item_quantity'];
$price_rate = $item_row['sale_price'];
$discount_rate = $item_row['discount_rate'];
$amount = $item_row['amount'];
$vat = $item_row['sale_tax'];
$vat_id = $item_row['sale_tax_id'];
$date_time=time();
$vat_amount = ($amount*$vat)/100;





$sqli="INSERT INTO `sales_item` (`item_name`, `item_id`, `item_category`, `item_description`, `item_quantity`, `price_rate`, `discount_rate`, `amount`, `vat`, `vat_id`, `vat_amount`, `sales_id`, `cogs`, `company_email`, `type`) VALUES ('$item_name', '$item_id', '$item_category', '$item_description', '$item_quantity', '$price_rate', '$discount_rate', '$amount', '$vat', '$vat_id', '$vat_amount', '$last_id', '$cogs', '$company_email', 'Create sales order')";


$conn->query($sqli) ;
//echo "done";
}
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
$email = $_POST['email'];
$address = $_POST['address'];
$city = $_POST['city'];
$state = $_POST['state'];
$country = $_POST['country'];
$ship = $_POST['ship'];
if($ship == 'false'){
$shipping_address = $_POST['shipping_address'];
$shipping_city = $_POST['shipping_city'];
$shipping_state = $_POST['shipping_state'];
$shipping_country = $_POST['shipping_country'];
}else{
$shipping_address = $_POST['address'];
$shipping_city = $_POST['city'];
$shipping_state = $_POST['state'];
$shipping_country = $_POST['country'];
}
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
$opening_data = date('Y-m-d', $_POST['opening_date']);
$customer_type = $_POST['customer_type'];
$new = $conn->query("SELECT COUNT(*) AS `count` FROM `customer` WHERE `company_name` = '$company_name' AND `company_email` = '$company_email'");
while($row = $new->fetch_assoc()){
if($row['count'] == '0'){

$result="INSERT INTO `customer` (`company_name`, `opening_balance`, `opening_date`, `email`, `address`, `city`, `state`, `country`, `shipping_address`, `shipping_city`, `shipping_state`, `shipping_country`, `contact_name`, `phone`, `mobile`, `tax_number`, `payment_term`, `vat`, `vat_number`, `customer_code`, `payable_account`, `notes`, `company_email`, `customer_type`) VALUES ('$company_name', '$opening_balance', '$opening_data', '$email', '$address', '$city', '$state', '$country', '$shipping_address', '$shipping_city', '$shipping_state', '$shipping_country', '$contact_name', '$phone', '$mobile', '$tax_number', '$payment_term', '$vat', '$vat_number', '$customer_code', '$payable_account', '$notes', '$company_email', '$customer_type')";
   
//echo "<script>alert(".$name.");</script>";
error_log($result);
$new = $conn->query($result) or die (mysqli_error());	
$last_id = $conn->insert_id;
$date = $opening_data;
	$sqls="INSERT INTO `transaction` (`entry_type`, `cat_type`, `name_id`, `name`, `total`, `date`, `company_email`, `transaction_number`) VALUES ('Journal', 'Journal', '$last_id', 'customer', '$opening_balance', '$date', '$company_email', '')";

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
}
} 

/*********************************************************************************************/

/*********************************************************************************************/
/*********************************************************************************************
										create Customer Payment
*********************************************************************************************/
/*********************************************************************************************/
if(isset($_POST['entry_type']) && $_POST['entry_type'] =='create Customer Payment'){

$name = $_POST['name'];
$bank_id = $_POST['bank_id'];
$cheque_no = $_POST['cheque_no'];
$date = $_POST['date'];
$date = date('Y-m-d', strtotime($date));

$transaction_number = $_POST['transaction_number'];
$notes = $_POST['notes'];
$subtotal = $_POST['subtotal'];
$disc_rate = $_POST['disc_rate'];
$disc_amount = $_POST['disc_amount'];
$discount_account = $_POST['discount_account'];
$vat = $_POST['vat'];
$total = $_POST['total'];
//$payments = convert_to_array($_POST['payments']);

$sub_disc = $subtotal - $disc_amount;

$datte = json_decode($_POST['dates']);
$dates =  arraytoarray($datte);
$customer = json_decode($_POST['customer']);
$customer =  (array) $customer;
$name_id = $customer['id'];
$receivable_account_id = $customer['payable_account'];
$credit_adjstment = $_POST['credit_adjstment'];


$newing = $conn->query("SELECT COUNT(*) AS `count` FROM `transaction` WHERE `transaction_number` = '$transaction_number' AND `entry_type` = 'create Customer Payment' AND `company_email` = '$company_email'");
$rowing = $newing->fetch_assoc();
if($rowing['count'] == '0'){

$sql="INSERT INTO `transaction` (`entry_type`, `cat_type`, `name`, `name_id`, `bank_id`, `cheque_no`, `date`, `transaction_number`, `notes`, `subtotal`, `disc_rate`, `disc_amount`, `discount_account`, `vat`, `total`, `total_no_vat`, `credit`, `company_email`) VALUES ('create Customer Payment', 'Customer Payment', '$name', '$name_id', '$bank_id', '$cheque_no', '$date', '$transaction_number', '$notes', '$subtotal', '$disc_rate', '$disc_amount', '$discount_account', '$vat', '$total', '$sub_disc', '$credit_adjstment', '$company_email')";

if (mysqli_query($conn, $sql)) {
 echo $last_id = mysqli_insert_id($conn);
 $result="UPDATE `customer` SET `credit` = `credit`-'$credit_adjstment' WHERE `company_email` = '$company_email' AND `id` = '$name_id'" ;
$conn->query($result);
//////////////////////////////////////////////////////////////////////////////////////////
$condition = basename($_FILES["file"]["name"]);
if(isset($condition)){
$target_dir = "emoji/".$name.'/';
$target_file = $target_dir.$last_id. basename($_FILES["file"]["name"]);
if (!file_exists('/'.$target_dir)) {
mkdir('./'.$target_dir, 0777, true);
move_uploaded_file($_FILES["file"]["tmp_name"], $target_file);
} else {
move_uploaded_file($_FILES["file"]["tmp_name"], $target_file);
}
$fname = $target_file;
$sqlz="UPDATE `transaction` SET `file_url` = '$fname' WHERE `id` = '$last_id'";
$conn->query($sqlz);
}
//////////////////////////////////////////////////////////////////////////////////////////
$check_size = sizeof($dates);
$credit_amount_total = 0;
for($i = 0; $i < $check_size; $i++ ){
	$item_row = (array)$dates[$i];
	if ($item_row['transaction_number'] != '') {
		$date = $_POST['date'];
		$date = date('Y-m-d', strtotime($date));
		$invoice_no = $item_row['transaction_number'];
		$total = $item_row['total'];
		$discount_rate = $item_row['discount_amount'];
		$due_amount = $item_row['due_amt'];
		$received = $item_row['paid'];
		$discount_amount = $item_row['discount_amount'];
		$credit_amount = $item_row['credit_amount'];
		$transaction_id = $item_row['id']; 
		$payments = $item_row['credit_list'];
			if(($discount_amount == '0' || $discount_amount == '' ) && ($received == '0' || $received == '') && ($credit_amount == '0' || $credit_amount == '' )){
			}else{
				$credit_amount_total += $item_row['credit_amount'];
				$sqli="INSERT INTO `customer_payment_list` (`dates`, `invoice_no`, `total`, `discount_rate`, `discount_amount`, `credit_amount`, `due_amount`, `received`, `customer_payment_list_id`, `company_email`) VALUES ('$datess', '$invoice_no', '$total', '$discount_rate', '$discount_amount', '$credit_amount', '$due_amount', '$received', '$last_id', '$company_email')";

				$conn->query($sqli) ;
				$ss_id = $conn->insert_id;
				$new_due_amount = $due_amount - ($discount_amount + $received + $credit_amount);
				$sqli = "UPDATE `transaction` SET `due_amt` = '$new_due_amount' WHERE `id` = '$transaction_id' ";
				$conn->query($sqli) ;
				foreach ($payments as $keys) {
					$key = (array)$keys;
					if ($credit_adjus_now!=0) {
						$t_id = $key['id'];
						$t_inuse = $key['inuse'];
						$result="UPDATE `transaction` SET `credit` = `credit`-'$t_inuse' WHERE `company_email` = '$company_email' AND `id` = '$t_id'" ;
						$conn->query($result);
						$result="INSERT INTO `invoice_adjustments` (`transaction_id`, `invoice_id`, `adjust_invoice_id`, `adjust_amt`, `company_email`) VALUES ('$last_id', '$t_id', '$ss_id', '$t_inuse', '$company_email')";
						$conn->query($result);
						$t_inuse=0;
					}
				}
			}

	}
}
} else {
    echo "Error: " . $sql . "<br>" . mysqli_error($conn);
}
}
}

/*********************************************************************************************/
/*********************************************************************************************
										create sales invoice
*********************************************************************************************/
/*********************************************************************************************/
if(isset($_POST['entry_type']) && $_POST['entry_type'] =='create sales invoice'){

$name = $_POST['name'];
$payment_term = $_POST['payment_term'];
$date = $_POST['date'];
$date = date('Y-m-d', strtotime($date));

$transaction_number = $_POST['transaction_number'];
$so_po_no = $_POST['so_po_no'];
$due_date = $_POST['due_date'];
$notes = $_POST['notes'];
$subtotal = $_POST['subtotal'];
$disc_rate = $_POST['disc_rate'];
$disc_amount = $_POST['disc_amount'];
$discount_account = $_POST['discount_account'];
$vatt = $_POST['vatt'];
$total = $_POST['total'];

$sub_disc = $subtotal - $disc_amount;

$item_name = json_decode($_POST['item_name']);
$item_names =  arraytoarray($item_name);

$customer = json_decode($_POST['customer']);
$customer =  (array) $customer;
$name_id = $customer['id'];
$receivable_account_id = $customer['payable_account'];
$vat_number_id = $customer['vat_number'];

$date_time=time();

$newing = $conn->query("SELECT COUNT(*) AS `count` FROM `transaction` WHERE `transaction_number` = '$transaction_number' AND `entry_type` = 'create sales invoice' AND `company_email` = '$company_email'");
$rowing = $newing->fetch_assoc();
if($rowing['count'] == '0'){

$sql="INSERT INTO `transaction` (`entry_type`, `cat_type`, `name`, `name_id`, `payment_term`, `date`, `transaction_number`, `so_po_no`, `due_date`, `notes`, `subtotal`, `disc_rate`, `disc_amount`, `discount_account`, `vat`, `total`, `total_no_vat`, `due_amt`, `company_email`, `date_time`) VALUES ('create sales invoice', 'sales invoice', '$name', '$name_id', '$payment_term', '$date', '$transaction_number', '$so_po_no', '$due_date', '$notes', '$subtotal', '$disc_rate', '$disc_amount', '$discount_account', '$vatt', '$total', '$sub_disc', '$total', '$company_email', '$date_time')";

if (mysqli_query($conn, $sql)) {
  echo  $last_id = mysqli_insert_id($conn);
 //////////////////////////////////////////////////////////////////////////////////////////
$condition = basename($_FILES["file"]["name"]);
if(isset($condition)){
$target_dir = "emoji/".$name.'/';
$target_file = $target_dir.$last_id. basename($_FILES["file"]["name"]);
if (!file_exists('/'.$target_dir)) {
mkdir('./'.$target_dir, 0777, true);
move_uploaded_file($_FILES["file"]["tmp_name"], $target_file);
} else {
move_uploaded_file($_FILES["file"]["tmp_name"], $target_file);
}
$fname = $target_file;
$sqlz="UPDATE `transaction` SET `file_url` = '$fname' WHERE `id` = '$last_id'";
$conn->query($sqlz);
}
//////////////////////////////////////////////////////////////////////////////////////////

$check_size = sizeof($item_names);
for($i = 0; $i < $check_size; $i++ ){
$item_row = (array)$item_names[$i];
if ($item_row['name'] != '') {
$item_name = $item_row['name'];
$item_id = $item_row['id'];
$item_category = $item_row['category'];
$cogs_id = $item_row['cogs'];
$inv_asset_id = $item_row['inv_asset'];
$inc_account_id = $item_row['inc_account'];
$exp_account_id = $item_row['exp_account'];
$item_description = $item_row['description'];
$item_quantity = $item_row['item_quantity'];
$price_rate = $item_row['sale_price'];
$discount_rate = $item_row['discount_rate'];
$amount = $item_row['amount'];
$vat = $item_row['sale_tax'];
$vat_id = $item_row['sale_tax_id'];
 $date_time=time();
$vat_amount = ($amount*$vat)/100;

$category_item = $item_row['category'];

if($item_row['category']=='Inventory'){

$qty = $item_row['stock'] - $item_quantity;
$cogs = $item_row['weighted_price'] * $item_quantity;
$asset_value = $item_row['asset_value'] - $cogs;
$weight_avg = $item_row['weighted_price'];
}

$sqli="INSERT INTO `sales_item` (`date`, `item_name`, `item_id`, `item_category`, `item_description`, `item_quantity`, `price_rate`, `discount_rate`, `amount`, `vat`, `vat_id`, `vat_amount`, `asset_value`, `qty`, `cogs`, `weight_avg`, `sales_id`, `exp_account_id`, `income_account_id`, `cogs_id`, `inventory_id`, `company_email`, `type`) VALUES ('$date', '$item_name', '$item_id', '$item_category', '$item_description', '$item_quantity', '$price_rate', '$discount_rate', '$amount', '$vat', '$vat_id', '$vat_amount', '$asset_value', '$qty', '$cogs', '$weight_avg', '$last_id', '$exp_account_id', '$inc_account_id', '$cogs_id', '$inv_asset_id', '$company_email', 'create sales invoice')";
$conn->query($sqli) ;

if($item_row['category']=='Inventory'){
$sqli = "UPDATE `items` SET `stock` = `stock` - '$item_quantity', `asset_value` = '$asset_value', `weighted_price` = '$weight_avg' WHERE `id` = '$item_id' ";
$conn->query($sqli) ;
$cogs = '0';
$asset_value = '0';
$weight_avg = '0';
$qty = '0';

}
}
}
} else {
    echo "Error: " . $sql . "<br>" . mysqli_error($conn);
}
}
}

/*********************************************************************************************/
/*********************************************************************************************
										create sales Receipt
*********************************************************************************************/
/*********************************************************************************************/
if(isset($_POST['entry_type']) && $_POST['entry_type'] =='create sales Receipt'){

$name = $_POST['name'];
$date = $_POST['date'];
$date = date('Y-m-d', strtotime($date));

$transaction_number = $_POST['transaction_number'];
$bank_id = $_POST['bank_id'];
$cheque_no = $_POST['cheque_no'];
$notes = $_POST['notes'];
$subtotal = $_POST['subtotal'];
$disc_rate = $_POST['disc_rate'];
$disc_amount = $_POST['disc_amount'];
$discount_account = $_POST['discount_account'];
$vatt = $_POST['vatt'];
$total = $_POST['total'];

$bank_total = $total - $vatt;
$sub_disc = $subtotal - $disc_amount;

$item_name = json_decode($_POST['item_name']);
$item_names =  arraytoarray($item_name);
$customer = json_decode($_POST['customer']);
$customer =  (array) $customer;
$name_id = $customer['id'];
$receivable_account_id = $customer['payable_account'];
$vat_number_id = $customer['vat_number'];


$date_time=time();
$newing = $conn->query("SELECT COUNT(*) AS `count` FROM `transaction` WHERE `transaction_number` = '$transaction_number' AND `entry_type` = 'create sales Receipt' AND `company_email` = '$company_email'");
$rowing = $newing->fetch_assoc();
if($rowing['count'] == '0'){

$sql="INSERT INTO `transaction` (`entry_type`, `cat_type`, `name`, `name_id`, `date`, `transaction_number`, `bank_id`, `cheque_no`, `notes`, `subtotal`, `disc_rate`, `disc_amount`, `discount_account`, `vat`, `total`, `total_no_vat`, `company_email`, `date_time`) VALUES ('create sales Receipt', 'sales Receipt', '$name', '$name_id', '$date', '$transaction_number', '$bank_id', '$cheque_no', '$notes', '$subtotal', '$disc_rate', '$disc_amount', '$discount_account', '$vatt', '$total', '$sub_disc', '$company_email', '$date_time')";

if (mysqli_query($conn, $sql)) {
 echo $last_id = mysqli_insert_id($conn);

//////////////////////////////////////////////////////////////////////////////////////////
$condition = basename($_FILES["file"]["name"]);
if(isset($condition)){
$target_dir = "emoji/".$name.'/';
$target_file = $target_dir.$last_id. basename($_FILES["file"]["name"]);
if (!file_exists('/'.$target_dir)) {
mkdir('./'.$target_dir, 0777, true);
move_uploaded_file($_FILES["file"]["tmp_name"], $target_file);
} else {
move_uploaded_file($_FILES["file"]["tmp_name"], $target_file);
}
$fname = $target_file;
$sqlz="UPDATE `transaction` SET `file_url` = '$fname' WHERE `id` = '$last_id'";
$conn->query($sqlz);
}
//////////////////////////////////////////////////////////////////////////////////////////

$check_size = sizeof($item_names);
for($i = 0; $i < $check_size; $i++ ){
$item_row = (array)$item_names[$i];
if ($item_row['name'] != '') {
$item_name = $item_row['name'];
$item_id = $item_row['id'];
$item_category = $item_row['category'];
$cogs_id = $item_row['cogs'];
$inv_asset_id = $item_row['inv_asset'];
$inc_account_id = $item_row['inc_account'];
$exp_account_id = $item_row['exp_account'];
$item_description = $item_row['description'];
$item_quantity = $item_row['item_quantity'];
$price_rate = $item_row['sale_price'];
$discount_rate = $item_row['discount_rate'];
$amount = $item_row['amount'];
$vat = $item_row['sale_tax'];
$vat_id = $item_row['sale_tax_id'];
$date_time=time();
$vat_amount = ($amount*$vat)/100;

$category_item = $item_row['category'];

if($item_row['category']=='Inventory'){
$qty = $item_row['stock'] - $item_quantity;
$cogs = $item_row['weighted_price'] * $item_quantity;
$asset_value = $item_row['asset_value'] - $cogs;
$weight_avg = $item_row['weighted_price'];
}

$sqli="INSERT INTO `sales_item` (`date`, `item_name`, `item_id`, `item_category`, `item_description`, `item_quantity`, `price_rate`, `discount_rate`, `amount`, `vat`, `vat_id`, `vat_amount`, `asset_value`, `qty`, `cogs`, `weight_avg`, `sales_id`, `exp_account_id`, `income_account_id`, `cogs_id`, `inventory_id`, `company_email`, `type`) VALUES ('$date', '$item_name', '$item_id', '$item_category', '$item_description', '$item_quantity', '$price_rate', '$discount_rate', '$amount', '$vat', '$vat_id', '$vat_amount', '$asset_value', '$qty', '$cogs', '$weight_avg', '$last_id', '$exp_account_id', '$inc_account_id', '$cogs_id', '$inv_asset_id', '$company_email', 'create sales Receipt')";
$conn->query($sqli) ;

if($item_row['category']=='Inventory'){
$sqli = "UPDATE `items` SET `stock` = `stock` - '$item_quantity', `asset_value` = '$asset_value', `weighted_price` = '$weight_avg' WHERE `id` = '$item_id' ";
$conn->query($sqli) ;
$cogs = '0';
$asset_value = '0';
$weight_avg = '0';
$qty = '0';

}

}
}


} else {
    echo "Error: " . $sql . "<br>" . mysqli_error($conn);
}
}
}

/*********************************************************************************************/
/*********************************************************************************************
										create sales return
*********************************************************************************************/
function convert_to_array($object){
$listing_data = json_decode($object);
$json = json_encode($listing_data);
return $array = json_decode($json, true);
}
/*********************************************************************************************/
if(isset($_POST['entry_type']) && $_POST['entry_type'] =='create sales return'){

$name = $_POST['name'];
$date = $_POST['date'];
$date = date('Y-m-d', strtotime($date));

$transaction_number = $_POST['transaction_number'];
$return_type = $_POST['return_type'];
$bank_id = $_POST['bank_id'];
$cheque_no = $_POST['cheque_no'];
$notes = $_POST['notes'];
$subtotal = $_POST['subtotal'];
$disc_rate = $_POST['disc_rate'];
$disc_amount = $_POST['disc_amount'];
$discount_account = $_POST['discount_account'];
$vatt = $_POST['vatt'];
$total = $_POST['total'];

$bank_total = $total - $vatt;
$sub_disc = $subtotal - $disc_amount;

$item_name = json_decode($_POST['item_name']);
$item_names =  arraytoarray($item_name);
$customer = json_decode($_POST['customer']);
$customer =  (array) $customer;
$name_id = $customer['id'];
$receivable_account_id = $customer['payable_account'];
$vat_number_id = $customer['vat_number'];
$vendor_credit = $_POST['vendor_credit'];

$date_time=time();
$newing = $conn->query("SELECT COUNT(*) AS `count` FROM `transaction` WHERE `transaction_number` = '$transaction_number' AND `entry_type` = 'create sales return' AND `company_email` = '$company_email'");
$rowing = $newing->fetch_assoc();
if($rowing['count'] == '0'){

$sql="INSERT INTO `transaction` (`entry_type`, `cat_type`, `name`, `name_id`, `date`, `transaction_number`, `return_type`, `bank_id`, `cheque_no`, `notes`, `subtotal`, `disc_rate`, `disc_amount`, `discount_account`, `vat`, `total`, `total_no_vat`, `company_email`, `date_time`) VALUES ('create sales return', 'sales return', '$name', '$name_id', '$date', '$transaction_number', '$return_type', '$bank_id', '$cheque_no', '$notes', '$subtotal', '$disc_rate', '$disc_amount', '$discount_account', '$vatt', '$total', '$sub_disc', '$company_email', '$date_time')";

if (mysqli_query($conn, $sql)) {
  echo $last_id = mysqli_insert_id($conn);
  if($return_type == 'On Account'){
	$result="UPDATE `customer` SET `credit` = `credit`+'$vendor_credit' WHERE `company_email` = '$company_email' AND `id` = '$name_id'" ;
	$conn->query($result);
	$u = "UPDATE `transaction` SET `credit` = '$vendor_credit' WHERE `id` = '$last_id' AND `company_email` = '$company_email'";
	$conn->query($u);
	if (isset($_POST['invoices'])) {
	$cre_incoices = convert_to_array($_POST['invoices']);
		foreach ($cre_incoices as $c_invoice) {
			$c_invoice_paid = $c_invoice['paid'];
			$c_invoice_id = $c_invoice['id'];
			$conn->query("INSERT INTO `invoice_adjustments`(`transaction_id`, `invoice_id`, `adjust_amt`, `company_email`) VALUES ('$last_id', '$c_invoice_id', '$c_invoice_paid', '$company_email')");
			$sqlasi="UPDATE `transaction` SET `due_amt` = `due_amt`-'$c_invoice_paid'  WHERE `company_email` = '$company_email' AND `id` = '$c_invoice_id'" ;
			$conn->query($sqlasi);
		}
	}
  }

//////////////////////////////////////////////////////////////////////////////////////////
$condition = basename($_FILES["file"]["name"]);
if(isset($condition)){
$target_dir = "emoji/".$name.'/';
$target_file = $target_dir.$last_id. basename($_FILES["file"]["name"]);
if (!file_exists('/'.$target_dir)) {
mkdir('./'.$target_dir, 0777, true);
move_uploaded_file($_FILES["file"]["tmp_name"], $target_file);
} else {
move_uploaded_file($_FILES["file"]["tmp_name"], $target_file);
}
$fname = $target_file;
$sqlz="UPDATE `transaction` SET `file_url` = '$fname' WHERE `id` = '$last_id'";
$conn->query($sqlz);
}
//////////////////////////////////////////////////////////////////////////////////////////

$check_size = sizeof($item_names);
for($i = 0; $i < $check_size; $i++ ){
$item_row = (array)$item_names[$i];
if ($item_row['name'] != '') {
$item_name = $item_row['name'];
$item_id = $item_row['id'];
$item_category = $item_row['category'];
$cogs_id = $item_row['cogs'];
$inv_asset_id = $item_row['inv_asset'];
$inc_account_id = $item_row['inc_account'];
$exp_account_id = $item_row['exp_account'];
$item_description = $item_row['description'];
$item_quantity = $item_row['item_quantity'];
$price_rate = $item_row['sale_price'];
$discount_rate = $item_row['discount_rate'];
$amount = $item_row['amount'];
$vat = $item_row['sale_tax'];
$vat_id = $item_row['sale_tax_id'];
$vat_amount = ($amount*$vat)/100;

$category_item = $item_row['category'];

$date_time=time();

$category_item = $item_row['category'];
if($item_row['category']=='Inventory'){
$qty = $item_row['stock'] + $item_quantity;
$cogs = $item_row['weighted_price'] * $item_quantity;
$asset_value = $item_row['asset_value'] + $cogs;
$weight_avg = $item_row['weighted_price'];
}

$sqli="INSERT INTO `sales_item` (`date`, `item_name`, `item_id`, `item_category`, `item_description`, `item_quantity`, `price_rate`, `discount_rate`, `amount`, `vat`, `vat_id`, `vat_amount`, `asset_value`, `qty`, `cogs`, `weight_avg`, `sales_id`, `exp_account_id`, `income_account_id`, `cogs_id`, `inventory_id`, `company_email`, `type`) VALUES ('$date', '$item_name', '$item_id', '$item_category', '$item_description', '$item_quantity', '$price_rate', '$discount_rate', '$amount', '$vat', '$vat_id', '$vat_amount', '$asset_value', '$qty', '$cogs', '$weight_avg', '$last_id', '$exp_account_id', '$inc_account_id', '$cogs_id', '$inv_asset_id', '$company_email', 'create sales return')";
$conn->query($sqli) ;

if($item_row['category']=='Inventory'){
$sqli = "UPDATE `items` SET `stock` = `stock` + '$item_quantity', `asset_value` = '$asset_value', `weighted_price` = '$weight_avg' WHERE `id` = '$item_id' ";
$conn->query($sqli) ;
$cogs = '0';
$asset_value = '0';
$weight_avg = '0';
$qty = '0';

}
}
}
} else {
    echo "Error: " . $sql . "<br>" . mysqli_error($conn);
}
}
}

/*********************************************************************************************/


$sqli11="DELETE FROM `journal` WHERE `credit` = '0' AND `debit` = '0'";
$conn->query($sqli11) ;

?>