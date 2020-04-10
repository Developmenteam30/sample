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
                    Create payment Voucher
*********************************************************************************************/
/*********************************************************************************************/
if(isset($_POST['entry_type']) && $_POST['entry_type'] =='Create payment Voucher'){
$bank_id = $_POST['bank_id'];
$bank_id_for_journal = $bank_id;
$id = $_POST['id'];
$last_id = $id;
$disc_amount = $_POST['disc_amount'];
$notes = $_POST['notes'];
$date = $_POST['date'];
$date = date('Y-m-d', strtotime($date));

$transaction_number = $_POST['transaction_number'];
$due_date = $_POST['due_date'];
$due_date = date('Y-m-d', strtotime($due_date));
$cheque_no = $_POST['cheque_no'];

$bank_account = json_decode($_POST['bank_account']);
$bank_accounts =  arraytoarray($bank_account);



$sql="UPDATE  `transaction`  SET `entry_type` = 'Create payment Voucher', `cat_type` = 'bank', 
`bank_id` = '$bank_id', `total` = '$disc_amount', `notes` = '$notes', 
`date` = '$date', `transaction_number` = '$transaction_number', `due_date` = '$due_date', 
`cheque_no` = '$cheque_no', `company_email` = '$company_email' WHERE `id` = '$id'" ;

if (mysqli_query($conn, $sql)) {
	///////////////////*****************/////////////// DELETE JOURNAL///////////////////*****************///////////////
	$sqli="DELETE FROM `journal` WHERE `transaction_id` = '$id'" ;
	$conn->query($sqli) or die(mysqli_error());
	///////////////////*****************/////////////// DELETE JOURNAL///////////////////*****************///////////////
	$sqli="DELETE FROM `bank_payment` WHERE `transaction_id` = '$id'" ;
	$conn->query($sqli) or die(mysqli_error());
	$check_size = sizeof($bank_accounts);
	for($i = 0; $i < $check_size; $i++ ){
		$bank_account_array =  (array) $bank_accounts[$i];
		$bank_account = $bank_account_array['bank_account'];
		$vat = $bank_account_array['vat'];
		$vat_id = $bank_account_array['vat_id'];
		$amount = $bank_account_array["amount"];
		$memo = $bank_account_array["memo"];
		$vat_amount = ($amount*$vat)/100;
		$vat_amount = intval($vat_amount);
		$sql10="SELECT * FROM `vat` WHERE `id` = '$vat_id' AND `company_email` = '$company_email' AND `category` = 'purchase' LIMIT 1";
		$new10=$conn->query($sql10);
		$row10 = $new10->fetch_assoc();
		$vat_account = $row10['account'];
		$sqli="INSERT INTO `bank_payment`( `bank_account`, `vat`, `vat_id`, `vat_account`, `vat_amount`, `amount`, `memo`, `transaction_id`, `company_email`) VALUES ('$bank_account', '$vat', '$vat_id', '$vat_account',  '$vat_amount', '$amount', '$memo', '$id', '$company_email')" ;

		$conn->query($sqli) or die(mysql_error()) ;
		//echo "done";
	}
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
$bank_id_for_journal = $bank_id;
$id = $_POST['id'];
$last_id = $id;
$disc_amount = $_POST['disc_amount'];
$notes = $_POST['notes'];
$date = $_POST['date'];
$date = date('Y-m-d', strtotime($date));

$transaction_number = $_POST['transaction_number'];
$due_date = $_POST['due_date'];
$cheque_no = $_POST['cheque_no'];

$bank_account = json_decode($_POST['bank_account']);
$bank_accounts =  arraytoarray($bank_account);
$sql="UPDATE  `transaction`  SET `entry_type` = 'create receipt voucher', `cat_type` = 'bank', 
`bank_id` = '$bank_id', `total` = '$disc_amount', `notes` = '$notes', 
`date` = '$date', `transaction_number` = '$transaction_number', `due_date` = '$due_date', 
`cheque_no` = '$cheque_no', `company_email` = '$company_email' WHERE `id` = '$id'" ;
if (mysqli_query($conn, $sql)) {
	///////////////////*****************/////////////// DELETE JOURNAL///////////////////*****************///////////////
	$sqli="DELETE FROM `journal` WHERE `transaction_id` = '$id'" ;
	$conn->query($sqli) or die(mysqli_error());
	///////////////////*****************/////////////// DELETE JOURNAL///////////////////*****************///////////////
	$sqli="DELETE FROM `bank_payment` WHERE `transaction_id` = '$id'" ;
	$conn->query($sqli) or die(mysqli_error());
	$check_size = sizeof($bank_accounts);
	for($i = 0; $i < $check_size; $i++ ){
		$bank_account_array =  (array) $bank_accounts[$i];
		$bank_id = $bank_account_array['id'];
		$bank_account = $bank_account_array['bank_account'];
		$vat = $bank_account_array['vat'];
		$vat_id = $bank_account_array['vat_id'];
		$amount = $bank_account_array["amount"];
		$memo = $bank_account_array["memo"];
		$vat_amount = ($amount*$vat)/100;
		$vat_amount = intval($vat_amount);
		$sql10="SELECT * FROM `vat` WHERE `id` = '$vat_id' AND `company_email` = '$company_email' AND `category` = 'sales' LIMIT 1";
		$new10=$conn->query($sql10);
		$row10 = $new10->fetch_assoc();
		$vat_account = $row10['account'];
		$sqli="INSERT INTO `bank_payment`( `bank_account`, `vat`, `vat_id`, `vat_account`, `vat_amount`, `amount`, `memo`, `transaction_id`, `company_email`) VALUES ('$bank_account', '$vat', '$vat_id', '$vat_account',  '$vat_amount', '$amount', '$memo', '$id', '$company_email')" ;

		$conn->query($sqli) or die(mysql_error()) ;
		//echo "done";
	}
} else {
    echo "Error: " . $sql . "<br>" . mysqli_error($conn);
}

}

/*********************************************************************************************/
///////////////////*****************/////////////// DELETE JOURNAL///////////////////*****************///////////////
$sqli="DELETE FROM `journal` WHERE `debit` = '0' AND `credit` = '0'" ;
$conn->query($sqli) or die(mysqli_error());
///////////////////*****************/////////////// DELETE JOURNAL///////////////////*****************///////////////
?>


