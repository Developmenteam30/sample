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
										CREATE AND UPDATE VAT PAYMENT 
*********************************************************************************************/
/*********************************************************************************************/
$authority = $_POST['authority'];
$bank_id = $_POST['bank_id'];
$cheque_no = $_POST['cheque_no'];
$date = $_POST['date'];
$transaction_number = $_POST['transaction_number'];
$notes = $_POST['notes'];
$total = $_POST['total'];

$zx = json_decode($_POST['zx']);
$zx = (array)$zx;

$sql="INSERT INTO `transaction` ( `name_id`, `bank_id`, `cheque_no`, `date`, `transaction_number`, `notes`, `total`, `company_email`) VALUES ( '$authority', '$bank_id', '$cheque_no', '$date', '$transaction_number', '$notes', '$total', '$company_email')";


if (mysqli_query($conn, $sql)) {
$last_id = mysqli_insert_id($conn);



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
$sqlz="UPDATE `vat_return` SET `file_url` = '$fname' WHERE `id` = '$last_id'";
$conn->query($sqlz);
}
//////////////////////////////////////////////////////////////////////////////////////////

echo $check_size = sizeof($zx);
for($i = 0; $i < $check_size; $i++ ){
	$arrayNam = (array)$zx[$i];
if ($arrayNam['id'] != '') {
 $id = $arrayNam['id'];
 $vat_account = $arrayNam['account'];
 $amount = $arrayNam['amount'];

$sqli="UPDATE `vat_return_items` SET `status` = 'paid', `transaction_id` = '$last_id' WHERE `id` = '$id'" ;

$conn->query($sqli) ;

/***********************************************************JOURNAL ENTRIES****************************************************/
///////////////////BANK////////////////////
$sqli1="INSERT INTO `journal` (`date`, `number`, `account`, `debit`, `transaction_id`, `type`, `company_email`) VALUES ('$date', '$transaction_number', '$bank_id', '$amount', '$last_id', 'vat_payment', '$company_email')";
$conn->query($sqli1) ;
///////////////////BANK////////////////////
///////////////////VAT////////////////////
$sqli1="INSERT INTO `journal` (`date`, `number`, `account`, `credit`, `transaction_id`, `type`, `company_email`) VALUES ('$date', '$transaction_number', '$vat_account', '$amount', '$last_id', 'vat_payment', '$company_email')";
$conn->query($sqli1) ;
///////////////////VAT////////////////////
/***********************************************************JOURNAL ENTRIES****************************************************/


//echo "done";
}
}



} else {
    echo "Error: " . $sql . "<br>" . mysqli_error($conn);
}

