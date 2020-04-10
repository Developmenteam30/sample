<?php include('../db.php'); 
$id = $_REQUEST['id'];
$sql = "SELECT * FROM `transaction` WHERE `id` = '$id' AND `company_email` = '$company_email'";
$new = $conn->query($sql);
$row = $new->fetch_assoc();
?>
<div style="width: 1000px; height: 60px; padding: 5px;border: 1px solid #000;">
<div  style="width: 100%;float: left; height: 500px;">
	<table style="width: 100%; ">
		<thead style="border-top:1px solid #000; border-bottom:1px solid #000">
			<tr>
		        <th style=" border-bottom: 1px solid #000;border-right: 1px solid #000;text-align: left; height : 20px; width:35%">ITEM NAME &amp; DESCRIPTION</th>
		        <th style=" border-bottom: 1px solid #000; border-right: 1px solid #000;text-align: center;" >Qty. &nbsp;</th>
		        <th style=" border-bottom: 1px solid #000; border-right: 1px solid #000;text-align: center;">PRICE &nbsp;</th>
<th style=" border-bottom: 1px solid #000; border-right: 1px solid #000;text-align: center;">TAXABLE &nbsp;<br> AMOUNT &nbsp;&nbsp;</th>
		        <th style=" border-bottom: 1px solid #000; border-right: 1px solid #000;text-align: center;">VAT(%)</th>
		        <th style=" border-bottom: 1px solid #000;text-align: center;">VAT &nbsp;&nbsp;<br>AMOUNT&nbsp;</th>
		    </tr>
		</thead>    	
<?php
$i=0;
$sll = "SELECT * FROM `sales_item` WHERE `sales_id` = '$id' AND `company_email` = '$company_email' ORDER BY `id` ASC";
$nww = $conn->query($sll);
while($rww = $nww->fetch_assoc()){
?>

		<tr>
		        <td style="border-right: 1px solid #a59d9d;">
		          <div>
            <span style="font-weight: bold;">&nbsp;
            <?php echo $rww['item_name']; ?>,</span>
            <span style="font-weight:normal;"><br>    
            <?php echo substr($rww['item_description'], 0, 50); ?>&nbsp;   
            </span>
		          </div>
		        </td>
		        <div style="border-right: 1px solid #a59d9d;">
        <td style=" border:none;text-align: center;border-right: 1px solid #a59d9d;"><?php echo number_format($rww['item_quantity'], 2, '.', ','); ?></td>
        <td style=" border:none;text-align: center;border-right: 1px solid #a59d9d;"><?php echo  number_format($rww['price_rate'], 2, '.', ','); ?></td>
        <td style=" border:none;text-align: center;border-right: 1px solid #a59d9d;"><?php echo number_format($rww['amount'], 2, '.', ','); ?> &nbsp;</td>
        <td style=" border:none;text-align: center;border-right: 1px solid #a59d9d;"><?php echo $rww['vat']; ?>%</td>
           <td style=" border:none;text-align: center;"><?php echo number_format($rww['vat_amount'], 2, '.', ','); ?></td>
		    </tr>
<?php $i++; } 
$i = $i % 10;
 if($i < '14'){ 
        for($i = $i; $i<5; $i++){ ?>
      <tr class="active" style="height: 30px; color: white; border:none;">
        <td style="border-right: 1px solid #a59d9d;"><span style="opacity: 0;color:white;">yo <br> yo</span></td>
        <td style="border-right: 1px solid #a59d9d;"></td>
        <td style="border-right: 1px solid #a59d9d;"></td>
        <td style="border-right: 1px solid #a59d9d;"></td>
        <td style="border-right: 1px solid #a59d9d;"></td>
        <td></td>
      </tr>
      </div>
<?php   } } ?>
			<div style="border-top:solid 1px #000; border-bottom:1px solid #000;padding-top:200px">
<tr>
			        <td colspan="3" style="border-top:solid 1px #000;text-align: center;"></td>
			        <td colspan="2" style="border: none;border-top:solid 1px black;text-align: left;">TAXABLE AMOUNT:</td>
			        <td class="" style="border: none;border-top:solid 1px black;text-align: right;"><?php echo number_format($row['subtotal'], 2, '.', ','); ?></td>
			    </tr>
</div>
				<tr>
			        <td colspan="3" style="border-top:solid 1px #000;text-align: center;"></td>
			        <td colspan="2" style="border: none;border-top:solid 1px black;text-align: left;">VAT AMOUNT:</td>
			        <td class="" style="border: none;border-top:solid 1px black;text-align: right;"><?php echo number_format($row['vat'], 2, '.', ','); ?></td>
			    </tr> 

		    <tr style="border-top:solid 1px #ccc; border-bottom:1px solid black; border:none;">
        <td colspan="3" class="bot_col" style="border-bottom: 1px solid #000"></td>
        <td colspan="2" class="bot_col" style="border-top:solid 1px #ccc;border-bottom: 1px solid #000;text-align: left;">TOTAL AMOUNT:</td>
        <td class="bot_col" style="border-top:solid 1px #ccc;border-bottom: 1px solid #000;text-align: right;"><?php echo $ac_curr.number_format($row['total'], 2, '.', ','); ?></td>
      </tr>

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
<p>VAT Amount : 
<strong style="text-transform: uppercase;">
<?php 
$as = number_format($row['vat'], 2, '.', '');
	$asdf = explode('.', $as);
		echo $ac_curr.' '.$f->format($asdf[0]);
		echo " & FILS ";
		echo $f->format($asdf[1]);
?>
 ONLY</strong></p>
<p>Total Amount : 
<strong style="text-transform: uppercase;">
<?php 
$as = number_format($row['total'], 2, '.', '');
	$asdf = explode('.', $as);
		echo $ac_curr.' '.$f->format($asdf[0]);
		echo " & FILS ";
		echo $f->format($asdf[1]);
?>
 ONLY</strong></p>
</div>
