<?php include('../db.php'); 
$id = $_REQUEST['id'];
$sql = "SELECT * FROM `transaction` WHERE `id` = '$id' AND `company_email` = '$company_email'";
$new = $conn->query($sql);
$row = $new->fetch_assoc();

?>
<div style="width: 1000px; height: 60px; padding: 5px;border: 1px solid #000;">
<div  style="width: 100%;float: left; height: 500px;">
	<table style="width: 100%; ">
	<colgroup>
    <col style="width: 16.66%">
    <col style="width: 16.66%">
    <col style="width: 16.66%">
    <col style="width: 16.66%">
    <col style="width: 16.66%">
    <col style="width: 16.66%">
	</colgroup>
		<thead style="border-top:1px solid #000; border-bottom:1px solid #000">
			<tr>
		        <th style=" border-bottom: 1px solid #000;text-align: left;border-right: 1px solid #a59d9d;">DATE</th>
		        <th style=" border-bottom: 1px solid #000;text-align: center;border-right: 1px solid #a59d9d;">INVOICE. &nbsp;</th>
		        <th style=" border-bottom: 1px solid #000;text-align: center;border-right: 1px solid #a59d9d;">TOTAL &nbsp;</th>
		        <th style=" border-bottom: 1px solid #000;text-align: center;border-right: 1px solid #a59d9d;">DUE Amount &nbsp;</th>
		        <th style=" border-bottom: 1px solid #000;text-align: center;border-right: 1px solid #a59d9d;">DISCOUNT</th>
		        <th style=" border-bottom: 1px solid #000;text-align: center;">RECEIVED &nbsp;&nbsp;</th>
		    </tr>
		</thead>    	
<?php
$i=0;
$subtotal = 0;
$sl = "SELECT * FROM `vendor_payment_list` WHERE `vendor_payment_list_id` = '$id' ORDER BY `id` ASC";
$nes = $conn->query($sl);
while($ross = $nes->fetch_assoc()){
	$subtotal += $ross['received'];
?>

			<tr>
		        <td style="border-right: 1px solid #a59d9d;">
		          <div>
			            <span style="font-weight:normal;"><br>    
			            <?php echo $ross['dates']; ?>&nbsp;   
			            &nbsp;   
			            </span>
		          </div>
		        </td>
        <td style=" border:none;text-align: center;border-right: 1px solid #a59d9d;"><?php echo $ross['invoice_no']; ?></td>
        <td style=" border:none;text-align: center;border-right: 1px solid #a59d9d;"><?php echo  number_format($ross['total'], 2, '.', ','); ?></td>
        <td style=" border:none;text-align: center;border-right: 1px solid #a59d9d;"><?php echo number_format($ross['due_amount'], 2, '.', ','); ?> &nbsp;</td>
        <td style=" border:none;text-align: center;border-right: 1px solid #a59d9d;"><?php if($ross['discount_amount'] == ''){echo number_format('0', 2, '.', ','); }else{ echo number_format($ross['discount_amount'], 2, '.', ','); } ?> &nbsp;</td>
        <td style=" border:none;text-align: center;"><?php echo number_format($ross['received'], 2, '.', ','); ?> &nbsp;</td>
		    </tr>
<?php $i++; } 
$i = $i % 14;
 if($i < '14'){ 
        for($i = $i; $i<6; $i++){ ?>
      <tr class="active" style="height: 30px; color: white; border:none;">
        <td style="border-right: 1px solid #a59d9d;"><span style="opacity: 0;color:white;">yo <br> yo</span></td>
        <td style="border-right: 1px solid #a59d9d;"></td>
        <td style="border-right: 1px solid #a59d9d;"></td>
        <td style="border-right: 1px solid #a59d9d;"></td>
        <td style="border-right: 1px solid #a59d9d;"></td>
        <td></td>
      </tr>
<?php   } } ?>			
              <div style="border-top:solid 1px #000; border-bottom:1px solid #000;padding-top:200px">
<tr>
			        <td colspan="4" style="border-top:solid 1px #000;text-align: center;"></td>
			        <td class="" style="border: none;border-top:solid 1px black;text-align: right;">SUBTOTAL:</td>
			        <td class="" style="border: none;border-top:solid 1px black;text-align: right;"><?php echo number_format($subtotal, 2, '.', ','); ?></td>
			    </tr>
			</div>         	
				<tr>
			        <td colspan="4" style="text-align: center;"></td>
			        <td class="" style="border: none;border-top:solid 1px black;text-align: right;">DISCOUNT:</td>
			        <td class="" style="border: none;border-top:solid 1px black;text-align: right;"><?php echo number_format($row['disc_amount'], 2, '.', ','); ?></td>
			    </tr> 

		    <tr style="border-top:solid 1px #ccc; border-bottom:1px solid black; border:none;">
        <td colspan="4" class="bot_col" style="border-bottom: 1px solid #000"></td>
        <td class="bot_col" style="border-top:solid 1px #ccc;border-bottom: 1px solid #000;text-align: right;">TOTAL:</td>
        <td class="bot_col" style="border-top:solid 1px #ccc;border-bottom: 1px solid #000;text-align: right;"><?php echo $ac_curr.number_format($row['total'], 2, '.', ','); ?></td>
      </tr>
			</div>         	


    </table>

<?php 
use \NumberFormatter as NumberFormatter;
$f = new NumberFormatter("en", NumberFormatter::SPELLOUT);
?>
<p>(In Words) : <br><br>
Taxable Amount: 
<strong style="text-transform: uppercase;">
<?php 
$as = number_format($row['subtotal'], 2, '.', '');
	$asdf = explode('.', $as);
		echo $ac_curr.' '.$f->format($asdf[0]);
		echo " & FILS ";
		echo $f->format($asdf[1]);
?> ONLY</strong>
</p>
<p>Discount Amount : 
<strong style="text-transform: uppercase;">
<?php 
$as = number_format($row['disc_amount'], 2, '.', '');
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