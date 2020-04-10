<?php
include('db.php');




/*********************************************************************************************/
/********************************************************************************************
										DELETE ANY TABLE
/*********************************************************************************************/
/*********************************************************************************************/

$tale_name = $_POST['table_name'];
$id = $_POST['data'];
$name = $_POST['name'];

$sql="select count(*) as numers from transaction where name_id = '$id' and name = '$name' and company_email = '$company_email'";
$new = $conn->query($sql);
while ($row = $new->fetch_assoc()) {
if($row['numers']=='0'){
$result="DELETE FROM `$tale_name` WHERE  `id` = '$id' and company_email = '$company_email'";
$new = $conn->query($result) or die (mysqli_error());	
echo "Deleted Successfully";
}else{
echo "Deletion cannot be processed because it has transactions";
}
}





/*********************************************************************************************/

?>