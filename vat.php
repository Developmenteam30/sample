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
										CREATE VAT RATES
/*********************************************************************************************/
/*********************************************************************************************/

$category = $_POST['entry_type'];
$data = $_POST['data'];
$data = json_decode($_POST['data']);
$data = (array)$data;
foreach ($data as $key) {
$key = (array)$key;
$id = $key['id'];
$name = $key['name'];
$rate = $key['rate'];
$account = $key['account'];

$result="UPDATE  `vat` SET  `name` =  '$name',`rate` =  '$rate',`account` =  '$account' WHERE  `id` = '$id'";
$new = $conn->query($result) or die (mysqli_error());	
}




/*********************************************************************************************/

?>
