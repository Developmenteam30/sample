<?php
include('db.php');

/*********************************************************************************************/
/*********************************************************************************************
										CREATE PURCHASE VAT
*********************************************************************************************/
/*********************************************************************************************/
$name = $_POST['name'];
$rate = $_POST['rate'];
$account = $_POST['account'];
	

$sql="INSERT INTO `vat` ( `name`, `rate`, `account`, `category`, `company_email`) VALUES ('$name', '$rate', '$account', 'purchase', '$company_email')";


if (mysqli_query($conn, $sql)) {
$last_id = mysqli_insert_id($conn);



$conn->query($sqli) ;
//echo "done";

} else {
    echo "Error: " . $sql . "<br>" . mysqli_error($conn);
}

