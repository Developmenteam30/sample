<?php
include('db.php');

/*********************************************************************************************/
/*********************************************************************************************
										CREATE VAT AUTHORITY
*********************************************************************************************/
/*********************************************************************************************/
$authority_name = $_POST['authority_name'];
$country = $_POST['country'];
	

$sql="INSERT INTO `vat_authority` ( `authority_name`, `country`, `company_email`) VALUES ('$authority_name', '$country', '$company_email')";


if (mysqli_query($conn, $sql)) {
$last_id = mysqli_insert_id($conn);



$conn->query($sqli) ;
//echo "done";

} else {
    echo "Error: " . $sql . "<br>" . mysqli_error($conn);
}

