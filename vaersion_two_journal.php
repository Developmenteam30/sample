<?php
include("db.php");
$id = $_GET['id'];

$i = '0';
include("header.php");
?>
                      <table   __gwtcellbasedwidgetimpldispatchingfocus="true" __gwtcellbasedwidgetimpldispatchingblur="true" class="JKSCOO-k-y table-fixed-layout page-panel" cellspacing="0">
        
                   <thead>
                     <tr class="JKSCOO-k-b table-row link">
                      <td class="JKSCOO-k-a JKSCOO-k-c"><strong>Trans</strong></td>
                      <td class="JKSCOO-k-a JKSCOO-k-c"><strong>Type</strong></td>
                      <td class="JKSCOO-k-a JKSCOO-k-c"><strong>Date</strong></td>
                      <td class="JKSCOO-k-a JKSCOO-k-c"><strong>Num</strong></td>
                      
                      <td class="JKSCOO-k-a JKSCOO-k-c"><strong>Name</strong></td>
                      <td class="JKSCOO-k-a JKSCOO-k-c"><strong></strong></td>
                     
                      <td class="JKSCOO-k-a JKSCOO-k-c"><strong>Account</strong></td>
                      <td class="JKSCOO-k-a JKSCOO-k-c"><strong>Debit</strong></td>
                      <td class="JKSCOO-k-a JKSCOO-k-c"><strong>Credit</strong></td>
                    </tr>



                  </thead>
<?php
$sqli = "SELECT * FROM `coa_list` WHERE `id` = '$id' AND `company_email` = '$company_email'";
$news = $conn->query($sqli);
$rs = $news->fetch_assoc();
$account = $rs['accounts_name'];
if(isset($_GET['start']) && isset($_GET['end'])){
$date_from = date('Y-m-d', strtotime($_GET['start']));
$date_to = date('Y-m-d', strtotime($_GET['end']));
$account_type =  $_REQUEST['account_type'];
$amount = $_REQUEST['amount'];
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
?>

                  <?php
$trans_total_debit = '0';
$trans_total_credit = '0';
$total_debit = '0';
$total_credit = '0';
$trans_id = '0';
$s = " CALL  PROC_FINANCIAL_JOURNAL('$company_email', '$date_from', '$date_to', '$account_type', '$account', '$amount', '$account_type')";
$sql = $conn->query($s);
$odr_id = '0';

$new = array();
while($row = $sql->fetch_assoc()){
$total_debit += $row['debit'];
$total_credit += $row['credit'];
if($odr_id!=$row['id']){
   $old = '0';
}
  $odr = $row['id'];

  $old += $row['credit'];
      ?>

    <tr class="JKSCOO-k-b table-row link">
        <td class="JKSCOO-k-a JKSCOO-k-c"><p><?php echo $row['id']; ?></p></td>
        <td class="JKSCOO-k-a JKSCOO-k-c"><p><?php echo ucwords(str_ireplace("create","",$row['entry_type'])); ?></p></td>
        <td class="JKSCOO-k-a JKSCOO-k-c" style="text-align:center;"><p><?php echo date("d-m-Y", strtotime($row['date'])); ?></p></td>
        <td class="JKSCOO-k-a JKSCOO-k-c"><p><?php echo $row['transaction_number']; ?></p></td>
        <td class="JKSCOO-k-a JKSCOO-k-c"><p style=" width:160px; white-space: nowrap; overflow:hidden !important; text-overflow: ellipsis;"><?php echo $row['name']; ?></p></td>
        <td class="JKSCOO-k-a JKSCOO-k-c"></td>
        <td class="JKSCOO-k-a JKSCOO-k-c"><p style=" width:180px; white-space: nowrap; overflow:hidden !important; text-overflow: ellipsis;"><?php echo $row['accounts_name']; ?></p></td>
        <td class="JKSCOO-k-a JKSCOO-k-c" style="text-align: right;"><p><?php  if($row['debit']=="0"){ echo ""; }  else { echo number_format($row['debit'], 2); } ?></p></td>
        <td class="JKSCOO-k-a JKSCOO-k-c" style="text-align: right;"><p><?php  if($row['credit']=="0"){ echo ""; }  else { echo number_format($row['credit'], 2); } ?></p></td>


    
    </tr>

    <?php
$trans_total_debit += $row['debit'];
$trans_total_credit += $row['credit'];
$trans_id = $row['transaction_id'];
}
?>

<?php 
$old++;
?>  







                  </tbody>
                    


                </table>
