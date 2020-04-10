<?php
include("db.php");
$user = $_GET['id'];
$id = $_GET['id'];
$name = $_GET['name'];
include("header.php");
if(isset($_GET['start']) || isset($_GET['end'])){
$date_from = date('Y-m-d' , strtotime($_GET['start']));
$date_to = date('Y-m-d' , strtotime($_GET['end']));
}else{
$date_to = date('Y-m-d');
$date_from  = date('Y-m-d', strtotime($date_to. ' -180 days'));
}
?>
<center>
<table __gwtcellbasedwidgetimpldispatchingfocus="true" __gwtcellbasedwidgetimpldispatchingblur="true" class="JKSCOO-k-y table-fixed-layout page-panel" cellspacing="0" style="width: 100%;padding:0px 10px 0px 10px">
  <thead>
      <tr class="JKSCOO-k-b table-row link">
                      <td class="JKSCOO-k-a JKSCOO-k-c" colspan="2"><B><strong>Type</B></td>
                      <td class="JKSCOO-k-a JKSCOO-k-c"><B><strong>Date</B></td>
                      <td class="JKSCOO-k-a JKSCOO-k-c"><B><strong>Num</B></td>
                      <td class="JKSCOO-k-a JKSCOO-k-c"><B><strong>Debit</B></td>
                      <td class="JKSCOO-k-a JKSCOO-k-c"><B><strong>Credit</B></td>
                      <td class="JKSCOO-k-a JKSCOO-k-c"><B><strong>Balance</B></td>
      </tr>
                  
<?php

  $total = '0';
  $dabit = '0';
  $credit = '0';
$sql_one = "SELECT * , (SELECT sum( total ) FROM transaction WHERE `date` < '$date_from' AND `entry_type`='create sales invoice' AND `company_email` = '$company_email' AND `name_id` = '$user')  AS invoice_total, ( SELECT sum( total ) FROM transaction WHERE `date` < '$date_from' AND `entry_type`='create Customer Payment' AND `company_email` = '$company_email' AND `name_id` = '$user') AS payment_total, (SELECT sum( total ) FROM transaction WHERE `date` < '$date_from' AND `entry_type` ='create sales return' AND `bank_id` != 0 AND `company_email` = '$company_email' AND `name_id` = '$user') AS return_total FROM transaction WHERE `company_email` = '$company_email'";
$new_one = $conn->query($sql_one);
while($row_one = $new_one->fetch_assoc()){
$total = $row_one['invoice_total'] - ($row_one['payment_total']+$row_one['return_total']);
}
$showed = '0';

if($total != '0'){
?>                  
      <tr class="JKSCOO-k-b table-row link" style="">
        <td class="JKSCOO-k-a JKSCOO-k-c" colspan="2" style="padding:15px 0px 0px 20px"><B>Opening Balance</B></td></td><td class="JKSCOO-k-a JKSCOO-k-c"></td><td class="JKSCOO-k-a JKSCOO-k-c"></td><td class="JKSCOO-k-a JKSCOO-k-c"></td><td class="JKSCOO-k-a JKSCOO-k-c"></td>
        <td class="JKSCOO-k-a JKSCOO-k-c" style="text-align:right;"><B><?php echo number_format($total, 2); ?> </B></td>
      </tr>

<?php
$showed = '1';
}
$sqli = "SELECT * FROM `transaction` WHERE `name_id` = '$id' AND `company_email` = '$company_email' AND (`entry_type` = 'create sales invoice' OR `entry_type` = 'create sales Receipt' OR `entry_type` = 'create Customer Payment' OR `entry_type` = 'create sales return') AND `date` BETWEEN '$date_from' AND '$date_to' ORDER BY  `id` ASC";
$news = $conn->query($sqli);
while ($rows = $news->fetch_assoc()) {
if($showed != '1'){
?>
      <tr class="JKSCOO-k-b table-row link" ng-repeat="x in data" style="">
        <td class="JKSCOO-k-a JKSCOO-k-c" colspan="2" style="padding:0px 0px 0px 20px;padding-top:0px"><B><?php echo $row['company_name']; ?></B></td><td class="JKSCOO-k-a JKSCOO-k-c"></td><td class="JKSCOO-k-a JKSCOO-k-c" ></td><td class="JKSCOO-k-a JKSCOO-k-c"></td><td class="JKSCOO-k-a JKSCOO-k-c"></td>
        <td class="JKSCOO-k-a JKSCOO-k-c" style="text-align:right;"><B><?php echo number_format($total, 2); ?> </B></td>
      </tr>

<?php
$showed = '1';
}
if($rows['entry_type'] == "create sales return"){
  $total -= $rows['total'];
  $credit += $rows['total'];
?>

                    <tr class="JKSCOO-k-b table-row link">
                      <td class="JKSCOO-k-a JKSCOO-k-c" colspan="2"  style="padding-left:110px;font-size:medium;line-height: 13px">Sales Return</td>
                      <td class="JKSCOO-k-a JKSCOO-k-c"><?php echo date('d/m/Y', strtotime($rows['date'])); ?></td>
                      <td class="JKSCOO-k-a JKSCOO-k-c" style="padding-left: 2px" ><?php echo $rows['transaction_number']; ?></td>
                      <td class="JKSCOO-k-a JKSCOO-k-c"></td>
                      <td class="JKSCOO-k-a JKSCOO-k-c" style="text-align:right;padding-left:8px"><?php echo number_format($rows['total'], 2); ?></td>
                      <td class="JKSCOO-k-a JKSCOO-k-c" style="text-align:right;"><?php echo number_format($total, 2); ?></td>
                    </tr>
<?php if($rows['cheque_no'] != ''){   $total += $rows['total'];   $dabit += $rows['total']; ?>
                    <tr class="JKSCOO-k-b table-row link">
                      <td class="JKSCOO-k-a JKSCOO-k-c" colspan="2"  style="padding-left:110px;font-size:medium;line-height: 13px">Bank</td>
                      <td class="JKSCOO-k-a JKSCOO-k-c" style="font-size: medium;line-height: 18px;"><?php echo date('d/m/Y', strtotime($rows['date'])); ?></td>
                      <td class="JKSCOO-k-a JKSCOO-k-c" style="font-size: medium;line-height: 18px;padding-left: 2px" ><?php echo $rows['transaction_number']; ?></td>
                      <td class="JKSCOO-k-a JKSCOO-k-c" style="font-size: medium;line-height: 18px;text-align:right;padding-left:8px"><?php echo  number_format($rows['total'], 2); ?></td>
                      <td class="JKSCOO-k-a JKSCOO-k-c"></td>
                      <td class="JKSCOO-k-a JKSCOO-k-c" style="font-size: medium;line-height: 18px;text-align:right;padding-left:8px"><?php echo  number_format($total, 2); ?></td>
                    </tr>
<?php } ?>
  <?php
}
if($rows['entry_type'] == "create sales invoice" || $rows['entry_type'] == "create sales Receipt"){
  $total += $rows['total'];
  $dabit += $rows['total'];
?>


                    <tr class="JKSCOO-k-b table-row link">
                      <td class="JKSCOO-k-a JKSCOO-k-c" colspan="2"  style="padding-left:110px;font-size:medium;line-height: 13px"><?php if($rows['entry_type'] == "create sales invoice"){ echo "Sales Invoice"; }else{ echo "Sales Receipt"; } ?></td>
                      <td class="JKSCOO-k-a JKSCOO-k-c" style="font-size: medium;line-height: 18px;"><?php echo date('d/m/Y', strtotime($rows['date'])); ?></td>
                      <td class="JKSCOO-k-a JKSCOO-k-c" style="font-size: medium;line-height: 18px;padding-left: 2px" ><?php echo $rows['transaction_number']; ?></td>
                      <td class="JKSCOO-k-a JKSCOO-k-c" style="font-size: medium;line-height: 18px;text-align:right;padding-left:8px"><?php echo  number_format($rows['total'], 2); ?></td>
                      <td class="JKSCOO-k-a JKSCOO-k-c"></td>
                      <td class="JKSCOO-k-a JKSCOO-k-c" style="font-size: medium;line-height: 18px;text-align:right;padding-left:8px"><?php echo number_format($total, 2); ?></td>
                    </tr>
<?php if($rows['entry_type'] == "create sales Receipt"){   $total -= $rows['total'];   $credit += $rows['total']; ?>
                    <tr class="JKSCOO-k-b table-row link">
                      <td class="JKSCOO-k-a JKSCOO-k-c" colspan="2"  style="padding-left:110px;font-size:medium;line-height: 13px">Bank</td>
                      <td class="JKSCOO-k-a JKSCOO-k-c" style="font-size: medium;line-height: 18px;"><?php echo date('d/m/Y', strtotime($rows['date'])); ?></td>
                      <td class="JKSCOO-k-a JKSCOO-k-c" style="font-size: medium;line-height: 18px;padding-left: 2px" ><?php echo $rows['transaction_number']; ?></td>
                      <td class="JKSCOO-k-a JKSCOO-k-c"></td>
                      <td class="JKSCOO-k-a JKSCOO-k-c" style="font-size: medium;line-height: 18px;text-align:right;padding-left:8px"><?php echo  number_format($rows['total'], 2); ?></td>
                      <td class="JKSCOO-k-a JKSCOO-k-c" style="font-size: medium;line-height: 18px;text-align:right;padding-left:8px"><?php echo  number_format($total, 2); ?></td>
                    </tr>
<?php } ?>
<?php 

}
if($rows['entry_type'] == "create Customer Payment"){
  $total -= $rows['total'];
  $credit += $rows['total'];
?>

                    <tr class="JKSCOO-k-b table-row link">
                      <td class="JKSCOO-k-a JKSCOO-k-c" colspan="2"  style="padding-left:110px;font-size: medium;line-height: 13px">Customer Payment</td>
                      <td class="JKSCOO-k-a JKSCOO-k-c" style="font-size: medium;line-height: 18px;"><?php echo date('d/m/Y', strtotime($rows['date'])); ?></td>
                      <td class="JKSCOO-k-a JKSCOO-k-c" style="font-size: medium;line-height: 18px;padding-left: 2px" ><?php echo $rows['transaction_number']; ?></td>
                      <td class="JKSCOO-k-a JKSCOO-k-c"></td>
                      <td class="JKSCOO-k-a JKSCOO-k-c" style="font-size: medium;line-height: 18px;text-align:right;padding-left:8px"><?php echo  number_format($rows['total'], 2); ?></td>
                      <td class="JKSCOO-k-a JKSCOO-k-c" style="font-size: medium;line-height: 18px;text-align:right;padding-left:8px"><?php echo  number_format($total, 2); ?></td>
                    </tr>
<?php
}

}
if($dabit != '0' || $credit != '0'){
?>


                    <tr class="JKSCOO-k-b table-row link">
                      <td class="JKSCOO-k-a JKSCOO-k-c" colspan="2"  style="padding:10px 0px 0px 20px"> <B>Total <?php echo $row['company_name']; ?></B></td>
                      <td class="JKSCOO-k-a JKSCOO-k-c"> <B></B></td>
                      <td class="JKSCOO-k-a JKSCOO-k-c" style="" > <B></B></td>
                      <td class="JKSCOO-k-a JKSCOO-k-c" style="text-align:right;border-top: 1px solid #000;padding-top: 10px"> <B><?php echo number_format($dabit, 2); ?></B></td>
                      <td class="JKSCOO-k-a JKSCOO-k-c" style="text-align:right;border-top: 1px solid #000;padding-top: 10px"> <B><?php echo number_format($credit, 2); ?></B></td>
                      <td class="JKSCOO-k-a JKSCOO-k-c" style="text-align:right;border-top: 1px solid #000;padding-top: 10px"> <B><?php echo number_format($total, 2); ?></B></td>
                    </tr>
<?php 
}

?>                      





  </thead>
</table>
</center>