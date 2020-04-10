<?php
include('../db.php');
$company_email = "amarjeet@gmail.com";
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

$id = $_POST['id'];
$name = $_POST['name'];
$so_po_no = $_POST['so_po_no'];
$date = $_POST['date'];
$payment_term = $_POST['payment_term'];
$number = $_POST['number'];
$notes = $_POST['notes'];
$subtotal = $_POST['subtotal'];
$disc_rate = $_POST['disc_rate'];
$disc_amount = $_POST['disc_amount'];
$vatt = $_POST['vatt'];
$total = $_POST['total'];
$time_period = $_POST['time_period'];
$category = $_POST['category'];
$delivery_status = $_POST['delivery_status'];
$billing_status = $_POST['billing_status'];
$items = json_decode($_POST['items']);
$items =  arraytoarray($items);


/*$item_name = $_POST['item_name'];
$item_description = $_POST['item_description'];
$price_rate = $_POST['price_rate'];
$item_quantity = $_POST['item_quantity'];
$discount_rate = $_POST['discount_rate'];
$amount = $_POST['amount'];
$vat = $_POST['vat'];
*/

$sql="UPDATE `transaction`   SET `entry_type` = 'create purchase order', `cat_type` = 'purchase', `name` = '$name', `so_po_no` = '$so_po_no', `date` = '$date'
, `payment_term` = '$payment_term', `bill_number` = '$number', `notes` = '$notes', `subtotal` = '$subtotal', `disc_rate` = '$disc_rate', `disc_amount` = '$disc_amount', `vat` = '$vatt', `total` = '$total', `time_period` = '$time_period', `category` = '$category', `delivery_status` = '$delivery_status', `billing_status` = '$billing_status', `company_email` = '$company_email'  WHERE `id` = '$id'" ;
 

if (mysqli_query($conn, $sql)) {

    //echo "New record created successfully. Last inserted ID is: " . $last_id;
$check_size = sizeof($items);
for($i=0; $i<$check_size; $i++ ){

$item_array =  (array) $items[$i];
$purchase_id = $item_array['id'];
$item_name = $item_array['item_name'];
$item_description = $item_array['item_description'];
$item_quantity = $item_array['item_quantity'];
$price_rate = $item_array['price_rate'];
$discount_rate = $item_array['discount_rate'];
$amount = $item_array['amount'];
$vat = $item_array['vat'];
$sqli="UPDATE `purchase_item` SET `item_name` = '$item_name', `item_description` = '$item_description', `item_quantity` = '$item_quantity', `price_rate` = '$price_rate', 
`discount_rate`= '$discount_rate', `amount` =  '$amount', `vat` = '$vat', 
`vat_amount` = '$vat_amount', `company_email` = '$company_email', `date_time` = '$date_time', `type` = 'create purchase order'  WHERE `id` = '$purchase_id'" ;


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
$address = $_POST['address'];
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

$date_time = time();

$result="UPDATE `vendor` SET `company_name` = '$company_name', `email` = '$email', `address` = '$address', `city` = '$city', `state` = '$state', `country` = '$country', `contact_name` = '$contact_name', `phone` = '$phone', `mobile` =  '$mobile', `tax_number` = '$tax_number', `payment_term` = '$payment_term', `vat` = '$vat', `vat_number` = '$vat_number', `vendor_code` = '$vendor_code', `payable_account` = '$payable_account', `notes` = '$notes', `company_email` = '$company_email', `date_time` = '$date_time') 

 WHERE `id` = $id'" ;



//echo "<script>alert(".$name.");</script>";

$new = $conn->query($result) or die (mysqli_error());	

} 

/*********************************************************************************************/

/*********************************************************************************************/
/*********************************************************************************************
										create vendor payment
*********************************************************************************************/
/*********************************************************************************************/
if(isset($_POST['entry_type']) && $_POST['entry_type'] =='create vendor payment'){

$id = $_POST['id'];
$name = $_POST['name'];
$bank_id = $_POST['bank_id'];
$cheque_no = $_POST['cheque_no'];
$date = $_POST['date'];
$transaction_number = $_POST['transaction_number'];
$notes = $_POST['notes'];
$subtotal = $_POST['subtotal'];
$disc_rate = $_POST['disc_rate'];
$disc_amount = $_POST['disc_amount'];
$vat = $_POST['vat'];
$total = $_POST['total'];

$datee = json_decode($_POST['dates']);
$dates =  arraytoarray($datee);




 $sql = "UPDATE `transaction` SET `entry_type` = 'create vendor payment', `cat_type` = 'vendor', `name` = '$name', `bank_id` = '$bank_id', `cheque_no` = '$cheque_no', `date` = '$date', `transaction_number` = '$transaction_number', `notes` = '$notes' , `subtotal` = '$subtotal', `disc_rate` = '$disc_rate', `disc_amount` = '$disc_amount', `company_email` = '$company_email'   WHERE `id` = '$id'" ;

 if (mysqli_query($conn, $sql)) {

    //echo "New record created successfully. Last inserted ID is: " . $last_id;
 $check_size = sizeof($dates);
for($i=0; $i<$check_size; $i++ ){

$date_array =  (array) $dates[$i];
  $payment_id = $date_array['id'];
 $datess = $date_array['dates'];
$invoice_no = $date_array['invoice_no'];
$total = $date_array['total'];
$discount_rate = $date_array['discount_rate'];
$due_amount = $date_array['due_amount'];
$received = $date_array['received'];
$discount_amount = ($total * $discount_rate)/100;

echo $sqli="UPDATE `vendor_payment_list` SET `dates` = '$datess', `invoice_no` =  '$invoice_no', `total` =  '$total', `discount_rate` = '$discount_rate', `discount_amount` = '$discount_amount', `due_amount` = '$due_amount', `received` = '$received', `vendor_payment_list_id` = '$id', `company_email` = '$company_email'   WHERE `id` = '$payment_id'" ;





 $conn->query($sqli) ;
//echo "done";
}
} else {
  echo "hadd h yeee ab to thak gaya hu";
    echo "Error: " . $sql . "<br>" . mysqli_error($conn);
}

}

/*********************************************************************************************/
/*********************************************************************************************
										create purchase invoice
*********************************************************************************************/
/*********************************************************************************************/
if(isset($_POST['entry_type']) && $_POST['entry_type'] =='create purchase invoice'){

$id = $_POST['id'];
$name = $_POST['name'];
$so_po_no = $_POST['so_po_no'];
$date = $_POST['date'];
$transaction_number = $_POST['transaction_number'];
$payment_term = $_POST['payment_term'];
$due_date = $_POST['due_date'];
$notes = $_POST['notes'];
$subtotal = $_POST['subtotal'];
$disc_rate = $_POST['disc_rate'];
$disc_amount = $_POST['disc_amount'];
$vatt = $_POST['vatt'];
$total = $_POST['total'];
$items = json_decode($_POST['items']);
$items =  arraytoarray($items);



/*$item_name = $_POST['item_name'];
$item_description = $_POST['item_description'];
$price_rate = $_POST['price_rate'];
$item_quantity = $_POST['item_quantity'];
$discount_rate = $_POST['discount_rate'];
$amount = $_POST['amount'];
$vat = $_POST['vat'];
*/

$sql="UPDATE `transaction` SET `entry_type` = 'create purchase invoice', `cat_type` = 'purchase', `name`= '$name', `so_po_no` = '$so_po_no', `date` = '$date', `transaction_number` = '$transaction_number', `payment_term` = '$payment_term', `due_date` ='$due_date', `notes` = '$notes', `subtotal` = '$subtotal', `disc_rate` = '$disc_rate', `disc_amount` = '$disc_amount', `vat` = '$vatt', `total` = '$total', `company_email` = '$company_email'  WHERE `id` = '$id'" ;

 
if (mysqli_query($conn, $sql)) {

    //echo "New record created successfully. Last inserted ID is: " . $last_id;
$check_size = sizeof($items);
for($i=0; $i<$check_size; $i++ ){

$item_array =  (array) $items[$i];
$purchase_id = $item_array['id'];
$item_name = $item_array['item_name'];
$item_description = $item_array['item_description'];
$item_quantity = $item_array['item_quantity'];
$price_rate = $item_array['price_rate'];
$discount_rate = $item_array['discount_rate'];
$amount = $item_array['amount'];
$vat = $item_array['vat'];
$vat_amount = $amount * $vat;

 $sqli="UPDATE `purchase_item` SET `item_name` = '$item_name', `item_description` = '$item_description', `item_quantity` = '$item_quantity', `price_rate` = '$price_rate', 
`discount_rate`= '$discount_rate', `amount` =  '$amount', `vat` = '$vat', 
`vat_amount` = '$vat_amount', `company_email` = '$company_email', `date_time` = '$date_time', `type` = '$create purchase order'  WHERE `id` = '$purchase_id'" ;


$conn->query($sqli) ;

}

} else {
    echo "Error: " . $sql . "<br>" . mysqli_error($conn);
}

}

/*********************************************************************************************/
/*********************************************************************************************
										Create purchase Receipt
*********************************************************************************************/
/*********************************************************************************************/
if(isset($_POST['entry_type']) && $_POST['entry_type'] =='Create purchase Receipt'){

$id = $_POST['id'];
$name = $_POST['name'];
$date = $_POST['date'];
$transaction_number = $_POST['transaction_number'];
$bank_id = $_POST['bank_id'];
$cheque_no = $_POST['cheque_no'];
$notes = $_POST['notes'];
$subtotal = $_POST['subtotal'];
$disc_rate = $_POST['disc_rate'];
$disc_amount = $_POST['disc_amount'];
$vatt = $_POST['vatt'];
$total = $_POST['total'];
$items = json_decode($_POST['items']);
$items =  arraytoarray($items);



/*$item_name = $_POST['item_name'];
$item_description = $_POST['item_description'];
$price_rate = $_POST['price_rate'];
$item_quantity = $_POST['item_quantity'];
$discount_rate = $_POST['discount_rate'];
$amount = $_POST['amount'];
$vat = $_POST['vat'];
*/
$date_time=time();

$sql="UPDATE `transaction` SET `entry_type` = 'Create purchase Receipt', `cat_type` = 'purchase', `name` = '$name', `date` = '$date', `transaction_number` = '$transaction_number', `bank_id` = '$bank_id', `cheque_no` = '$cheque_no', `notes` = '$notes', `subtotal` = '$subtotal', `disc_rate` = '$disc_rate', `disc_amount` = '$disc_amount', `vat` = '$vatt', `total` = '$total', `company_email` = '$company_email', `date_time` = '$date_time' WHERE `id` = '$id'";


if (mysqli_query($conn, $sql)) {

    //echo "New record created successfully. Last inserted ID is: " . $last_id;
echo $check_size = sizeof($items);
for($i=0; $i<$check_size; $i++ ){

$item_array =  (array) $items[$i];
$purchase_id = $item_array['id'];
$item_name = $item_array['item_name'];
$item_description = $item_array['item_description'];
$item_quantity = $item_array['item_quantity'];
$price_rate = $item_array['price_rate'];
$discount_rate = $item_array['discount_rate'];
$amount = $item_array['amount'];
$vat = $item_array['vat'];
$sqli="UPDATE `purchase_item` SET `item_name` = '$item_name', `item_description` = '$item_description', `item_quantity` = '$item_quantity', `price_rate` = '$price_rate', 
`discount_rate`= '$discount_rate', `amount` =  '$amount', `vat` = '$vat', 
`vat_amount` = '$vat_amount', `company_email` = '$company_email', `date_time` = '$date_time', `type` = 'Create purchase Receipt'  WHERE `id` = '$purchase_id'" ;


$conn->query($sqli) ;

}

} else {
    echo "Error: " . $sql . "<br>" . mysqli_error($conn);
}
}

/*********************************************************************************************/
/*********************************************************************************************
										create purchase return
*********************************************************************************************/
/*********************************************************************************************/
if(isset($_POST['entry_type']) && $_POST['entry_type'] =='create purchase return'){

$id = $_POST['id'];
$name = $_POST['name'];
$date = $_POST['date'];
$transaction_number = $_POST['transaction_number'];
$return_type = $_POST['return_type'];
$bank_id = $_POST['bank_id'];
$cheque_no = $_POST['cheque_no'];
$notes = $_POST['notes'];
$subtotal = $_POST['subtotal'];
$disc_rate = $_POST['disc_rate'];
$disc_amount = $_POST['disc_amount'];
$vatt = $_POST['vatt'];
$total = $_POST['total'];
$items = json_decode($_POST['items']);
$items =  arraytoarray($items);

/*$item_name = $_POST['item_name'];
$item_description = $_POST['item_description'];
$price_rate = $_POST['price_rate'];
$item_quantity = $_POST['item_quantity'];
$discount_rate = $_POST['discount_rate'];
$amount = $_POST['amount'];
$vat = $_POST['vat'];
*/
$date_time=time();

$sql="UPDATE `transaction` SET `entry_type` = 'create purchase return', `cat_type` = 'purchase', `name` = '$name', `date` = '$date', `transaction_number` = '$transaction_number', `return_type` = '$return_type', `bank_id` = '$bank_id', `cheque_no` = '$cheque_no', `notes` = '$notes', `subtotal` = '$subtotal', `disc_rate` = '$disc_rate' , `disc_amount` = '$disc_amount',  `vat` = '$vatt', `total` = '$total', `company_email` = '$company_email' WHERE `id` = '$id'" ;



if (mysqli_query($conn, $sql)) {

    //echo "New record created successfully. Last inserted ID is: " . $last_id;
$check_size = sizeof($items);
for($i=0; $i<$check_size; $i++ ){

$item_array =  (array) $items[$i];
$purchase_id = $item_array['id'];
$item_name = $item_array['item_name'];
$item_description = $item_array['item_description'];
$item_quantity = $item_array['item_quantity'];
$price_rate = $item_array['price_rate'];
$discount_rate = $item_array['discount_rate'];
$amount = $item_array['amount'];
$vat = $item_array['vat'];
$sqli="UPDATE `purchase_item` SET `item_name` = '$item_name', `item_description` = '$item_description', `item_quantity` = '$item_quantity', `price_rate` = '$price_rate', 
`discount_rate`= '$discount_rate', `amount` =  '$amount', `vat` = '$vat', 
`vat_amount` = '$vat_amount', `company_email` = '$company_email', `date_time` = '$date_time', `type` = '$create purchase order'  WHERE `id` = '$purchase_id'" ;


$conn->query($sqli) ;

}

} else {
    echo "Error: " . $sql . "<br>" . mysqli_error($conn);
}

}

/*********************************************************************************************/

?>


