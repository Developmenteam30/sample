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
/********************************************************************************************
										UPDATE VAT AUTHORITY
/*********************************************************************************************/
/*********************************************************************************************/

$category = $_POST['entry_type'];
$data = $_POST['data'];
$data = json_decode($_POST['data']);
$data = (array)$data;
foreach ($data as $key) {
$key = (array)$key;
$id = $key['id'];
$authority_name = $key['authority_name'];
$country = $key['country'];

$result="UPDATE  `vat_authority` SET  `authority_name` =  '$authority_name',`country` =  '$country' WHERE  `id` = '$id'";
$new = $conn->query($result) or die (mysqli_error());	
}




/*********************************************************************************************/

?>
