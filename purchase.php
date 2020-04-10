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
										create purchase order
*********************************************************************************************/
/*********************************************************************************************/
if(isset($_POST['entry_type']) && $_POST['entry_type'] =='create purchase order'){
$name = $_POST['name'];
$so_po_no = $_POST['so_po_no'];
$date = $_POST['date'];
$date = date('Y-m-d', strtotime($date));
$payment_term = $_POST['payment_term'];
$number = $_POST['number'];
$notes = $_POST['notes'];
$subtotal = $_POST['subtotal'];
$disc_rate = $_POST['disc_rate'];
$disc_amount = $_POST['disc_amount'];
$discount_account = $_POST['discount_account'];
$vatt = $_POST['vatt'];
$total = $_POST['total'];
$time_period = $_POST['time_period'];
$category = $_POST['category'];
$delivery_status = $_POST['delivery_status'];

$sub_disc = $subtotal - $disc_amount;

$item_name = json_decode($_POST['item_name']);
$item_names =  arraytoarray($item_name);

$vendor = json_decode($_POST['vendor']);
$vendor =  (array) $vendor;
$name_id = $vendor['id'];
$newing = $conn->query("SELECT COUNT(*) AS `count` FROM `transaction` WHERE `transaction_number` = '$number' AND `entry_type` = 'create purchase order' AND `company_email` = '$company_email'");
$rowing = $newing->fetch_assoc();
if($rowing['count'] == '0'){

$sql="INSERT INTO `transaction` (`entry_type`, `cat_type`, `name`, `name_id`, `so_po_no`, `date`, `payment_term`, `transaction_number`, `notes`, `subtotal`, `disc_rate`, `disc_amount`, `discount_account`, `vat`, `total`, `total_no_vat`, `time_period`, `category`, `status`, `company_email`) VALUES ('create purchase order', 'purchase order', '$name', '$name_id', '$so_po_no', '$date', '$payment_term', '$number', '$notes', '$subtotal', '$disc_rate', '$disc_amount', '$discount_account', '$vatt', '$total', '$sub_disc', '$time_period', '$category', '$delivery_status', '$company_email')";


if (mysqli_query($conn, $sql)) {
echo $last_id = mysqli_insert_id($conn);

//////////////////////////////////////////////////////////////////////////////////////////
if(isset($_FILES["file"]["name"])){
 $condition = basename($_FILES["file"]["name"]); 
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
$item_description = $item_row['description'];
$item_quantity = $item_row['item_quantity'];
$price_rate = $item_row['pr_price'];
$discount_rate = $item_row['discount_rate'];
$amount = $item_row['amount'];
$vat = $item_row['pur_tax'];
$vat_id = $item_row['pur_tax_id'];
$vat_amount = ($amount*$vat)/100;

$date_time=time();

$sqli="INSERT INTO `purchase_item` (`item_name`, `item_id`, `item_category`, `item_description`, `item_quantity`, `price_rate`, `discount_rate`, `amount`, `vat`, `vat_id`, `vat_amount`, `purchase_id`, `company_email`, `date_time`, `type`) VALUES ('$item_name', '$item_id', '$item_category', '$item_description', '$item_quantity', '$price_rate', '$discount_rate', '$amount', '$vat', '$vat_id', '$vat_amount', '$last_id', '$company_email', '$date_time', 'create purchase order')";

$conn->query($sqli) ;
//echo "done";
}
}
} else {
    echo "Error: " . $sql . "<br>" . mysqli_error($conn);
}
}
}

/*********************************************************************************************/
/*********************************************************************************************
										create vendor
*********************************************************************************************/
/*********************************************************************************************/
if(isset($_POST['entry_type']) && $_POST['entry_type'] =='Create vendor'){

$company_name = $_POST['company_name'];
$email = $_POST['email'];
$address = $_POST['address'];
$city = $_POST['city'];
$state = $_POST['state'];
$country = $_POST['country'];
$contact_name = $_POST['contact_name'];
if($_POST['phone'] == 'null'){
echo $phone = '';
}else{
$phone = $_POST['phone'];
}
if($_POST['mobile'] == 'null'){
$mobile = '';
}else{
$mobile = $_POST['mobile'];
}
$tax_number = $_POST['tax_number'];
$payment_term = $_POST['payment_term'];
$vat = $_POST['vat'];
$vat_number = $_POST['vat_number'];
$vendor_code = $_POST['vendor_code'];
$payable_account = $_POST['payable_account'];
$delivery_address = $_POST['delivery_address'];
$notes = $_POST['notes'];
$vendor_type = $_POST['vendor_type'];
$opening_balance = $_POST['opening_balance'];
$opening_data = $_POST['opening_date'];
$date_time = time();
$new = $conn->query("SELECT COUNT(*) AS `count` FROM `vendor` WHERE `company_name` = '$company_name' AND `company_email` = '$company_email'");
while($row = $new->fetch_assoc()){
if($row['count'] == '0'){
$result="INSERT INTO `vendor` (`company_name`, `opening_balance`, `opening_date`, `email`, `address`, `city`, `state`, `country`, `contact_name`, `phone`, `mobile`, `tax_number`, `payment_term`, `vat`, `vat_number`, `vendor_code`, `payable_account`, `delivery_address`, `notes`, `company_email`, `date_time`, `vendor_type`) VALUES ('$company_name', '$opening_balance', '$opening_data', '$email', '$address', '$city', '$state', '$country', '$contact_name', '$phone', '$mobile', '$tax_number', '$payment_term', '$vat', '$vat_number', '$vendor_code', '$payable_account', '$delivery_address', '$notes', '$company_email', '$date_time', '$vendor_type')";

$conn->query($result) or die (mysqli_error());	
$last_id = $conn->insert_id;
$date = $opening_data;
	$sqls="INSERT INTO `transaction` (`entry_type`, `cat_type`, `name_id`, `name`, `total`, `date`, `company_email`, `transaction_number`) VALUES ('Journal', 'Journal', '$last_id', 'vendor', '$opening_balance', '$date', '$company_email', '')";

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
}
} 


/*********************************************************************************************/

/*********************************************************************************************/
/*********************************************************************************************
										create vendor payment
*********************************************************************************************/
/*********************************************************************************************/
if(isset($_POST['entry_type']) && $_POST['entry_type'] =='create vendor payment'){

$name = $_POST['name'];
$bank_id = $_POST['bank_id'];
$cheque_no = $_POST['cheque_no'];
$discount_account = $_POST['idiscount_id'];
$date = $_POST['date'];
$date = date('Y-m-d', strtotime($date));
$transaction_number = $_POST['transaction_number'];
$notes = $_POST['notes'];
$subtotal = $_POST['subtotal'];
$disc_rate = $_POST['disc_rate'];
$disc_amount = $_POST['disc_amount'];
$idiscount_id = $_POST['idiscount_id'];
$vat = $_POST['vat'];
$total = $_POST['total'];
//$payments = convert_to_array($_POST['payments']);
$sub_disc = $subtotal - $disc_amount;

$datte = json_decode($_POST['dates']);
$dates =  arraytoarray($datte);
$vendor = json_decode($_POST['vendor']);
$vendor =  (array) $vendor;
$name_id = $vendor['id'];
$payable_account_id = $vendor['payable_account'];
$credit_adjstment = $_POST['credit_adjstment'];

$newing = $conn->query("SELECT COUNT(*) AS `count` FROM `transaction` WHERE `transaction_number` = '$transaction_number' AND `entry_type` = 'create vendor payment' AND `company_email` = '$company_email'");
$rowing = $newing->fetch_assoc();
if($rowing['count'] == '0'){
 $sql = "INSERT INTO `transaction` (`entry_type`, `cat_type`, `name`, `name_id`, `bank_id`, `cheque_no`, `date`, `transaction_number`, `notes`, `subtotal`, `disc_rate`, `vat`, `total`, `total_no_vat`,  `disc_amount`, `discount_account`, `credit`, `company_email`) VALUES ('create vendor payment', 'vendor payment', '$name', '$name_id', '$bank_id', '$cheque_no', '$date', '$transaction_number', '$notes', '$subtotal', '$disc_rate', '$vat', '$total', '$sub_disc',  '$disc_amount', '$idiscount_id', '$credit_adjstment', '$company_email')";
if (mysqli_query($conn, $sql)) {
   echo $last_id = mysqli_insert_id($conn);

$result="UPDATE `vendor` SET `credit` = `credit`+'$credit_adjstment' WHERE `company_email` = '$company_email' AND `id` = '$name_id'" ;
$conn->query($result);

//////////////////////////////////////////////////////////////////////////////////////////
if(isset($_FILES["file"]["name"])){
$condition = basename($_FILES["file"]["name"]);
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
		$item_total = $item_row['total'];
		//$discount_rate = $item_row['discount_amount'];
		$due_amount = $item_row['due_amt'];
		$received = $item_row['paid'];
		$discount_amount = $item_row['discount_amount'];
		$credit_adjus_now = $item_row['credit_adjus_now'];
		$transaction_id = $item_row['id'];
		$payments = $item_row['credit_list'];
		//print_r($item_row['credit_list']);
		$date_time=time();
			if(($discount_amount == '0' || $discount_amount == '' ) && ($received == '0' || $received == '')){
			}else{
				$credit_amount_total += $item_row['credit_amount'];
				$sqli="INSERT INTO `vendor_payment_list` (`dates`, `invoice_no`, `total`, `discount_rate`, `discount_amount`, `credit_amount`, `due_amount`, `received`, `vendor_payment_list_id`, `company_email`) VALUES ('$date', '$invoice_no', '$item_total', '$discount_rate', '$discount_amount', '$credit_adjus_now', '$due_amount', '$received', '$last_id', '$company_email')";
				$conn->query($sqli) ;
				$ss_id = $conn->insert_id;
				$new_due_amount = $due_amount - ($discount_amount + $received + $credit_adjus_now);
				$sqli = "UPDATE `transaction` SET `due_amt` = '$new_due_amount' WHERE `id` = '$transaction_id' ";
				$n = $conn->query($sqli) ;
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
  echo "hadd h yeee ab to thak gaya hu";
    echo "Error: " . $sql . "<br>" . mysqli_error($conn);
}
}
}

/*********************************************************************************************/
/*********************************************************************************************
										create purchase invoice
*********************************************************************************************/
/*********************************************************************************************/
if(isset($_POST['entry_type']) && $_POST['entry_type'] =='create purchase invoice'){

$name = $_POST['name'];
$so_po_no = $_POST['so_po_no'];
$date = $_POST['date'];
$date = date('Y-m-d', strtotime($date));
//$date = date("Y-m-d", mktime($date));
$transaction_number = $_POST['transaction_number'];
$payment_term = $_POST['payment_term'];
$due_date = $_POST['due_date'];
$due_date = date('Y-m-d', strtotime($due_date));
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


$vendor = json_decode($_POST['vendor']);
$vendor =  (array) $vendor;
$name_id = $vendor['id'];
$payable_account_id = $vendor['payable_account'];
$vat_number_id = $vendor['vat_number'];

$date_time=time();
$newing = $conn->query("SELECT COUNT(*) AS `count` FROM `transaction` WHERE `transaction_number` = '$transaction_number' AND `entry_type` = 'create purchase invoice' AND `company_email` = '$company_email'");
$rowing = $newing->fetch_assoc();
if($rowing['count'] == '0'){
$sql="INSERT INTO `transaction` (`entry_type`, `cat_type`, `name`, `name_id`, `so_po_no`, `date`, `transaction_number`, `payment_term`, `due_date`, `notes`, `subtotal`, `disc_rate`, `disc_amount`, `discount_account`, `vat`, `total`, `total_no_vat`, `due_amt`, `company_email`, `date_time`) VALUES ('create purchase invoice', 'purchase invoice', '$name', '$name_id', '$so_po_no', '$date', '$transaction_number', '$payment_term', '$due_date', '$notes', '$subtotal', '$disc_rate', '$disc_amount', '$discount_account', '$vatt', '$total', '$sub_disc', '$total', '$company_email', '$date_time')";

if (mysqli_query($conn, $sql)) {
 echo $last_id = mysqli_insert_id($conn);
    //echo "New record created successfully. Last inserted ID is: " . $last_id;



//////////////////////////////////////////////////////////////////////////////////////////
if(isset($_FILES["file"]["name"])){
$condition = basename($_FILES["file"]["name"]);
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
$sales_income = '0';
$service_charge = '0';


$check_size = sizeof($item_names);
for($i = 0; $i < $check_size; $i++ ){
$item_row = (array)$item_names[$i];
if ($item_row['name'] != '') {
$item_name = $item_row['name'];
$item_id = $item_row['id '];
$item_category = $item_row['category'];
$inc_account_id = $item_row['inc_account'];
$exp_account_id = $item_row['exp_account_id'];
$cogs_id = $item_row['cogs'];
$inv_asset_id = $item_row['inv_asset'];
$exp_account_id = $item_row['exp_account'];
$item_description = $item_row['description'];
$item_quantity = $item_row['item_quantity'];
$price_rate = $item_row['pr_price'];
$discount_rate = $item_row['discount_rate'];
$amount = $item_row['amount'];
$vat = $item_row['pur_tax'];
$vat_id = $item_row['pur_tax_id'];
$date_time=time();
$item_id = $item_row['id'];

$vat_amount = ($amount*$vat)/100;

if($item_row['category']=='Inventory'){
$qty = $item_row['stock'] + $item_quantity;
$cogs = $price_rate * $item_quantity;
$asset_value = $item_row['asset_value'] + $cogs;
$weight_avg = $asset_value/$qty;
}
$sqli="INSERT INTO `purchase_item` (`date`, `item_name`, `item_id`, `item_category`, `item_description`, `item_quantity`, `price_rate`, `discount_rate`, `amount`, `vat`, `vat_id`, `vat_amount`, `asset_value`, `qty`, `cogs`, `weight_avg`, `purchase_id`, `exp_account_id`, `income_account_id`, `cogs_id`, `inventory_id`, `company_email`, `type`) VALUES ('$date', '$item_name', '$item_id', '$item_category', '$item_description', '$item_quantity', '$price_rate', '$discount_rate', '$amount', '$vat', '$vat_id', '$vat_amount', '$asset_value', '$qty', '$cogs', '$weight_avg', '$last_id', '$exp_account_id', '$inc_account_id', '$cogs_id', '$inv_asset_id', '$company_email', 'create purchase invoice')";
$conn->query($sqli) ;

if($item_row['category']=='Inventory'){
$sqli = "UPDATE `items` SET `stock` = '$qty', `asset_value` = '$asset_value', `weighted_price` = '$weight_avg' WHERE `id` = '$item_id' ";
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
										Create purchase Receipt
*********************************************************************************************/
/*********************************************************************************************/
if(isset($_POST['entry_type']) && $_POST['entry_type'] =='Create purchase Receipt'){

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

$bank_total = $total;
$sub_disc = $subtotal - $disc_amount;

$item_name = json_decode($_POST['item_name']);
$item_names =  arraytoarray($item_name);
$vendor = json_decode($_POST['vendor']);
$vendor =  (array) $vendor;
$name_id = $vendor['id'];
$payable_account_id = $vendor['payable_account'];
$vat_number_id = $vendor['vat_number'];


$newing = $conn->query("SELECT COUNT(*) AS `count` FROM `transaction` WHERE `transaction_number` = '$transaction_number' AND `entry_type` = 'Create purchase Receipt' AND `company_email` = '$company_email'");
$rowing = $newing->fetch_assoc();
if($rowing['count'] == '0'){
$sql="INSERT INTO `transaction` (`entry_type`, `cat_type`, `name`, `name_id`, `date`, `transaction_number`, `bank_id`, `cheque_no`, `notes`, `subtotal`, `disc_rate`, `disc_amount`, `discount_account`, `vat`, `total`, `total_no_vat`, `company_email`) VALUES ('Create purchase Receipt', 'purchase Receipt', '$name', '$name_id', '$date', '$transaction_number', '$bank_id', '$cheque_no', '$notes', '$subtotal', '$disc_rate', '$disc_amount', '$discount_account', '$vatt', '$total', '$sub_disc', '$company_email')";

if (mysqli_query($conn, $sql)) {
  echo $last_id = mysqli_insert_id($conn);
    //echo "New record created successfully. Last inserted ID is: " . $last_id;



//////////////////////////////////////////////////////////////////////////////////////////
if(isset($_FILES["file"]["name"])){
$condition = basename($_FILES["file"]["name"]);
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
$price_rate = $item_row['pr_price'];
$discount_rate = $item_row['discount_rate'];
$amount = $item_row['amount'];
$vat = $item_row['pur_tax'];
$vat_id = $item_row['pur_tax_id'];
$date_time=time();

$vat_amount = ($amount*$vat)/100;

if($item_row['category']=='Inventory'){
$qty = $item_row['stock'] + $item_quantity;
$cogs = $price_rate * $item_quantity;
$asset_value = $item_row['asset_value'] + $cogs;
$weight_avg = $asset_value/$qty;
}
$sqli="INSERT INTO `purchase_item` (`date`, `item_name`, `item_id`, `item_category`, `item_description`, `item_quantity`, `price_rate`, `discount_rate`, `amount`, `vat`, `vat_id`, `vat_amount`, `asset_value`, `qty`, `cogs`, `weight_avg`, `purchase_id`, `exp_account_id`, `income_account_id`, `cogs_id`, `inventory_id`, `company_email`, `type`) VALUES ('$date', '$item_name', '$item_id', '$item_category', '$item_description', '$item_quantity', '$price_rate', '$discount_rate', '$amount', '$vat', '$vat_id', '$vat_amount', '$asset_value', '$qty', '$cogs', '$weight_avg', '$last_id', '$exp_account_id', '$inc_account_id', '$cogs_id', '$inv_asset_id', '$company_email', 'Create purchase Receipt')";
$conn->query($sqli) ;

if($item_row['category']=='Inventory'){
$sqli = "UPDATE `items` SET `stock` = '$qty', `asset_value` = '$asset_value', `weighted_price` = '$weight_avg' WHERE `id` = '$item_id' ";
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
										create purchase return
*********************************************************************************************/
function convert_to_array($object){
$listing_data = json_decode($object);
$json = json_encode($listing_data);
return $array = json_decode($json, true);
}
/*********************************************************************************************/
if(isset($_POST['entry_type']) && $_POST['entry_type'] =='create purchase return'){

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
$vendor = json_decode($_POST['vendor']);
$vendor =  (array) $vendor;
$name_id = $vendor['id'];
$payable_account_id = $vendor['payable_account'];
$vat_number_id = $vendor['vat_number'];
$vendor_credit = $_POST['vendor_credit'];
$newing = $conn->query("SELECT COUNT(*) AS `count` FROM `transaction` WHERE `transaction_number` = '$transaction_number' AND `entry_type` = 'create purchase return' AND `company_email` = '$company_email'");
$rowing = $newing->fetch_assoc();
if($rowing['count'] == '0'){
$sql="INSERT INTO `transaction` (`entry_type`, `cat_type`, `name`, `name_id`, `date`, `transaction_number`, `return_type`, `bank_id`, `cheque_no`, `notes`, `subtotal`, `disc_rate`, `disc_amount`, `discount_account`, `vat`, `total`, `total_no_vat`, `company_email`) VALUES ('create purchase return', 'purchase return', '$name', '$name_id', '$date', '$transaction_number', '$return_type', '$bank_id', '$cheque_no', '$notes', '$subtotal', '$disc_rate', '$disc_amount', '$discount_account', '$vatt', '$total', '$sub_disc', '$company_email')";

if (mysqli_query($conn, $sql)) {
  echo  $last_id = mysqli_insert_id($conn);
  if($return_type == 'On Account'){
	$result="UPDATE `vendor` SET `credit` = `credit`+'$vendor_credit' WHERE `company_email` = '$company_email' AND `id` = '$name_id'" ;
	$conn->query($result);
	$conn->query("UPDATE `transaction` SET `credit` = '$vendor_credit' WHERE `id` = '$last_id' AND `company_email` = '$company_email'");
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
if(isset($_FILES["file"]["name"])){
$condition = basename($_FILES["file"]["name"]);
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
$price_rate = $item_row['pr_price'];
$discount_rate = $item_row['discount_rate'];
$amount = $item_row['amount'];
$vat = $item_row['pur_tax'];
$vat_id = $item_row['pur_tax_id'];
$date_time=time();

$vat_amount = ($amount*$vat)/100;

if($item_row['category']=='Inventory'){
$qty = $item_row['stock'] - $item_quantity;
$cogs = $price_rate * $item_quantity;
$asset_value = $item_row['asset_value'] - $cogs;
$weight_avg = $item_row['weighted_price'];
}
$sqli="INSERT INTO `purchase_item` (`date`, `item_name`, `item_id`, `item_category`, `item_description`, `item_quantity`, `price_rate`, `discount_rate`, `amount`, `vat`, `vat_id`, `vat_amount`, `asset_value`, `qty`, `cogs`, `weight_avg`, `purchase_id`, `exp_account_id`, `income_account_id`, `cogs_id`, `inventory_id`, `company_email`, `type`) VALUES ('$date', '$item_name', '$item_id', '$item_category', '$item_description', '$item_quantity', '$price_rate', '$discount_rate', '$amount', '$vat', '$vat_id', '$vat_amount', '$asset_value', '$qty', '$cogs', '$weight_avg', '$last_id', '$exp_account_id', '$inc_account_id', '$cogs_id', '$inv_asset_id', '$company_email', 'create purchase return')";
$conn->query($sqli) ;

if($item_row['category']=='Inventory'){
$sqli = "UPDATE `items` SET `stock` = '$qty', `asset_value` = '$asset_value', `weighted_price` = '$weight_avg' WHERE `id` = '$item_id' ";
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