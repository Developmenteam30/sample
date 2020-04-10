  <?php
include("db.php");
$i = '0';
$id = $_GET['id'];
include("header.php");

if(isset($_GET['start']) && isset($_GET['end'])){
$date_from = date('Y-m-d', strtotime($_GET['start']));
$date_to = date('Y-m-d', strtotime($_GET['end']));
$user = $_GET['user'];
echo $item = $_GET['item'];
$amount = $_GET['amount'];
if($_REQUEST['amount_filter'] == 'equal'){
$amount_filter = '=';
}elseif($_REQUEST['amount_filter'] == 'greater'){
$amount_filter = '>=';
}elseif($_REQUEST['amount_filter'] == 'less'){
$amount_filter = '<=';
}else{
$amount_filter = 'LIKE';
}
}else{
$amount_filter = 'LIKE';
$date_to = date('Y-m-d');
$date_from  = date('Y-m-d', strtotime($date_to. ' -180 days'));
}

$g_qty='0';
$g_amount='0';
$g_balance='0';
$sql = "SELECT * FROM `items` WHERE `id` = '$id'";
$new = $conn->query($sql);
while($row = $new->fetch_assoc()){
  $item_category = $row['category'];
  $item = $row['name'];

  }
?>
                 

                      <table  __gwtcellbasedwidgetimpldispatchingfocus="true" __gwtcellbasedwidgetimpldispatchingblur="true" class="JKSCOO-k-y table-fixed-layout page-panel" cellspacing="0" style="width: 100%;padding:0px 10px 0px 10px">
                  <thead>
                   <tr  class="JKSCOO-k-b table-row link">
                      <td class="JKSCOO-k-a JKSCOO-k-c" style="width: 22%;text-align: center;border-bottom: 1px solid #000"><B>Type</B></td>
                      <td class="JKSCOO-k-a JKSCOO-k-c" style="width: 14%;text-align: center;border-bottom: 1px solid #000"><B>Date</B></td>
                      <td class="JKSCOO-k-a JKSCOO-k-c" style="width: 10%;text-align: center;border-bottom: 1px solid #000"><B>Num</B></td>
                      <td class="JKSCOO-k-a JKSCOO-k-c" style="width: 14%;text-align: center;border-bottom: 1px solid #000"><B>Name</B></td>
                      <td class="JKSCOO-k-a JKSCOO-k-c" style="width: 10%;text-align: center;border-bottom: 1px solid #000"><B>Qty</B></td>
                      <td class="JKSCOO-k-a JKSCOO-k-c" style="width: 10%;text-align: center;border-bottom: 1px solid #000"><B>Sales Price</B></td>
                      <td class="JKSCOO-k-a JKSCOO-k-c" style="width: 10%;text-align: center;border-bottom: 1px solid #000"><B>Amount</B></td>
                      <td class="JKSCOO-k-a JKSCOO-k-c" style="width: 10%;text-align: center;border-bottom: 1px solid #000"><B>Balance</B></td>
                    </tr>
                  </thead><tbody>
<?php if($item_category == 'Inventory'){ ?>                    
                    <tr  class="JKSCOO-k-b table-row link">
                      <th style="text-align: left;padding-left: 0px "><b>STOCK</b></th>
                    </tr>

<?php

$sql = "SELECT * FROM `sales_item` WHERE `item_category` = 'Inventory' AND (`type` = 'create sales invoice' OR `type` = 'create sales Receipt' OR `type` = 'create sales return') AND `company_email` = '$company_email' AND `item_id` LIKE '$id' AND `item_name` LIKE '%$item%' AND `date` BETWEEN '$date_from' AND '$date_to' GROUP BY  `item_id`  ORDER BY  `item_name` ";
$new = $conn->query($sql);
while($row = $new->fetch_assoc()){
$id = $row['item_id'];
$amount = '0';
$qty = '0';
?>
                    <tr  class="JKSCOO-k-b table-row link">
                      <td class="JKSCOO-k-a JKSCOO-k-c" style="padding: 0px 0px 0px 40px;display:inline-block; width:150px; white-space: nowrap; overflow:hidden !important; text-overflow: ellipsis;"><b><?php echo $row['item_name']; ?></b></td>
                    </tr>

<?php
if($amount_filter == 'LIKE'){
$sqli = "SELECT * FROM `sales_item` WHERE `item_category` = 'Inventory' AND (`type` = 'create sales invoice' OR `type` = 'create sales Receipt' OR `type` = 'create sales return') AND `company_email` = '$company_email' AND `item_id` = '$id' AND `item_name` LIKE '%$item%' AND `amount` LIKE '%$amounts%' AND `date` BETWEEN '$date_from' AND '$date_to' GROUP BY  `type`";
}else{
$sqli = "SELECT * FROM `sales_item` WHERE `item_category` = 'Inventory' AND (`type` = 'create sales invoice' OR `type` = 'create sales Receipt' OR `type` = 'create sales return') AND `company_email` = '$company_email' AND `item_id` = '$id' AND `item_name` LIKE '%$item%' AND `amount` $amount_filter '$amounts' AND `date` BETWEEN '$date_from' AND '$date_to' GROUP BY  `type`";
}

$news = $conn->query($sqli);
while ($rows = $news->fetch_assoc()) {
$sales_idh = $rows['sales_id'];
if($rows['type'] == 'create sales return'){
$qty -= $rows['item_quantity'];
$amount -= $rows['amount'];
}else{
$qty += $rows['item_quantity'];
$amount += $rows['amount'];
}
  $sql10 = "SELECT * FROM `transaction` WHERE `id` = '$sales_idh'";
$news10 = $conn->query($sql10);
while ($rows10 = $news10->fetch_assoc()) {
?>
                    <tr  class="JKSCOO-k-b table-row link">
                      <td class="JKSCOO-k-a JKSCOO-k-c" style="padding: 0px 0px 0px 40px"><?php if($rows['type'] == 'create sales Receipt'){ echo 'Sales Receipt'; }elseif($rows['type'] == 'create sales invoice'){ echo 'Sales Invoice'; }else{ echo 'Sales Return'; } ?></td>
                      <td class="JKSCOO-k-a JKSCOO-k-c" style="text-align: center;"><?php echo date("d-m-Y",strtotime($rows10['date'])); ?> </td>
                      <td class="JKSCOO-k-a JKSCOO-k-c" style="text-align: center;"><?php echo $rows10['transaction_number']; ?></td>
                      <td class="JKSCOO-k-a JKSCOO-k-c" style="text-align: left;display:inline-block; width:110px; white-space: nowrap; overflow:hidden !important; text-overflow: ellipsis;"><?php echo $row['item_name']; ?></td>
                      <td class="JKSCOO-k-a JKSCOO-k-c" style="text-align: right;"><?php if($rows['type'] == 'create sales return'){ echo '-'.$rows['item_quantity']; }else{ echo $rows['item_quantity']; } ?></td>
                      <td class="JKSCOO-k-a JKSCOO-k-c" style="text-align: right;"><?php echo number_format($rows['price_rate'], 2); ?></td>
                      <td class="JKSCOO-k-a JKSCOO-k-c" style="text-align: right;"><?php if($rows['type'] == 'create sales return'){ echo '-'.number_format($rows['amount'], 2); }else{  echo number_format($rows['amount'], 2); } ?></td>
                      <td class="JKSCOO-k-a JKSCOO-k-c" style="text-align: right;"><?php echo number_format($amount, 2); ?></td>
                    </tr>

<?php
}
}
$g_qty+=$qty;
$g_amount+=$amount;
$g_balance+=$amount;
?>

                                      <tr  class="JKSCOO-k-b table-row link">
                      <td class="JKSCOO-k-a JKSCOO-k-c" style="text-align: left;padding: 0px 0px 0px 0px "> <b>Total </b></td>
                      <td class="JKSCOO-k-a JKSCOO-k-c" style="text-align: right;"> <B></B></td>
                      <td class="JKSCOO-k-a JKSCOO-k-c" style="text-align: right;"> <B></B></td>
                      <td class="JKSCOO-k-a JKSCOO-k-c" style="text-align: right;"> <B></B></td>
                      <td class="JKSCOO-k-a JKSCOO-k-c" style="text-align: right;border-top: 1px solid #000"> <B><?php echo $qty; ?></B></td>
                      <td class="JKSCOO-k-a JKSCOO-k-c" style="text-align: right;border-top: 1px solid #000"> <B></B></td>
                      <td class="JKSCOO-k-a JKSCOO-k-c" style="text-align: right;border-top: 1px solid #000"> <B><?php echo number_format($amount, 2); ?></B></td>
                      <td class="JKSCOO-k-a JKSCOO-k-c" style="text-align: right;border-top: 1px solid #000"> <B><?php echo number_format($amount, 2); ?></B></td>
                    </tr>
<?php
}
}else{

?>
                    <tr  class="JKSCOO-k-b table-row link">
                      <th style="text-align: left;padding-left: 0px "><b>SERVICES</b></th>
                    </tr>

<?php
$sql = "SELECT * FROM `sales_item` WHERE `item_category` != 'Inventory' AND (`type` = 'create sales invoice' OR `type` = 'create sales Receipt' OR `type` = 'create sales return') AND `company_email` = '$company_email' AND `item_name` LIKE '%$item%' AND `date` BETWEEN '$date_from' AND '$date_to' GROUP BY  `item_id`  ORDER BY  `item_name` ";
$new = $conn->query($sql);
while($row = $new->fetch_assoc()){
$id = $row['item_id'];
$amount = '0';
$qty = '0';
?>
                    <tr  class="JKSCOO-k-b table-row link">
                      <td class="JKSCOO-k-a JKSCOO-k-c" style="padding: 0px 0px 0px 40px;display:inline-block; width:150px; white-space: nowrap; overflow:hidden !important; text-overflow: ellipsis;"><b><?php echo $row['item_name']; ?></b></td>
                    </tr>

<?php
if($amount_filter == 'LIKE'){
$sqli = "SELECT * FROM `sales_item` WHERE `item_category` != 'Inventory' AND (`type` = 'create sales invoice' OR `type` = 'create sales Receipt' OR `type` = 'create sales return') AND `company_email` = '$company_email' AND `item_id` = '$id' AND `item_name` LIKE '%$item%' AND `amount` LIKE '%$amounts%'  AND `date` BETWEEN '$date_from' AND '$date_to' GROUP BY  `type`";
}else{
$sqli = "SELECT * FROM `sales_item` WHERE `item_category` != 'Inventory' AND (`type` = 'create sales invoice' OR `type` = 'create sales Receipt' OR `type` = 'create sales return') AND `company_email` = '$company_email' AND `item_id` = '$id' AND `item_name` LIKE '%$item%' AND `amount` $amount_filter '$amounts'  AND `date` BETWEEN '$date_from' AND '$date_to' GROUP BY  `type`";
}
$news = $conn->query($sqli);
while ($rows = $news->fetch_assoc()) {
$sales_idh = $rows['sales_id'];
if($rows['type'] == 'create sales return'){
$qty -= $rows['item_quantity'];
$amount -= $rows['amount'];
}else{
$qty += $rows['item_quantity'];
$amount += $rows['amount'];
}
  $sql10 = "SELECT * FROM `transaction` WHERE `id` = '$sales_idh'";
$news10 = $conn->query($sql10);
while ($rows10 = $news10->fetch_assoc()) {
?>
                    <tr  class="JKSCOO-k-b table-row link">
                      <td class="JKSCOO-k-a JKSCOO-k-c" style="padding: 0px 0px 0px 40px;"><?php if($rows['type'] == 'create sales Receipt'){ echo 'Sales Receipt'; }elseif($rows['type'] == 'create sales invoice'){ echo 'Sales Invoice'; }else{ echo 'Sales Return'; } ?></td>
                      <td class="JKSCOO-k-a JKSCOO-k-c" style="text-align: center;"><?php echo date("d-m-Y",strtotime($rows10['date'])); ?> </td>
                      <td class="JKSCOO-k-a JKSCOO-k-c" style="text-align: center;"><?php echo $rows10['transaction_number']; ?></td>
                      <td class="JKSCOO-k-a JKSCOO-k-c" style="text-align: center;"><?php echo $row['item_name']; ?></td>
                      <td class="JKSCOO-k-a JKSCOO-k-c" style="text-align: right;"><?php echo $rows['item_quantity']; ?></td>
                      <td class="JKSCOO-k-a JKSCOO-k-c" style="text-align: right;"><?php echo number_format($rows['price_rate'], 2); ?></td>
                      <td class="JKSCOO-k-a JKSCOO-k-c" style="text-align: right;"><?php echo number_format($rows['amount'], 2); ?></td>
                      <td class="JKSCOO-k-a JKSCOO-k-c" style="text-align: right;"><?php echo  number_format($amount, 2); ?></td>
                    </tr>

<?php
}
}
$g_qty+=$qty;
$g_amount+=$amount;
$g_balance+=$amount;
?>

                                      <tr  class="JKSCOO-k-b table-row link">
                      <td class="JKSCOO-k-a JKSCOO-k-c" style="text-align: left;padding: 0px 0px 0px 0px "> <b>Total </b></td>
                      <td class="JKSCOO-k-a JKSCOO-k-c" style="text-align: right;"> <B></B></td>
                      <td class="JKSCOO-k-a JKSCOO-k-c" style="text-align: right;"> <B></B></td>
                      <td class="JKSCOO-k-a JKSCOO-k-c" style="text-align: right;"> <B></B></td>
                      <td class="JKSCOO-k-a JKSCOO-k-c" style="text-align: right;border-top: 1px solid #000"> <B><?php echo $qty; ?></B></td>
                      <td class="JKSCOO-k-a JKSCOO-k-c" style="text-align: right;border-top: 1px solid #000"> <B></B></td>
                      <td class="JKSCOO-k-a JKSCOO-k-c" style="text-align: right;border-top: 1px solid #000"> <B><?php echo number_format($amount, 2); ?></B></td>
                      <td class="JKSCOO-k-a JKSCOO-k-c" style="text-align: right;border-top: 1px solid #000"> <B><?php echo number_format($amount, 2); ?></B></td>
                    </tr>
<?php
}
}
?>
</tbody>
                </table>