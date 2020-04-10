<?php include('../db.php'); 
$id = $_REQUEST['id'];
$sql = "SELECT * FROM `transaction` WHERE `id` = '$id' AND `company_email` = '$company_email'";
$new = $conn->query($sql);
$row = $new->fetch_assoc();

?>
<div style="width: 100%; height: 60px; padding: 5px;border: 1px solid #000;">
<div  style="width: 100%;float: left; height: 500px;">
	<table style="width: 100%; ">
	<colgroup>
    <col style="width: 35%">
    <col style="width: 15%">
    <col style="width: 20%">
    <col style="width: 30%">
	</colgroup>
		<thead style="border-top:1px solid #000; border-bottom:1px solid #000">
			<tr>
		        <th style=" border-bottom: 1px solid #000;text-align: left;border-right: 1px solid #a59d9d;">Account</th>
		        <th style=" border-bottom: 1px solid #000;text-align: center;border-right: 1px solid #a59d9d;">VAT(%) &nbsp;</th>
		        <th style=" border-bottom: 1px solid #000;text-align: center;border-right: 1px solid #a59d9d;">Amount</th>
		        <th style=" border-bottom: 1px solid #000;text-align: center;">Notes &nbsp;&nbsp;</th>
		    </tr>
		</thead>    	
<?php
$i=0;
$sql = "SELECT * FROM `bank_payment` WHERE `transaction_id` = '$id' AND `company_email` = '$company_email' ORDER BY `id` ASC";
$news = $conn->query($sql);
while($rows = $news->fetch_assoc()){
$bank_account_id = $rows['bank_account'];

$sqli = "SELECT * FROM `coa_list` WHERE `id` = '$bank_account_id'";
$nws = $conn->query($sqli);
$ros = $nws->fetch_assoc();
?>

			<tr>
		        <td style="border-right: 1px solid #a59d9d;">
		          <div>
            <span style="font-weight: bold;">&nbsp;
            <?php echo $ros['group']; ?>,</span>
            <span style="font-weight:normal;"><br>    
            (<?php echo $ros['code']; ?>)<?php echo substr($ros['accounts_name'], 0, 50); ?>&nbsp;   
            </span>
		          </div>
		        </td>
        <td style=" border:none;text-align: center;border-right: 1px solid #a59d9d;"><?php echo $rows['vat']; ?>%</td>
        <td style=" border:none;text-align: center;border-right: 1px solid #a59d9d;"><?php echo number_format($rows['amount'], 2, '.', ','); ?></td>
        <td style=" border:none;text-align: center;"><?php echo  substr($rows['memo'], 0, 50); ?></td>
		    </tr>
<?php $i++; } 
$i = $i % 14;
 if($i < '14'){ 
        for($i = $i; $i<8; $i++){ ?>
      <tr class="active" style="height: 30px; color: white; border:none;">
        <td style="border-right: 1px solid #a59d9d;"><span style="opacity: 0;color:white;">yo <br> yo</span></td>
        <td style="border-right: 1px solid #a59d9d;"></td>
        <td style="border-right: 1px solid #a59d9d;"></td>
        <td></td>
        <td></td>
      </tr>
<?php   } } ?>
			<div style="border-top:solid 1px #000; border-bottom:1px solid #000;">
				<tr>
			        <td colspan="2" style="border-top:solid 1px #000;text-align: center;"></td>
			        <td class="" style="border: none;border-top:solid 1px black;text-align: right;">VAT:</td>
			        <td class="" style="border: none;border-top:solid 1px black;text-align: right;"><?php echo number_format($row['vat'], 2, '.', ','); ?></td>
			    </tr> 
			</div>         	

		    <tr style="border-top:solid 1px #ccc; border-bottom:1px solid black; border:none;">
        <td colspan="2" class="bot_col" style="border-bottom: 1px solid #000"></td>
        <td class="bot_col" style="border-top:solid 1px #ccc;border-bottom: 1px solid #000;text-align: right;">TOTAL:</td>
        <td class="bot_col" style="border-top:solid 1px #ccc;border-bottom: 1px solid #000;text-align: right;"><?php echo $ac_curr.number_format($row['total'], 2, '.', ','); ?></td>
      </tr>

    </table>
<?php 
use \NumberFormatter as NumberFormatter;
$f = new NumberFormatter("en", NumberFormatter::SPELLOUT);
?>
<p>(In Words) : <br><br>
<p>VAT Amount : 
<strong style="text-transform: uppercase;">
<?php 
$as = number_format($row['vat'], 2, '.', '');
    $asdf = explode('.', $as);
        echo $ac_curr.' '.$f->format($asdf[0]);
        echo " & FILS ";
        echo $f->format($asdf[1]);
?> ONLY</strong></p>
<p>Total Amount : 
<strong style="text-transform: uppercase;">
<?php 
$as = number_format($row['total'], 2, '.', '');
    $asdf = explode('.', $as);
        echo $ac_curr.' '.$f->format($asdf[0]);
        echo " & FILS ";
        echo $f->format($asdf[1]);
?> ONLY</strong></p>
</div>
