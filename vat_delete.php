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
$id = $_POST['data'];

$result="DELETE FROM vat WHERE  `id` = '$id'";
$new = $conn->query($result) or die (mysqli_error());	





/*********************************************************************************************/

?>
