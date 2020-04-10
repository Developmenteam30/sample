<?php
include("db.php");

$i = '0';
?>


<?php
if(isset($_GET['end'])){
$date_from = date('Y-m-d', strtotime($_GET['start']));
$date_to = date('Y-m-d', strtotime($_GET['end']));
}else{
$date_to = date('Y-m-d');
$date_from  = date('Y-m-d', strtotime($date_to. ' -180 days'));
}
echo '<center>
<table  __gwtcellbasedwidgetimpldispatchingfocus="true" __gwtcellbasedwidgetimpldispatchingblur="true" class="JKSCOO-k-y table-fixed-layout page-panel" cellspacing="0" style="width: 100%;padding:0px 10px 0px 10px">';

$total_two_total = '0'; 
$total_thr_total = '0';
$total_fr_total = '0';
$total_fve_total = '0';
$total_six_total = '0';

$row_total = '0';

$total_balance = '0';
$total_two = '0';
$total_thr = '0';
$total_fr = '0';
$total_fve = '0';
$total_six = '0';

$col_total = '0';

$name_id = $_GET['id'];
$sql = "SELECT * ,(SELECT SUM(due_amt) FROM `transaction` WHERE `entry_type` = 'create purchase invoice' AND `name` = vendor.company_name AND `date` <= '$date_to' AND `company_email` = '$company_email') AS `values`  FROM vendor WHERE vendor.company_email = '$company_email' AND vendor.id = '$name_id'";
$new = $conn->query($sql);
$row = $new->fetch_assoc();

$dates = $date_to; 
$datei = $date_to;
$date1  = date('Y-m-d', strtotime($datei. ' - 1 days'));
$date30  = date('Y-m-d', strtotime($datei. ' - 30 days'));
$date31  = date('Y-m-d', strtotime($datei. ' - 31 days'));
$date60  = date('Y-m-d', strtotime($datei. ' - 60 days'));
$date61  = date('Y-m-d', strtotime($datei. ' - 61 days'));
$date90  = date('Y-m-d', strtotime($datei. ' - 90 days'));
?>  

<!-- *****************************CURRENT DATE**************************** -->

<!-- *****************************CURRENT DATE**************************** -->
<?php  
$sql2 = "SELECT * ,SUM(due_amt) AS `totr`, ( SELECT sum( total ) FROM transaction WHERE `entry_type` ='create purchase return' AND ( `cheque_no` = '' OR `cheque_no` = 'undefined') AND `company_email` = '$company_email' AND `name_id` = '$name_id' AND `date` = '$dates') AS `return_tot` FROM `transaction` WHERE `entry_type` = 'create purchase invoice'  AND `name_id` = '$name_id' AND `date` = '$dates' AND `company_email` = '$company_email'";
$newtwo = $conn->query($sql2);
while ($row_two = $newtwo->fetch_assoc()){
$datei = $row_two['date'];
 $sqli_c = "SELECT * FROM `transaction` WHERE `name_id` = '$name_id' AND `entry_type` = 'Journal' AND `name` = 'vendor' AND `company_email` = '$company_email' AND `date` = '$dates'";
  $news_c = $conn->query($sqli_c);
  if($news_c->num_rows != 0){
    $total_two = $row['opening_balance']+$row_two['totr']-$row_two['return_tot'];
    $total_two_total += $row['opening_balance']+$row_two['totr']-$row_two['return_tot'];
  }else{
    $total_two = $row_two['totr']-$row_two['return_tot'];
    $total_two_total += $row_two['totr']-$row_two['return_tot'];
  }
?>
                    <tr class="JKSCOO-k-b table-row link">
                      <td class="JKSCOO-k-a JKSCOO-k-c"><b><strong>Current</strong></b></td>
                      <td class="JKSCOO-k-a JKSCOO-k-c" style="text-align: left;">
                        <?php if(isset($total_two)){  echo number_format($total_two, 2); }else{ echo number_format('0.00', 2); }  ?>
                      </td>
                    </tr>
<!-- *****************************OLD 30 DATE**************************** -->
<?php  }
$sql3 = "SELECT * ,SUM(due_amt) AS `totr`, ( SELECT sum( total ) FROM transaction WHERE `entry_type` ='create purchase return' AND ( `cheque_no` = '' OR `cheque_no` = 'undefined') AND `company_email` = '$company_email' AND `name_id` = '$name_id' AND `date` BETWEEN '$date30' AND '$date1') AS `return_tot` FROM `transaction` WHERE `entry_type` = 'create purchase invoice' AND `name_id` = '$name_id' AND `company_email` = '$company_email' AND `date` BETWEEN '$date30' AND '$date1'";
$newthr = $conn->query($sql3);
while ($row_thr = $newthr->fetch_assoc()){
  $sqli_c = "SELECT * FROM `transaction` WHERE `name_id` = '$name_id' AND `entry_type` = 'Journal' AND `name` = 'vendor' AND `company_email` = '$company_email' AND  `date` BETWEEN '$date30' AND '$date1'";
  $news_c = $conn->query($sqli_c);
  if($news_c->num_rows != 0){
    $total_thr = $row['opening_balance']+$row_thr['totr']-$row_thr['return_tot'];
    $total_thr_total += $row['opening_balance']+$row_thr['totr']-$row_thr['return_tot'];
  }else{
    $total_thr = $row_thr['totr']-$row_thr['return_tot'];
    $total_thr_total += $row_thr['totr']-$row_thr['return_tot'];
  }
?>
                    <tr class="JKSCOO-k-b table-row link">
                      <td class="JKSCOO-k-a JKSCOO-k-c"><b><strong>1-30</strong></b></td>
                      <td class="JKSCOO-k-a JKSCOO-k-c" style="text-align: right;">
                        <?php if(isset($total_thr)){  echo number_format($total_thr, 2); }else{ echo number_format('0.00', 2); }  ?>
                      </td>
                    </tr>
<!-- *****************************OLD 60 DATE**************************** -->
<?php  }
$sql4 = "SELECT * ,SUM(due_amt) AS `totr`, ( SELECT sum( total ) FROM transaction WHERE `entry_type` ='create purchase return' AND ( `cheque_no` = '' OR `cheque_no` = 'undefined') AND `company_email` = '$company_email' AND `name_id` = '$name_id' AND `date` BETWEEN '$date60' AND '$date31') AS `return_tot` FROM `transaction` WHERE `entry_type` = 'create purchase invoice' AND `name_id` = '$name_id' AND `company_email` = '$company_email' AND `date` BETWEEN '$date60' AND '$date31'";
$newfr = $conn->query($sql4);
while ($row_fr = $newfr->fetch_assoc()){
$sqli_c = "SELECT * FROM `transaction` WHERE `name_id` = '$name_id' AND `entry_type` = 'Journal' AND `name` = 'vendor' AND `company_email` = '$company_email' AND  `date` BETWEEN '$date60' AND '$date31'";
  $news_c = $conn->query($sqli_c);
  if($news_c->num_rows != 0){
    $total_fr = $row['opening_balance']+$row_fr['totr']-$row_fr['return_tot'];
    $total_fr_total += $row['opening_balance']+$row_fr['totr']-$row_fr['return_tot'];
  }else{
    $total_fr = $row_fr['totr']-$row_fr['return_tot'];
    $total_fr_total += $row_fr['totr']-$row_fr['return_tot'];
  }
?>
                    <tr class="JKSCOO-k-b table-row link">
                      <td class="JKSCOO-k-a JKSCOO-k-c"><b><strong>31-60</strong></b></td>
                      <td class="JKSCOO-k-a JKSCOO-k-c" style="text-align: right;">
                        <?php if(isset($total_fr)){  echo number_format($total_fr, 2); }else{ echo number_format('0.00', 2); }  ?>
                      </td>
                    </tr>
<!-- *****************************OLD 90 DATE**************************** -->
<?php  }
$sql5 = "SELECT * ,SUM(due_amt) AS `totr`, ( SELECT sum( total ) FROM transaction WHERE `entry_type` ='create purchase return' AND ( `cheque_no` = '' OR `cheque_no` = 'undefined') AND `company_email` = '$company_email' AND `name_id` = '$name_id' AND `date` BETWEEN '$date90' AND '$date61') AS `return_tot` FROM `transaction` WHERE `entry_type` = 'create purchase invoice' AND `name_id` = '$name_id' AND `company_email` = '$company_email' AND `date` BETWEEN '$date90' AND '$date61'";
$newfve = $conn->query($sql5);
while ($row_fve = $newfve->fetch_assoc()){
  $sqli_c = "SELECT * FROM `transaction` WHERE `name_id` = '$name_id' AND `entry_type` = 'Journal' AND `name` = 'vendor' AND `company_email` = '$company_email' AND `date` BETWEEN '$date90' AND '$date61'";
  $news_c = $conn->query($sqli_c);
  if($news_c->num_rows != 0){
    $total_fve = $row['opening_balance']+$row_fve['totr']-$row_fve['return_tot'];
    $total_fve_total += $row['opening_balance']+$row_fve['totr']-$row_fve['return_tot'];
  }else{
    $total_fve = $row_fve['totr']-$row_fve['return_tot'];
    $total_fve_total += $row_fve['totr']-$row_fve['return_tot'];
  }
?>
                    <tr class="JKSCOO-k-b table-row link">
                      <td class="JKSCOO-k-a JKSCOO-k-c"><b><strong>61-90</strong></b></td>
                      <td class="JKSCOO-k-a JKSCOO-k-c" style="text-align: right;">
                        <?php if(isset($total_fve)){  echo number_format($total_fve, 2); }else{ echo number_format('0.00', 2); }  ?>
                      </td>
                    </tr>
<!-- *****************************OLD ALL DATE**************************** -->
<?php  }
$sql6 = "SELECT * ,SUM(due_amt) AS `totr`, ( SELECT sum( total ) FROM transaction WHERE `entry_type` ='create purchase return' AND ( `cheque_no` = '' OR `cheque_no` = 'undefined') AND `company_email` = '$company_email' AND `name_id` = '$name_id' AND `date` < '$date90') AS `return_tot` FROM `transaction` WHERE `entry_type` = 'create purchase invoice' AND `name_id` = '$name_id' AND `company_email` = '$company_email' AND `date` < '$date90'";
$newsix = $conn->query($sql6);
while ($row_six = $newsix->fetch_assoc()){
  $sqli_c = "SELECT * FROM `transaction` WHERE `name_id` = '$name_id' AND `entry_type` = 'Journal' AND `name` = 'vendor' AND `company_email` = '$company_email' AND  `date` < '$date90'";
  $news_c = $conn->query($sqli_c);
  if($news_c->num_rows != 0){
    $total_six = $row['opening_balance']+$row_six['totr']-$row_six['return_tot'];
    $total_six_total += $row['opening_balance']+$row_six['totr']-$row_six['return_tot'];
  }else{
    $total_six = $row_six['totr']-$row_six['return_tot'];
    $total_six_total += $row_six['totr']-$row_six['return_tot'];
  }
?>
                    <tr class="JKSCOO-k-b table-row link">
                      <td class="JKSCOO-k-a JKSCOO-k-c"><b><strong>>90</strong></b></td>
                      <td class="JKSCOO-k-a JKSCOO-k-c" style="text-align: left;">
                        <?php if(isset($total_six)){  echo number_format($total_six, 2); }else{ echo number_format('0.00', 2); }  ?>
                      </td>
                    </tr>
<?php  }
?>                      
                    <tr class="JKSCOO-k-b table-row link">
                      <td class="JKSCOO-k-a JKSCOO-k-c"><b><strong>Total</strong></b></td>
                      <td class="JKSCOO-k-a JKSCOO-k-c" style="text-align: right;">
                        <p><?php echo number_format($row_total = $total_two+$total_thr+$total_fr+$total_fve+$total_six, 2); ?></p>
                      </td>
                    </tr>
<?php
$col_total += $total_two+$total_thr+$total_fr+$total_fve+$total_six; 
?>


<!-- *****************************OLD 90 DATE**************************** -->
</tr>
<?php 
$total_two++;
$total_thr++;
$total_fr++;
$total_fve++;
$total_six++;

$row_total++;

$total_two_total++;
$total_thr_total++;
$total_fr_total++;
$total_fve_total++;
$total_six_total++;

$col_total++;

?>
                  </tbody>

                  

                </table>
</center>