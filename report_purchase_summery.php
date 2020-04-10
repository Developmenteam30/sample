  <?php
include("db.php");
$i = '0';
$id = $_GET['id'];
include("header.php");
if(isset($_GET['start']) && isset($_GET['end'])){
$date_from = date('Y-m-d', strtotime($_GET['start']));
$date_to = date('Y-m-d', strtotime($_GET['end']));
$user = $_GET['user'];
$item = $_GET['item'];
$amount = $_GET['amount'];
$amount_filter = $_REQUEST['amount_filter'];
}else{
$amount_filter = 'LIKE';
$date_to = date('Y-m-d');
$date_from  = date('Y-m-d', strtotime($date_to. ' -980 days'));
}

$g_qty='0';
$g_amount='0';
$g_balance='0';
$sql = "SELECT * FROM `items` WHERE `id` = '$id'";
$new = $conn->query($sql);
while($row = $new->fetch_assoc()){
  $item_category = $row['category'];
  }
?>
                  <table  __gwtcellbasedwidgetimpldispatchingfocus="true" __gwtcellbasedwidgetimpldispatchingblur="true" class="JKSCOO-k-y table-fixed-layout page-panel" cellspacing="0" style="width: 100%;padding:0px 10px 0px 10px">
                   <tr  class="JKSCOO-k-b table-row link">
                      <td class="JKSCOO-k-a JKSCOO-k-c" style="width: 24%;border-bottom: 1px solid #000"><B>Type</B></td>
                      <td class="JKSCOO-k-a JKSCOO-k-c" style="width: 12%;border-bottom: 1px solid #000;text-align: center;"><B>Date</B></td>
                      <td class="JKSCOO-k-a JKSCOO-k-c" style="width: 6%;border-bottom: 1px solid #000;text-align: center;"><B>Num</B></td>
                      <td class="JKSCOO-k-a JKSCOO-k-c" style="width: 22%;border-bottom: 1px solid #000;text-align: center;"><B>Source Name</B></td>
                      <td class="JKSCOO-k-a JKSCOO-k-c" style="width: 6%;border-bottom: 1px solid #000;text-align: center;"><B>Qty</B></td>
                      <td class="JKSCOO-k-a JKSCOO-k-c" style="width: 10%;border-bottom: 1px solid #000;text-align: center;"><B>Cost Price</B></td>
                      <td class="JKSCOO-k-a JKSCOO-k-c" style="width: 10%;border-bottom: 1px solid #000;text-align: center;"><B>Amount</B></td>
                      <td class="JKSCOO-k-a JKSCOO-k-c" style="width: 10%;border-bottom: 1px solid #000;text-align: center;"><B>Balance</B></td>
                    </tr>
<?php if($item_category == 'Inventory'){ ?>                    
                    <tr  class="JKSCOO-k-b table-row link">
                      <th style="padding: 0px 0px 0px 20px;text-align: left;"><b>Stock</b></th>
                    </tr>

<?php
$sql = "SELECT * FROM `purchase_item` WHERE `item_category` = 'Inventory' AND (`type` = 'create purchase invoice' OR `type` = 'Create purchase Receipt' OR `type` = 'create purchase return') AND `company_email` = '$company_email' AND `item_id` LIKE '$id' AND `item_name` LIKE '%$item%' AND `date` BETWEEN '$date_from' AND '$date_to'  GROUP BY  `item_id`  ORDER BY  `item_name` ";

$new = $conn->query($sql);
while($row = $new->fetch_assoc()){
$id = $row['item_id'];
$amount = '0';
$qty = '0';
$item_name = $row['item_name'];
?>
                    <tr  class="JKSCOO-k-b table-row link">
                      <td class="JKSCOO-k-a JKSCOO-k-c" style="padding: 0px 0px 0px 31px;display:inline-block; width:140px; white-space: nowrap; overflow:hidden !important; text-overflow: ellipsis; "><b><?php echo $row['item_name']; ?></b></td>
                    </tr>

<?php
$sqli = "SELECT * FROM `purchase_item` WHERE `item_category` = 'Inventory' AND (`type` = 'create purchase invoice' OR `type` = 'Create purchase Receipt' OR `type` = 'create purchase return') AND `company_email` = '$company_email' AND `item_id` = '$id' AND `item_name` LIKE '%$item%' AND `date` BETWEEN '$date_from' AND '$date_to' GROUP BY  `type`";
$news = $conn->query($sqli);
while ($rows = $news->fetch_assoc()) {
$purchase_idh = $rows['purchase_id'];
if($rows['type'] == 'create purchase return'){
$qty -= $rows['item_quantity'];
$amount -= $rows['amount'];
}else{
$qty += $rows['item_quantity'];
$amount += $rows['amount'];
}
  $sql10 = "SELECT * FROM `transaction` WHERE `id` = '$purchase_idh'";
$news10 = $conn->query($sql10);
while ($rows10 = $news10->fetch_assoc()) {
?>
                    <tr  class="JKSCOO-k-b table-row link">
                      <td class="JKSCOO-k-a JKSCOO-k-c" style="padding: 0px 0px 0px 30px "><?php if($rows['type'] == 'create sales Receipt'){ echo 'Purchase Receipt'; }elseif($rows['type'] == 'create purchase invoice'){ echo 'Purchase Invoice'; }else{ echo 'Purchase Return'; } ?></td>
                      <td class="JKSCOO-k-a JKSCOO-k-c" style="text-align: left;"><?php echo date("d-m-Y", strtotime($rows10['date'])); ?> </td>
                      <td class="JKSCOO-k-a JKSCOO-k-c" style="text-align: right;padding: 0px 25px 0px 0px "><?php echo $rows10['transaction_number']; ?></td>
                      <td class="JKSCOO-k-a JKSCOO-k-c" style="text-align: left;display:inline-block; width:210px; white-space: nowrap; overflow:hidden !important; text-overflow: ellipsis;"><?php echo $rows10['name']; ?></td>
                      <td class="JKSCOO-k-a JKSCOO-k-c" style="text-align: right;padding: 0px 0px 0px 0px "><?php if($rows['type'] == 'create purchase return'){ echo '-'.$rows['item_quantity']; }else{ echo $rows['item_quantity']; } ?></td>
                      <td class="JKSCOO-k-a JKSCOO-k-c" style="text-align: right;"><?php if($rows['type'] == 'create purchase return'){ echo '-'.number_format($rows['amount'], 2); }else{ echo number_format($rows['amount'], 2); } ?></td>
                      <td class="JKSCOO-k-a JKSCOO-k-c" style="text-align: right;"><?php if($rows['type'] == 'create purchase return'){ echo '-'.number_format($rows['amount'], 2); }else{ echo number_format($rows['amount'], 2); } ?></td>
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
                      <td class="JKSCOO-k-a JKSCOO-k-c" style="padding: 0px 0px 0px 0px "> <B>Total <?php echo $item_name; ?></B></td>
                      <td class="JKSCOO-k-a JKSCOO-k-c" style="text-align: left;"> <B></B></td>
                      <td class="JKSCOO-k-a JKSCOO-k-c" style="text-align: left;"> <B></B></td>
                      <td class="JKSCOO-k-a JKSCOO-k-c" style="text-align: left;"> <B></B></td>
                      <td class="JKSCOO-k-a JKSCOO-k-c" style="border-bottom: 1px solid #000;border-top: 1px solid #000;padding: 0px 0px 0px 0px;text-align: right; "> <b><?php echo $qty; ?></b></td>
                      <td class="JKSCOO-k-a JKSCOO-k-c" style="border-bottom: 1px solid #000;border-top: 1px solid #000"> <b></b></td>
                      <td class="JKSCOO-k-a JKSCOO-k-c" style="text-align: right;border-bottom: 1px solid #000;border-top: 1px solid #000"> <b><?php echo  number_format($amount, 2); ?></b></td>
                      <td class="JKSCOO-k-a JKSCOO-k-c" style="text-align: right;border-bottom: 1px solid #000;border-top: 1px solid #000"> <b><?php echo  number_format($amount, 2); ?></b></td>
                    </tr>
<?php
}
}else{
?>
                    <tr  class="JKSCOO-k-b table-row link">
                      <th style="padding: 0px 0px 0px 30px;text-align: left;"><b>Service</b></th>
                    </tr>

<?php
$sql = "SELECT * FROM `purchase_item` WHERE `item_category` != 'Inventory' AND (`type` = 'create purchase invoice' OR `type` = 'Create purchase Receipt' OR `type` = 'create purchase return')  AND `company_email` = '$company_email' AND `item_name` LIKE '%$item%'  GROUP BY  `item_id`  ORDER BY  `item_name` ";
$new = $conn->query($sql);
while($row = $new->fetch_assoc()){
$id = $row['item_id'];
$amount = '0';
$qty = '0';
$item_name = $row['item_name'];
?>
                    <tr  class="JKSCOO-k-b table-row link">
                      <td class="JKSCOO-k-a JKSCOO-k-c" style="padding: 0px 0px 0px 31px;display:inline-block; width:140px; white-space: nowrap; overflow:hidden !important; text-overflow: ellipsis; "><b><?php echo $row['item_name']; ?></b></td>
                    </tr>

<?php
$sqli = "SELECT * FROM `purchase_item` WHERE `item_category` != 'Inventory' AND (`type` = 'create purchase invoice' OR `type` = 'Create purchase Receipt' OR `type` = 'create purchase return')  AND `company_email` = '$company_email' AND `item_id` = '$id'   GROUP BY  `type`";
$news = $conn->query($sqli);
while ($rows = $news->fetch_assoc()) {
$sales_idh = $rows['purchase_id'];
$qty += $rows['item_quantity'];
$amount += $rows['amount'];
  $sql10 = "SELECT * FROM `transaction` WHERE `id` = '$sales_idh'";
$news10 = $conn->query($sql10);
while ($rows10 = $news10->fetch_assoc()) {
?>
                    <tr  class="JKSCOO-k-b table-row link">
                      <td class="JKSCOO-k-a JKSCOO-k-c" style="padding: 0px 0px 0px 30px "><?php if($rows['type'] == 'Create purchase Receipt'){ echo 'Receipt'; }elseif($rows['type'] == 'create purchase invoice'){ echo 'Invoice'; }else{ echo 'Return'; } ?></td>
                      <td class="JKSCOO-k-a JKSCOO-k-c" style="text-align: left;"><?php echo date("d-m-Y", strtotime($rows10['date'])); ?> </td>
                      <td class="JKSCOO-k-a JKSCOO-k-c" style="text-align: right;padding: 0px 25px 0px 0px "><?php echo $rows10['transaction_number']; ?></td>
                      <td class="JKSCOO-k-a JKSCOO-k-c" style="text-align: left;display:inline-block; width:210px; white-space: nowrap; overflow:hidden !important; text-overflow: ellipsis;"><?php echo $rows10['name']; ?></td>
                      <td class="JKSCOO-k-a JKSCOO-k-c" style="text-align: right;padding: 0px 0px 0px 0px "><?php echo $rows['item_quantity']; ?></td>
                      <td class="JKSCOO-k-a JKSCOO-k-c" style="text-align: right;"><?php echo number_format($rows['price_rate'], 2); ?></td>
                      <td class="JKSCOO-k-a JKSCOO-k-c" style="text-align: right;"><?php echo number_format($rows['amount'], 2); ?></td>
                      <td class="JKSCOO-k-a JKSCOO-k-c" style="text-align: right;"><?php echo number_format($amount, 2); ?></td>
                    </tr>

<?php
}
}

$g_qty+=$qty;
$g_amount+=$amount;
$g_balance+=$amount;

?>                   <tr  class="JKSCOO-k-b table-row link">
                      <td class="JKSCOO-k-a JKSCOO-k-c" style="padding: 0px 0px 0px 0px "> <B>Total <?php echo $item_name; ?></B></td>
                      <td class="JKSCOO-k-a JKSCOO-k-c" style="text-align: left;"> <B></B></td>
                      <td class="JKSCOO-k-a JKSCOO-k-c" style="text-align: left;"> <B></B></td>
                      <td class="JKSCOO-k-a JKSCOO-k-c" style="text-align: left;"> <B></B></td>
                      <td class="JKSCOO-k-a JKSCOO-k-c" style="border-bottom: 1px solid #000;border-top: 1px solid #000;padding: 0px 0px 0px 0px;text-align: right; "> <b><?php echo $qty; ?></b></td>
                      <td class="JKSCOO-k-a JKSCOO-k-c" style="border-bottom: 1px solid #000;border-top: 1px solid #000"> <b></b></td>
                      <td class="JKSCOO-k-a JKSCOO-k-c" style="text-align: right;border-bottom: 1px solid #000;border-top: 1px solid #000"> <b><?php echo number_format($amount, 2); ?></b></td>
                      <td class="JKSCOO-k-a JKSCOO-k-c" style="text-align: right;border-bottom: 1px solid #000;border-top: 1px solid #000"> <b><?php echo number_format($amount, 2); ?></b></td>
                    </tr>
<?php
}
}
?>
                </table>