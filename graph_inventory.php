<?php
include("db.php");
$i=0;
$result = '';
$diff = 'month';
$date_to = date('Y-m').'-01';
$tot = '0';
$sql = "SELECT * FROM `items` WHERE `company_email` = '$company_email' AND `category` = 'Inventory' LIMIT 10";
$new = $conn->query($sql);
while($row = $new->fetch_assoc()){
  if($row['stock'] == ''){
    $row['stock'] = '0';
  }
  if($row['asset_value'] == '' || $row['asset_value'] < '0'){
  goto ends;
  }
  $result[$i][0]=$row['name']; 
  $result[$i][1]=$row['asset_value'];
  $i++;
  ends:
  $tot += $row['asset_value'];
}
header('Cache-Control: no-cache, must-revalidate');
header('Expires: Mon, 26 Jul 1997 05:00:00 GMT');
header('Content-type: application/json');
echo json_encode($result);

?>