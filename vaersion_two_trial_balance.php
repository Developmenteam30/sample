<?php
include("db.php");
$id = $_GET['id'];

$i = '0';



if(isset($_GET['start']) && isset($_GET['end'])){
$date_from = date('Y-m-d', strtotime($_GET['start']));
$date_to = date('Y-m-d', strtotime($_GET['end']));
}else{
$date_to = date('Y-m-d');
$date_from  = date('Y-m-d', strtotime($date_to. ' -180 days'));
}
?>
                      <table style="width: 80%">
                  <thead>
                    <tr>
        <td></td>
                      <td style="text-align:center;border-bottom:1px solid #000;width:150px" colspan="2"> <strong style="">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<?php if(isset($_GET['start']) && isset($_GET['end'])){ echo date('M d, Y', strtotime($date_to)); }else{ echo date('M d, Y', strtotime($date_to)); } ?>&nbsp;&nbsp;&nbsp;</strong></td>
                    </tr>
                    
                       <tr>
                      <th style="text-align: left;width: 70%;">Account Code/Name</th>
                      <th style="text-align: center;width: 15%">Debit</th>
                      <th style="text-align: center;width: 15%">Credit</th>
                    </tr>
                  </thead>
                  <tbody>
<?php 
$sql = "SELECT *, (SELECT SUM(journal.debit) FROM journal WHERE coa_list.id = journal.account AND journal.company_email = '$company_email' AND journal.date BETWEEN '$date_from' AND '$date_to') AS debit_tot, (SELECT SUM(journal.credit) FROM journal WHERE coa_list.id = '$id' AND coa_list.id = journal.account AND journal.company_email = '$company_email' AND journal.date BETWEEN '$date_from' AND '$date_to') AS credit_tot FROM coa_list WHERE coa_list.company_email = '$company_email' ORDER BY coa_list.code";
$new = $conn->query($sql);
while ($row = $new->fetch_assoc()) {

if($row['group'] == 'Bank' || $row['group'] == 'Accounts Receivable' || $row['group'] == 'Inventory' || $row['group'] == 'Current Assets' || $row['group'] == 'Fixed Assets' || $row['group'] == 'Other Receivables' || $row['group'] == 'Long Term Receivables' || $row['group'] == 'Expenses' OR $row['group'] == 'Cost of Goods Sold'){

 $debit_tot = $row['debit_tot'];
 $credit_tot = $row['credit_tot'];
$income = $debit_tot - $credit_tot;
if($income > 0){
$total_dabit += $income;  
}else{
$total_credit += abs($income);  
}
?>

                     <tr>
                        <td style="padding: 0px 0px 0px 30px"><span><?php echo $row['code'].' '.$row['accounts_name']; ?></span></td>
<?php if($income > 0){ ?>
                        <td style="text-align: right;"><?php echo number_format($income, 2); ?></td>
                        <td style="text-align: right;"><?php echo number_format(0, 2); ?></td>
<?php }else{ ?>
                        <td style="text-align: right;"><?php echo number_format(0, 2); ?></td>
                        <td style="text-align: right;"><?php echo number_format(abs($income), 2); ?></td>
<?php } ?>
                    </tr>
<?php
}
if($row['group'] == 'Accounts payable' OR $row['group'] == 'Current Liability' OR $row['group'] == 'Long Term Liability' OR $row['group'] == 'Bank/Loan Facility' OR $row['group'] == 'Credit Card' OR $row['group'] == 'Income' OR $row['group'] == 'Equity'){
 $debit_tot = $row['debit_tot'];
 $credit_tot = $row['credit_tot'];
$income = $credit_tot - $debit_tot;
if($income > 0){
$total_credit += abs($income);  
}else{
$total_dabit += abs($income);  
}
?>

                     <tr>
                        <td style="padding: 0px 0px 0px 30px"><span><?php echo $row['code'].' '.$row['accounts_name']; ?></span></td>
<?php if($income > 0){ ?>
                        <td style="text-align: right;"><?php echo number_format(0, 2); ?></td>
                        <td style="text-align: right;"><?php echo number_format(abs($income), 2); ?></td>
<?php }else{ ?>
                        <td style="text-align: right;"><?php echo number_format(abs($income), 2); ?></td>
                        <td style="text-align: right;"><?php echo number_format(0, 2); ?></td>
<?php } ?>
                    </tr>
<?php
}
}
?>
<br><br>
                   <tr>
                        <td><h3>Total</h3></td>
                        <td style="text-align: right;border-bottom: 4px double #000;border-top: 1px solid #000"><h4><?php echo number_format(abs($total_dabit), 2); ?></h4></td>
                        <td style="text-align: right;border-bottom: 4px double #000;border-top: 1px solid #000"><h4><?php echo number_format(abs($total_credit ), 2); ?></h4></td>
                     </tr>
                  </tbody>
                </table>