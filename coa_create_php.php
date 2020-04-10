<?php
include('db.php');



/*********************************************************************************************/
/*********************************************************************************************
										CREATE CHART OF ACCOUNT
*********************************************************************************************/
/*********************************************************************************************/
$code = $_POST['code'];
$accounts_name = $_POST['accounts_name'];
$group = $_POST['group'];

if($_POST['group'] == 'Income'){
$group2 = 'idiscount';
}elseif($_POST['group'] == 'Expenses'){
$group2 = 'ediscount';
}



if($_POST['group'] == 'Income' || $_POST['group'] == 'Expenses'){
$sqli="INSERT INTO `coa_list` (`code`, `accounts_name`, `group`, `group2`, `company_email`) VALUES ('$code', '$accounts_name', '$group', '$group2', '$company_email')";
$cccc = mysqli_query($conn, $sqli);
echo "Error: " . $sqli . "<br>" . mysqli_error($cccc);
}else{
$sql="INSERT INTO `coa_list` (`code`, `accounts_name`, `group`, `company_email`) VALUES ('$code', '$accounts_name', '$group','$company_email')";
$cccc = mysqli_query($conn, $sql);
    echo "Error: " . $sql . "<br>" . mysqli_error($cccc);
}


