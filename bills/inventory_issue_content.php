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
    <col style="width: 40%">
    <col style="width: 20%">
    <col style="width: 16%">
    <col style="width: 15%">
    <col style="width: 19%">
	</colgroup>
		<thead style="border-top:1px solid #000; border-bottom:1px solid #000">
			<tr>
		        <th style=" border-bottom: 1px solid #000;text-align: left;border-right: 1px solid #a59d9d;">ITEM NAME &amp; DESCRIPTION</th>
		        <th style=" border-bottom: 1px solid #000;text-align: center;border-right: 1px solid #a59d9d;">PRICE &nbsp;</th>
		        <th style=" border-bottom: 1px solid #000;text-align: center;border-right: 1px solid #a59d9d;">Qty. &nbsp;</th>
		        <th style=" border-bottom: 1px solid #000;text-align: center;border-right: 1px solid #a59d9d;">VAT(%)</th>
		        <th style=" border-bottom: 1px solid #000;text-align: center;">TOTAL &nbsp;&nbsp;</th>
		    </tr>
		</thead>    	
<?php
$i=0;
$sll = "SELECT * FROM `inventory_goods` WHERE `goods_id` = '$id' AND `company_email` = '$company_email' ORDER BY `id` ASC";
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
        <td style=" border:none;text-align: center;border-right: 1px solid #a59d9d;"><?php echo  number_format($rww['price_rate'], 2, '.', ','); ?></td>
        <td style=" border:none;text-align: center;border-right: 1px solid #a59d9d;"><?php echo number_format($rww['item_quantity'], 2, '.', ','); ?></td>
        <td style=" border:none;text-align: center;border-right: 1px solid #a59d9d;"><?php echo $rww['vat']; ?>%</td>
        <td style=" border:none;text-align: center;"><?php echo number_format($rww['amount'], 2, '.', ','); ?> &nbsp;</td>
		    </tr>
<?php $i++; } 
$i = $i % 14;
 if($i < '14'){ 
        for($i = $i; $i<7; $i++){ ?>
      <tr class="active" style="height: 30px; color: white; border:none;">
          <td style="border-right: 1px solid #a59d9d;"><span style="opacity: 0;color:white;">yo <br> yo</span></td>
        <td style="border-right: 1px solid #a59d9d;"></td>
        <td style="border-right: 1px solid #a59d9d;"></td>
        <td style="border-right: 1px solid #a59d9d;"></td>
        <td></td>
      </tr>
<?php   } } ?>
			<div style="border-top:solid 1px #000; border-bottom:none;">
				<tr>
			        <td colspan="3" style="border-top:solid 1px #000;text-align: center;"></td>
			        <td class="" style="border-top:solid 1px #000;text-align: left;">SUBTOTAL:</td>
			        <td class="" style="border-top:solid 1px #000;text-align: right;"><?php echo number_format($row['subtotal'], 2, '.', ','); ?></td>
			    </tr> 
     		</div>         	
			    <tr style=" border:none;">
                                <td colspan="3" style="text-align: center;"></td>
			        <td class="" style="border-top:solid 1px #000;text-align: left;">VAT:</td>
			        <td class="" style="border-top:solid 1px #000;text-align: right;"><?php echo number_format($row['vat'], 2, '.', ','); ?></td>
			    </tr>
<?php if($row['disc_amount'] == '0'){ ?>
			    <tr style="border-top:solid 1px #ccc; border:none;">
			        <td colspan="3" class="bot_col" style=""></td>
			        <td class="bot_col" style="border-top:solid 1px #ccc;border-bottom: 1px solid #ccc;text-align: left;">DISCOUNT:</td>
			        <td class="bot_col" style="border-top:solid 1px #ccc;border-bottom: 1px solid #ccc;text-align: right;"><?php echo number_format($row['disc_amount'], 2, '.', ','); ?></td>
	      		</tr>
<?php } ?>     		
			    <tr style=" border-bottom:1px solid #000; border:none;">
			        <td colspan="3" class="bot_col" style="border-bottom: 1px solid #000"></td>
			        <td class="bot_col" style="border-bottom: 1px solid #000;text-align: left;font-weight: bold">TOTAL:</td>
			        <td class="bot_col" style="border-bottom: 1px solid #000;text-align: right;"><?php echo $ac_curr.number_format($row['total'], 2, '.', ','); ?></td>
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
<strong style="text-transform: uppercase;"><?php 
$as = number_format($row['total'], 2, '.', '');
    $asdf = explode('.', $as);
        echo $ac_curr.' '.$f->format($asdf[0]);
        echo " & FILS ";
        echo $f->format($asdf[1]);
?> ONLY</strong></p>
</div>

