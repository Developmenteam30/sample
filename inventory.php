<?php
include('db.php');
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
										create New item
*********************************************************************************************/
/*********************************************************************************************/
if(isset($_POST['entry_type']) && $_POST['entry_type'] =='create New item'){

$category = $_POST['category'];
$name = $_POST['name'];
$no = $_POST['no'];
$description = $_POST['description'];
$exp_account = $_POST['exp_account'];
$open_qty = $_POST['open_qty'];
$pr_price = $_POST['pr_price'];
$open_asset = $_POST['pr_price']*$_POST['open_qty'];
$sale_price = $_POST['sale_price'];
$cogs = $_POST['cogs'];
$inv_asset = $_POST['inv_asset'];
$inc_account = $_POST['inc_account'];
$pur_tax = $_POST['pur_tax'];
$sale_tax = $_POST['sale_tax'];
$pur_tax_id = $_POST['pur_tax_id'];
$sale_tax_id = $_POST['sale_tax_id'];
$notes = $_POST['notes'];
$val_cost = $_POST['val_cost'];
$neg_stock = $_POST['neg_stock'];
$opening_data = date('Y-m-d', $_POST['opening_date']);
$now = $conn->query("SELECT name FROM items WHERE name = '$name' AND `company_email` = '$company_email'");
	if($now->num_rows == 0){
	$result="INSERT INTO `items` (`category`, `name`, `no`, `description`, `exp_account`, `open_qty`, `open_asset`, `pr_price`, `sale_price`, `cogs`, `inv_asset`, `inc_account`, `pur_tax`, `sale_tax`, `pur_tax_id`, `sale_tax_id`, `notes`, `val_cost`, `neg_stock`, `company_email`, `weighted_price`, `stock`, `asset_value`) SELECT '$category', '$name', '$no', '$description', '$exp_account', '$open_qty', '$open_asset', '$pr_price', '$sale_price', '$cogs', '$inv_asset', '$inc_account', '$pur_tax', '$sale_tax', '$pur_tax_id', '$sale_tax_id', '$notes', '$val_cost', '$neg_stock', '$company_email', '$pr_price', '$open_qty', '$open_asset' FROM items WHERE NOT EXISTS ( SELECT name FROM items WHERE name = '$name' AND `company_email` = '$company_email') LIMIT 1";
	$opening_balance = $open_asset;
	$payable_account = $inv_asset;
	$conn->query($result) or die (mysqli_error());
	$last_id = $conn->insert_id;
	$date = $opening_data;
		if ($category == "Inventory") {
			$sqls="INSERT INTO `transaction` (`entry_type`, `cat_type`, `name_id`, `name`, `total`, `total_qty`, `date`, `company_email`, `transaction_number`) VALUES ('Journal', 'Journal', '$last_id', 'items', '$opening_balance', '$open_qty', '$date', '$company_email', '')";

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
			}
		}
	}
}
/*********************************************************************************************/
/*********************************************************************************************
										create Goods issue notes
*********************************************************************************************/
/*********************************************************************************************/
if(isset($_POST['entry_type']) && $_POST['entry_type'] =='create Goods issue notes'){
$name = $_POST['name'];
$date = $_POST['date'];
$date = date('Y-m-d', strtotime($date));

$transaction_number = $_POST['transaction_number'];
$so_po_no = $_POST['so_po_no'];
$notes = $_POST['notes'];
$subtotal = $_POST['subtotal'];
$disc_rate = $_POST['disc_rate'];
$disc_amount = $_POST['disc_amount'];
$disc_account = $_POST['disc_account'];
$vatt = $_POST['vatt'];
$total = $_POST['total'];

$item_name = json_decode($_POST['item_name']);
$item_name =  arraytoarray($item_name);
$customer = json_decode($_POST['customer']);
$customer =  (array) $customer;
$name_id = $customer['id'];

$sql="INSERT INTO `transaction` (`entry_type`, `cat_type`, `name`, `name_id`, `date`, `transaction_number`, `so_po_no`, `notes`, `subtotal`, `disc_rate`, `disc_amount`, `discount_account`, `vat`, `total`, `company_email`) VALUES ('create Goods issue notes', 'Goods issue notes', '$name', '$name_id', '$date', '$transaction_number', '$so_po_no', '$notes', '$subtotal', '$disc_rate', '$disc_amount', '$disc_account', '$vatt', '$total', '$company_email')";

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

$check_size = sizeof($item_name);
for($i = 0; $i < $check_size; $i++ ){
$item_row = (array)$item_name[$i];
if ($item_row['name'] != '') {
$item_id = $item_row['id'];
$item_name = $item_row['name'];
$item_description = $item_row['description'];
$item_quantity = $item_row['item_quantity'];
$price_rate = $item_row['sale_price'];
$discount_rate = $item_row['discount_rate'];
$amount = $item_row['amount'];
$vat = $item_row['sale_tax'];
$vat_id = $item_row['sale_tax_id'];
$vat_amount = ($vat*$amount)/100;

$sqli="INSERT INTO `inventory_goods` (`item_id`, `item_name`, `item_description`, `item_quantity`, `price_rate`, `discount_rate`, `amount`, `vat`, `vat_id`, `vat_amount`, `goods_id`, `company_email`, `date_time`, `type`) VALUES ('$item_id', '$item_name', '$item_description', '$item_quantity', '$price_rate', '$discount_rate', '$amount', '$vat', '$vat_id', '$vat_amount', '$last_id', '$company_email', '$date', 'create Goods issue notes')";

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
										create Goods receipt note
*********************************************************************************************/
/*********************************************************************************************/
if(isset($_POST['entry_type']) && $_POST['entry_type'] =='create Goods receipt note'){

$name = $_POST['name'];
$date = $_POST['date'];
$date = date('Y-m-d', strtotime($date));

$transaction_number = $_POST['transaction_number'];
$notes = $_POST['notes'];
$subtotal = $_POST['subtotal'];
$disc_rate = $_POST['disc_rate'];
$disc_amount = $_POST['disc_amount'];
$disc_account = $_POST['disc_account'];
$vatt = $_POST['vatt'];
$total = $_POST['total'];

$item_name = json_decode($_POST['item_name']);
$item_name =  arraytoarray($item_name);

$vendor = json_decode($_POST['vendor']);
$vendor =  (array) $vendor;
$name_id = $vendor['id'];

$sql="INSERT INTO `transaction` (`entry_type`, `cat_type`, `name`, `name_id`, `date`, `transaction_number`, `notes`, `subtotal`, `disc_rate`, `disc_amount`, `discount_account`, `vat`, `total`, `company_email`) VALUES ('create Goods receipt note', 'Goods receipt note', '$name', '$name_id', '$date', '$transaction_number', '$notes', '$subtotal', '$disc_rate', '$disc_amount', '$disc_account', '$vatt', '$total', '$company_email')";

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

$check_size = sizeof($item_name);
for($i = 0; $i < $check_size; $i++ ){
$item_row = (array)$item_name[$i];
if ($item_row['name'] != '') {
$item_id = $item_row['id'];
$item_name = $item_row['name'];
$item_description = $item_row['description'];
$item_quantity = $item_row['item_quantity'];
$price_rate = $item_row['pr_price'];
$discount_rate = $item_row['discount_rate'];
$amount = $item_row['amount'];
$vat = $item_row['pur_tax'];
$vat_id = $item_row['pur_tax_id'];
$vat_amount = ($vat*$amount)/100;


$sqli="INSERT INTO `inventory_goods` (`item_id`, `item_name`, `item_description`, `item_quantity`, `price_rate`, `discount_rate`, `amount`, `vat`, `vat_id`, `vat_amount`, `goods_id`, `company_email`, `date_time`, `type`) VALUES ('$item_id', '$item_name', '$item_description', '$item_quantity', '$price_rate', '$discount_rate', '$amount', '$vat', '$vat_id', '$vat_amount', '$last_id', '$company_email', '$date', 'create Goods receipt note')";

$conn->query($sqli) or die(mysqli_error()) ;
//echo "done";
}
}
} else {
    echo "Error: " . $sql . "<br>" . mysqli_error($conn);
}
}
/*********************************************************************************************/
/*********************************************************************************************
										create Inventory adjust
*********************************************************************************************/
/*********************************************************************************************/
if(isset($_POST['entry_type']) && $_POST['entry_type'] =='create inventory adjust'){

$name = $_POST['name'];
$bank_id = $_POST['bank_id'];
$date = $_POST['date'];
$date = date('Y-m-d', $date);
$transaction_number = $_POST['transaction_number'];
$notes = $_POST['notes'];
$total_qty = $_POST['total_qty'];
$total = $_POST['total'];
$item_name = json_decode($_POST['item_name']);
$item_name =  arraytoarray($item_name);
$sql="INSERT INTO `transaction` (`entry_type`, `cat_type`, `name`, `bank_id`, `date`, `transaction_number`, `notes`, `total`, `total_qty`, `company_email`) VALUES ('create inventory adjust', 'inventory adjust', '$name', '$bank_id', '$date', '$transaction_number', '$notes', '$total', '$total_qty', '$company_email')";

if (mysqli_query($conn, $sql)) {
 echo $last_id = mysqli_insert_id($conn);

$check_size = sizeof($item_name);
for($i = 0; $i < $check_size; $i++ ){
$item_row = (array)$item_name[$i];
if ($item_row['name'] != '') {
$item_id = $item_row['id'];
$item_name = $item_row['name'];
$item_description = $item_row['description'];
$stock = $item_row['stock'];
$new_stock = $item_row['new_stock'];
$asset_value = $item_row['asset_value'];
$new_asset_value = $item_row['new_asset_value'];
$sqli="INSERT INTO `inventory_goods` (`item_id`, `item_name`, `item_description`, `stock`, `new_stock`, `asset_value`, `new_asset_value`, `goods_id`, `company_email`, `date_time`, `type`) VALUES ('$item_id', '$item_name', '$item_description', '$stock', '$new_stock', '$asset_value', '$new_asset_value', '$last_id', '$company_email', '$date', 'create inventory adjust')";

$conn->query($sqli) or die(mysqli_error()) ;
}
}
} else {
    echo "Error: " . $sql . "<br>" . mysqli_error($conn);
}
}
/*********************************************************************************************/
?>