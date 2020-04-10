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
                    Create payment Voucher
*********************************************************************************************/
/*********************************************************************************************/
if(isset($_POST['entry_type']) && $_POST['entry_type'] =='Create payment Voucher'){

$bank_id = $_POST['bank_id'];
$disc_amount = $_POST['disc_amount'];
$notes = $_POST['notes'];
$date = $_POST['date'];
$date = date('Y-m-d', strtotime($date));

$transaction_number = $_POST['transaction_number'];
$due_date = $_POST['due_date'];
$cheque_no = $_POST['cheque_no'];

$bank_account = json_decode($_POST['bank_account']);
$bank_accounts =  arraytoarray($bank_account);

$sqli = "SELECT * FROM `bank` WHERE `id`='$bank_id'";
$new = $conn->query($sqli);
while ($row  = $new->fetch_assoc()) {
	$name = $row['name'];
}

$sql="INSERT INTO `transaction` (`entry_type`, `cat_type`, `name`, `bank_id`, `total`, `notes`, `date`, `transaction_number`, `due_date`, `cheque_no`, `company_email`) VALUES ('Create payment Voucher', 'bank', '$name', '$bank_id', '$disc_amount', '$notes', '$date', '$transaction_number', '$due_date', '$cheque_no', '$company_email')";

if (mysqli_query($conn, $sql)) {
  echo  $last_id = mysqli_insert_id($conn);

//////////////////////////////////////////////////////////////////////////////////////////

if(isset($_SESSION['filename'])){
$filename = $_SESSION['filename'];
$sqlz="UPDATE `transaction` SET `file_url` = '$filename' WHERE `id` = '$last_id'";
$conn->query($sqlz);
}

//////////////////////////////////////////////////////////////////////////////////////////

 $check_size = sizeof($bank_account);
for($i = 0; $i < $check_size; $i++ ){
$item_row = (array)$bank_accounts[$i];
if ($item_row['id'] != '') {
$bank_account = $item_row['id'];
$vat = $item_row['vat'];
$amount = $item_row['amount'];
$memo = $item_row['memo'];
$vat_amount = ($amount*$vat)/100;
$sqli="INSERT INTO `bank_payment` (`bank_account`, `vat`, `vat_amount`, `amount`, `memo`, `transaction_id`, `company_email`) VALUES ('$bank_account', '$vat', '$vat_amount', '$amount', '$memo', '$last_id', '$company_email')";

$conn->query($sqli) or die(mysql_error()) ;
///////////////////ACCOUNT////////////////////
$sqli2="INSERT INTO `journal` (`date`, `number`, `account`, `debit`, `transaction_id`, `type`, `company_email`) VALUES ('$date', '$transaction_number', '$bank_account', '$amount', '$last_id', 'Payment', '$company_email')";
$conn->query($sqli2) ;
///////////////////ACCOUNT////////////////////
///////////////////VAT////////////////////
$sql10="SELECT * FROM `vat` WHERE `rate` = '$vat' AND `company_email` = '$company_email' AND `category` = 'purchase' LIMIT 1";
$new10=$conn->query($sql10);
while($row10 = $new10->fetch_assoc()){
$vat_id = $row10['account'];
$sqli2="INSERT INTO `journal` (`date`, `number`, `account`, `debit`, `transaction_id`, `type`, `company_email`) VALUES ('$date', '$transaction_number', '$vat_id', '$vat_amount', '$last_id', 'Payment', '$company_email')";
$conn->query($sqli2) ;
}
///////////////////VAT////////////////////

}
}
///////////////////BANK////////////////////
$sqli2="INSERT INTO `journal` (`date`, `number`, `account`, `credit`, `transaction_id`, `type`, `company_email`) VALUES ('$date', '$transaction_number', '$bank_id', '$disc_amount', '$last_id', 'Payment', '$company_email')";
$conn->query($sqli2) ;
///////////////////BANK////////////////////

} else {
    echo "Error: " . $sql . "<br>" . mysqli_error($conn);
}
}

/*********************************************************************************************/
/*********************************************************************************************
                    create receipt voucher
*********************************************************************************************/
/*********************************************************************************************/
if(isset($_POST['entry_type']) && $_POST['entry_type'] =='create receipt voucher'){

$bank_id = $_POST['bank_id'];
$disc_amount = $_POST['disc_amount'];
$notes = $_POST['notes'];
$date = $_POST['date'];
$date = date('Y-m-d', strtotime($date));

$transaction_number = $_POST['transaction_number'];
$due_date = $_POST['due_date'];
$cheque_no = $_POST['cheque_no'];

$bank_account = json_decode($_POST['bank_account']);
$bank_accounts =  arraytoarray($bank_account);


$sqli = "SELECT * FROM `bank` WHERE `id`='$bank_id'";
$new = $conn->query($sqli);
while ($row  = $new->fetch_assoc()) {
	$name = $row['name'];
}



$sql="INSERT INTO `transaction` (`entry_type`, `cat_type`, `name`, `bank_id`, `total`, `notes`, `date`, `transaction_number`, `due_date`, `cheque_no`, `company_email`) VALUES ('create receipt voucher', 'bank', '$name', '$bank_id', '$disc_amount', '$notes', '$date', '$transaction_number', '$due_date', '$cheque_no', '$company_email')";

if (mysqli_query($conn, $sql)) {
  echo  $last_id = mysqli_insert_id($conn);

//////////////////////////////////////////////////////////////////////////////////////////
if(isset($_SESSION['filename'])){
$filename = $_SESSION['filename'];
$sqlz="UPDATE `transaction` SET `file_url` = '$filename' WHERE `id` = '$last_id'";
$conn->query($sqlz);
}
//////////////////////////////////////////////////////////////////////////////////////////

$check_size = sizeof($bank_account);
for($i = 0; $i < $check_size; $i++ ){
$item_row = (array)$bank_accounts[$i];
if ($item_row['id'] != '') {
$bank_account = $item_row['id'];
$vat = $item_row['vat'];
$amount = $item_row['amount'];
$memo = $item_row['memo'];
$vat_amount = ($amount*$vat)/100;

$sqli="INSERT INTO `bank_payment` (`bank_account`, `vat`, `vat_amount`, `amount`, `memo`, `transaction_id`, `company_email`) VALUES ('$bank_account', '$vat', '$vat_amount', '$amount', '$memo', '$last_id', '$company_email')";

$conn->query($sqli) ;
///////////////////ACCOUNT////////////////////
$sqli2="INSERT INTO `journal` (`date`, `number`, `account`, `credit`, `transaction_id`, `type`, `company_email`) VALUES ('$date', '$transaction_number', '$bank_account', '$amount', '$last_id', 'Payment', '$company_email')";
$conn->query($sqli2) ;
///////////////////ACCOUNT////////////////////
///////////////////VAT////////////////////
$sql10="SELECT * FROM `vat` WHERE `rate` = '$vat' AND `company_email` = '$company_email' AND `category` = 'sales' LIMIT 1";
$new10=$conn->query($sql10);
while($row10 = $new10->fetch_assoc()){
$vat_id = $row10['account'];
$sqli2="INSERT INTO `journal` (`date`, `number`, `account`, `credit`, `transaction_id`, `type`, `company_email`) VALUES ('$date', '$transaction_number', '$vat_id', '$vat_amount', '$last_id', 'Payment', '$company_email')";
$conn->query($sqli2) ;
}
///////////////////VAT////////////////////
}
}
///////////////////BANK////////////////////
$sqli2="INSERT INTO `journal` (`date`, `number`, `account`, `debit`, `transaction_id`, `type`, `company_email`) VALUES ('$date', '$transaction_number', '$bank_id', '$disc_amount', '$last_id', 'Payment', '$company_email')";
$conn->query($sqli2) ;
///////////////////BANK////////////////////

} else {
    echo "Error: " . $sql . "<br>" . mysqli_error($conn);
}

}


/*********************************************************************************************/

?>