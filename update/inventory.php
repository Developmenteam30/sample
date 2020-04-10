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

/*********************************************************************************************/
/*********************************************************************************************
										create New item
*********************************************************************************************/
/*********************************************************************************************/
if(isset($_POST['entry_type']) && $_POST['entry_type'] =='create New item'){

$id = $_POST['id'];
$category = $_POST['category'];
$name = $_POST['name'];
$no = $_POST['no'];
$description = $_POST['description'];
$exp_account = $_POST['exp_account'];
$pr_price = $_POST['pr_price'];
$sale_price = $_POST['sale_price'];
$cogs = $_POST['cogs'];
$inv_asset = $_POST['inv_asset'];
$inc_account = $_POST['inc_account'];
$pur_tax = $_POST['pur_tax'];
$sale_tax = $_POST['sale_tax'];
$notes = $_POST['notes'];
$val_cost = $_POST['val_cost'];
$neg_stock = $_POST['neg_stock'];

echo $result="UPDATE  `items`  SET `category` = '$category', `name` = '$name' , `no` = '$no',
 `description` = '$description', `exp_account` = '$exp_account', `pr_price` = '$pr_price',
  `sale_price` = '$sale_price', `cogs` = '$cogs', `inv_asset` = '$inv_asset',  `inc_account` = '$inc_account' , `pur_tax` = '$pur_tax', `sale_tax` = '$sale_tax', `notes` = '$notes' , `val_cost` = '$val_cost', `neg_stock` = '$neg_stock', `company_email` = '$company_email' WHERE `id` = '$id'" ;



$new = $conn->query($result) or die (mysqli_error());	

} 


/*********************************************************************************************/
/*********************************************************************************************
										create Goods issue notes
*********************************************************************************************/
/*********************************************************************************************/
if(isset($_POST['entry_type']) && $_POST['entry_type'] =='create Goods issue notes'){

$id = $_POST['id'];
echo $name = $_POST['name'];
$name_id = $_POST['name_id'];
$date = $_POST['date'];
$date = date('Y-m-d', strtotime($date));

$transaction_number = $_POST['transaction_number'];
$so_po_no = $_POST['so_po_no'];
$notes = $_POST['notes'];
$subtotal = $_POST['subtotal'];
$disc_rate = $_POST['disc_rate'];
$disc_amount = $_POST['disc_amount'];
$discount_account = $_POST['discount_account'];
$vatt = $_POST['vatt'];
$total = $_POST['total'];

$items = json_decode($_POST['items']);
$items =  arraytoarray($items);




 $sql="UPDATE  `transaction`  SET `entry_type` = 'create Goods issue notes', `cat_type` = 'inventory', `name` = '$name', `name_id` = '$name_id', `date` = '$date', `transaction_number` = '$transaction_number', `so_po_no` = '$so_po_no', `notes` = '$notes' , `subtotal` = '$subtotal', `disc_rate` = '$disc_rate', `disc_amount` =  '$disc_amount', `discount_account` =  '$discount_account', `vat` = '$vatt', `total` = '$total', `company_email` = '$company_email'  WHERE `id` = '$id'" ;
 

if (mysqli_query($conn, $sql)) {

    //echo "New record created successfully. Last inserted ID is: " . $last_id;
$sqli="DELETE FROM `inventory_goods` WHERE `goods_id`= '$id' AND `company_email` = '$company_email'";
$conn->query($sqli) ;
$check_size = sizeof($items);
for($i=0; $i<$check_size; $i++ ){

$item_array =  (array) $items[$i];
$issue_id = $item_array['id'];
$item_name = $item_array['item_name'];
$item_id = $item_array['item_id'];
$item_description = $item_array['item_description'];
$item_quantity = $item_array['item_quantity'];
$price_rate = $item_array['price_rate'];
$discount_rate = $item_array['discount_rate'];
$amount = $item_array['amount'];
$vat = $item_array['vat'];
$vat_amount = $amount * $vat;

$sqli="INSERT INTO `inventory_goods` (`item_id`, `item_name`, `item_description`, `item_quantity`, `price_rate`, `discount_rate`, `amount`, `vat`, `vat_amount`, `goods_id`, `company_email`, `date_time`, `type`) VALUES ('$item_id', '$item_name', '$item_description', '$item_quantity', '$price_rate', '$discount_rate', '$amount', '$vat', '$vat_amount', '$id', '$company_email', '$date', 'create Goods issue notes')";


$conn->query($sqli) ;

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
if(isset($_POST['entry_type']) && $_POST['entry_type'] =='Goods receipt notes'){

$id = $_POST['id'];
$name = $_POST['name'];
$date = $_POST['date'];
$date = date('Y-m-d', strtotime($date));

$transaction_number = $_POST['transaction_number'];
$notes = $_POST['notes'];
$subtotal = $_POST['subtotal'];
$disc_rate = $_POST['disc_rate'];
$disc_amount = $_POST['disc_amount'];
$discount_account = $_POST['discount_account'];
$vatt = $_POST['vatt'];
$total = $_POST['total'];

$items = json_decode($_POST['items']);
$items =  arraytoarray($items);



$sql="UPDATE `transaction`  SET `entry_type` = 'create Goods receipt note', `cat_type` = 'inventory', `name` = '$name', `date` = '$date', `transaction_number` = '$transaction_number', `notes` = '$notes', `subtotal` = '$subtotal', `disc_rate` = '$disc_rate', `disc_amount` = '$disc_amount', `discount_account` = '$discount_account' , `vat` = '$vatt' , `total` = '$total', `company_email` = '$company_email'  WHERE `id` = '$id'" ;

 
if (mysqli_query($conn, $sql)) {
$sqli="DELETE FROM `inventory_goods` WHERE `goods_id`= '$id' AND `company_email` = '$company_email'";
$conn->query($sqli) ;

    //echo "New record created successfully. Last inserted ID is: " . $last_id;
$check_size = sizeof($items);
for($i=0; $i<$check_size; $i++ ){

$item_array =  (array) $items[$i];
$receipt_id = $item_array['id'];
$item_name = $item_array['item_name'];
$item_id = $item_array['item_id'];
$item_description = $item_array['item_description'];
$item_quantity = $item_array['item_quantity'];
$price_rate = $item_array['price_rate'];
$discount_rate = $item_array['discount_rate'];
$amount = $item_array['amount'];
$vat = $item_array['vat'];
$vat_amount = $amount * $vat;

$sqli="INSERT INTO `inventory_goods` (`item_id`, `item_name`, `item_description`, `item_quantity`, `price_rate`, `discount_rate`, `amount`, `vat`, `vat_amount`, `goods_id`, `company_email`, `date_time`, `type`) VALUES ('$item_id', '$item_name', '$item_description', '$item_quantity', '$price_rate', '$discount_rate', '$amount', '$vat', '$vat_amount', '$id', '$company_email', '$date', 'create Goods receipt note')";
$conn->query($sqli) ;

}

} else {
    echo "Error: " . $sql . "<br>" . mysqli_error($conn);
}

}


/*********************************************************************************************/
?>

