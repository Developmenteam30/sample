<?php
include('db.php');





/*********************************************************************************************/
/********************************************************************************************
										DELETE ANY TABLE
/*********************************************************************************************/
/*********************************************************************************************/

$tale_name = $_POST['table_name'];
$id = $_POST['data'];
if ($tale_name == 'purchase_order') {
	$result="DELETE FROM `transaction` WHERE  `id` = '$id' AND company_email = '$company_email'";
	$new = $conn->query($result) or die (mysqli_error());	
	$result="DELETE FROM `purchase_item` WHERE  `purchase_id` = '$id' AND company_email = '$company_email'";
	$new = $conn->query($result) or die (mysqli_error());	
}elseif{$tale_name == 'purchase_bill'}{
	$result="SELECT * FROM `purchase_item` WHERE  `purchase_id` = '$id' AND company_email = '$company_email'";
	$new = $conn->query($result);
	while($item_row = $new->fetch_assoc()){
		if($item_row['item_category']=='Inventory'){
			$item_id = $item_row['item_id'];
			$qty = $item_row['item_quantity'];
			$delete_stock = $item_row['price_rate'] * $qty;
			$result="UPDATE items SET stock = stock-'$qty', asset_value = asset_value-'$delete_stock', weighted_price = asset_value/stock WHERE company_email = '$company_email' AND id = '$item_id'" ;
			$conn->query($result);
			$result="UPDATE items SET weighted_price = pr_price WHERE company_email = '$company_email' AND id = '$item_id' AND weighted_price = '0'" ;
			$conn->query($result);
		}
	}
	$result="DELETE FROM `transaction` WHERE  `id` = '$id' AND company_email = '$company_email'";
	$new = $conn->query($result) or die (mysqli_error());	
	$result="DELETE FROM `purchase_item` WHERE  `purchase_id` = '$id' AND company_email = '$company_email'";
	$new = $conn->query($result) or die (mysqli_error());	
	$sqli="DELETE FROM `journal` WHERE `transaction_id` = '$id' AND company_email = '$company_email'" ;
	$conn->query($sqli) or die(mysqli_error());
}elseif{$tale_name == 'purchase_invoice'}{
$sqlt="SELECT * FROM `transaction` WHERE `id` = '$id' AND `company_email` = '$company_email'";
$newt = $conn->query($sqlt);
$rowt = $newt->fetch_assoc();
	if($rowt['lock'] == '0'){
		$result="SELECT * FROM `purchase_item` WHERE  `purchase_id` = '$id' AND company_email = '$company_email'";
		$new = $conn->query($result);
		while($item_row = $new->fetch_assoc()){
			if($item_row['item_category']=='Inventory'){
				$item_id = $item_row['item_id'];
				$qty = $item_row['item_quantity'];
				$delete_stock = $item_row['price_rate'] * $qty;
				$result="UPDATE items SET stock = stock-'$qty', asset_value = asset_value-'$delete_stock', weighted_price = asset_value/stock WHERE company_email = '$company_email' AND id = '$item_id'" ;
				$conn->query($result);
				$result="UPDATE items SET weighted_price = pr_price WHERE company_email = '$company_email' AND id = '$item_id' AND weighted_price = '0'" ;
				$conn->query($result);
			}
		}
		$result="DELETE FROM `transaction` WHERE  `id` = '$id' AND company_email = '$company_email'";
		$new = $conn->query($result) or die (mysqli_error());	
		$result="DELETE FROM `purchase_item` WHERE  `purchase_id` = '$id' AND company_email = '$company_email'";
		$new = $conn->query($result) or die (mysqli_error());	
		$sqli="DELETE FROM `journal` WHERE `transaction_id` = '$id' AND company_email = '$company_email'" ;
		$conn->query($sqli) or die(mysqli_error());
	}else{
		echo "This transaction cant be deleted.";
	}
}elseif{$tale_name == 'vendor_payment'}{
$sqlt="SELECT * FROM `transaction` WHERE `id` = '$id' AND `company_email` = '$company_email'";
$newt = $conn->query($sqlt);
$rowt = $newt->fetch_assoc();
	if($rowt['lock'] == '0'){
		$result="DELETE FROM `transaction` WHERE  `id` = '$id' AND company_email = '$company_email'";
		$new = $conn->query($result) or die (mysqli_error());	
		$sqli="DELETE FROM `journal` WHERE `transaction_id` = '$id' AND company_email = '$company_email'" ;
		$conn->query($sqli) or die(mysqli_error());
		$result="UPDATE `vendor` SET `credit` = `credit`-'".$rowt['credit']."' WHERE `company_email` = '$company_email' AND `id` = '".$rowt['name_id']."'" ;
		$conn->query($result);
		$sqla="SELECT * FROM `vendor_payment_list` WHERE `vendor_payment_list_id` = '$id' AND `company_email` = '$company_email'";
		$newa = $conn->query($sqla);
		while($rowa = $newa->fetch_assoc()){
			$result="UPDATE `transaction` SET `due_amt` = `due_amt`+'".$rowt['credit']."' WHERE `company_email` = '$company_email' AND `transaction_number` = '".$rowa['invoice_no']."' AND `entry_type` = 'create purchase invoice'" ;
			$conn->query($result);
		}
		$result="DELETE FROM `vendor_payment_list` WHERE  `vendor_payment_list_id` = '$id' AND company_email = '$company_email'";
		$new = $conn->query($result) or die (mysqli_error());	
	}else{
		echo "This transaction cant be deleted.";
	}
}elseif{$tale_name == 'purchase_return'}{
$sqlt="SELECT * FROM `transaction` WHERE `id` = '$id' AND `company_email` = '$company_email'";
$newt = $conn->query($sqlt);
$rowt = $newt->fetch_assoc();
	if($rowt['lock'] == '0'){
		$result="SELECT * FROM `purchase_item` WHERE  `purchase_id` = '$id' AND company_email = '$company_email'";
		$new = $conn->query($result);
		while($item_row = $new->fetch_assoc()){
			if($item_row['item_category']=='Inventory'){
				$item_id = $item_row['item_id'];
				$qty = $item_row['item_quantity'];
				$delete_stock = $item_row['weight_avg'] * $qty;
				$result="UPDATE items SET stock = stock+'$qty', asset_value = asset_value+'$delete_stock', weighted_price = asset_value/stock WHERE company_email = '$company_email' AND id = '$item_id'" ;
				$conn->query($result);
				$result="UPDATE items SET weighted_price = pr_price WHERE company_email = '$company_email' AND id = '$item_id' AND weighted_price = '0'" ;
				$conn->query($result);
			}
		}
		$result="DELETE FROM `transaction` WHERE  `id` = '$id' AND company_email = '$company_email'";
		$new = $conn->query($result) or die (mysqli_error());	
		$result="DELETE FROM `purchase_item` WHERE  `purchase_id` = '$id' AND company_email = '$company_email'";
		$new = $conn->query($result) or die (mysqli_error());	
		$sqli="DELETE FROM `journal` WHERE `transaction_id` = '$id' AND company_email = '$company_email'" ;
		$conn->query($sqli) or die(mysqli_error());
		$result="UPDATE `vendor` SET `credit` = `credit`-'".$rowt['credit']."' WHERE `company_email` = '$company_email' AND `id` = '".$rowt['name_id']."'" ;
		$conn->query($result);
	}else{
		echo "This transaction cant be deleted.";
	}
}elseif{$tale_name == 'sales_order'}{
	$result="DELETE FROM `transaction` WHERE  `id` = '$id' AND company_email = '$company_email'";
	$new = $conn->query($result) or die (mysqli_error());	
	$result="DELETE FROM `sales_item` WHERE  `sales_id` = '$id' AND company_email = '$company_email'";
	$new = $conn->query($result) or die (mysqli_error());	
}elseif{$tale_name == 'sales_bill'}{
		$result="SELECT * FROM `sales_item` WHERE  `sales_id` = '$id' AND company_email = '$company_email'";
		$new = $conn->query($result);
		while($item_row = $new->fetch_assoc()){
			if($item_row['item_category']=='Inventory'){
				$item_id = $item_row['item_id'];
				$qty = $item_row['item_quantity'];
				$delete_stock = $item_row['weight_avg'] * $qty;
				$result="UPDATE items SET stock = stock+'$qty', asset_value = asset_value+'$delete_stock', weighted_price = asset_value/stock WHERE company_email = '$company_email' AND id = '$item_id'" ;
				$conn->query($result);
				$result="UPDATE items SET weighted_price = pr_price WHERE company_email = '$company_email' AND id = '$item_id' AND weighted_price = '0'" ;
				$conn->query($result);
			}
		}
	$result="DELETE FROM `transaction` WHERE  `id` = '$id' AND company_email = '$company_email'";
	$new = $conn->query($result) or die (mysqli_error());	
	$result="DELETE FROM `sales_item` WHERE  `sales_id` = '$id' AND company_email = '$company_email'";
	$new = $conn->query($result) or die (mysqli_error());	
	$sqli="DELETE FROM `journal` WHERE `transaction_id` = '$id' AND company_email = '$company_email'" ;
	$conn->query($sqli) or die(mysqli_error());
}elseif{$tale_name == 'sales_invoice'}{
$sqlt="SELECT * FROM `transaction` WHERE `id` = '$id' AND `company_email` = '$company_email'";
$newt = $conn->query($sqlt);
$rowt = $newt->fetch_assoc();
	if($rowt['lock'] == '0'){
		$result="SELECT * FROM `sales_item` WHERE  `sales_id` = '$id' AND company_email = '$company_email'";
		$new = $conn->query($result);
		while($item_row = $new->fetch_assoc()){
			if($item_row['item_category']=='Inventory'){
				$item_id = $item_row['item_id'];
				$qty = $item_row['item_quantity'];
				$delete_stock = $item_row['weight_avg'] * $qty;
				$result="UPDATE items SET stock = stock+'$qty', asset_value = asset_value+'$delete_stock', weighted_price = asset_value/stock WHERE company_email = '$company_email' AND id = '$item_id'" ;
				$conn->query($result);
				$result="UPDATE items SET weighted_price = pr_price WHERE company_email = '$company_email' AND id = '$item_id' AND weighted_price = '0'" ;
				$conn->query($result);
			}
		}
		$result="DELETE FROM `transaction` WHERE  `id` = '$id' AND company_email = '$company_email'";
		$new = $conn->query($result) or die (mysqli_error());	
		$result="DELETE FROM `sales_item` WHERE  `sales_id` = '$id' AND company_email = '$company_email'";
		$new = $conn->query($result) or die (mysqli_error());	
		$sqli="DELETE FROM `journal` WHERE `transaction_id` = '$id' AND company_email = '$company_email'" ;
		$conn->query($sqli) or die(mysqli_error());
	}else{
		echo "This transaction cant be deleted.";
	}
}elseif{$tale_name == 'customer_payment'}{
$sqlt="SELECT * FROM `transaction` WHERE `id` = '$id' AND `company_email` = '$company_email'";
$newt = $conn->query($sqlt);
$rowt = $newt->fetch_assoc();
	if($rowt['lock'] == '0'){
		$result="DELETE FROM `transaction` WHERE  `id` = '$id' AND company_email = '$company_email'";
		$new = $conn->query($result) or die (mysqli_error());	
		$sqli="DELETE FROM `journal` WHERE `transaction_id` = '$id' AND company_email = '$company_email'" ;
		$conn->query($sqli) or die(mysqli_error());
		$result="UPDATE `customer` SET `credit` = `credit`-'".$rowt['credit']."' WHERE `company_email` = '$company_email' AND `id` = '".$rowt['name_id']."'" ;
		$conn->query($result);
		$sqla="SELECT * FROM `customer_payment_list` WHERE `customer_payment_list_id` = '$id' AND `company_email` = '$company_email'";
		$newa = $conn->query($sqla);
		while($rowa = $newa->fetch_assoc()){
			$result="UPDATE `transaction` SET `due_amt` = `due_amt`+'".$rowt['credit']."' WHERE `company_email` = '$company_email' AND `transaction_number` = '".$rowa['invoice_no']."' AND `entry_type` = 'create sales invoice'" ;
			$conn->query($result);
		}
		$result="DELETE FROM `vendor_payment_list` WHERE  `customer_payment_list_id` = '$id' AND company_email = '$company_email'";
		$new = $conn->query($result) or die (mysqli_error());	
	}else{
		echo "This transaction cant be deleted.";
	}
}elseif{$tale_name == 'sales_return'}{
$sqlt="SELECT * FROM `transaction` WHERE `id` = '$id' AND `company_email` = '$company_email'";
$newt = $conn->query($sqlt);
$rowt = $newt->fetch_assoc();
	if($rowt['lock'] == '0'){
		$result="SELECT * FROM `sales_item` WHERE  `sales_id` = '$id' AND company_email = '$company_email'";
		$new = $conn->query($result);
		while($item_row = $new->fetch_assoc()){
			if($item_row['item_category']=='Inventory'){
				$item_id = $item_row['item_id'];
				$qty = $item_row['item_quantity'];
				$delete_stock = $item_row['weight_avg'] * $qty;
				$result="UPDATE items SET stock = stock+'$qty', asset_value = asset_value-'$delete_stock', weighted_price = asset_value/stock WHERE company_email = '$company_email' AND id = '$item_id'" ;
				$conn->query($result);
				$result="UPDATE items SET weighted_price = pr_price WHERE company_email = '$company_email' AND id = '$item_id' AND weighted_price = '0'" ;
				$conn->query($result);
			}
		}
		$result="DELETE FROM `transaction` WHERE  `id` = '$id' AND company_email = '$company_email'";
		$new = $conn->query($result) or die (mysqli_error());	
		$result="DELETE FROM `sales_item` WHERE  `sales_id` = '$id' AND company_email = '$company_email'";
		$new = $conn->query($result) or die (mysqli_error());	
		$sqli="DELETE FROM `journal` WHERE `transaction_id` = '$id' AND company_email = '$company_email'" ;
		$conn->query($sqli) or die(mysqli_error());
		$result="UPDATE `customer` SET `credit` = `credit`-'".$rowt['credit']."' WHERE `company_email` = '$company_email' AND `id` = '".$rowt['name_id']."'" ;
		$conn->query($result);
	}else{
		echo "This transaction cant be deleted.";
	}
}elseif{$tale_name == 'bank_payment'}{
		$result="DELETE FROM `transaction` WHERE  `id` = '$id' AND company_email = '$company_email'";
		$new = $conn->query($result) or die (mysqli_error());	
		///////////////////*****************/////////////// DELETE JOURNAL///////////////////*****************///////////////
		$sqli="DELETE FROM `journal` WHERE `transaction_id` = '$id'" ;
		$conn->query($sqli) or die(mysqli_error());
		///////////////////*****************/////////////// DELETE JOURNAL///////////////////*****************///////////////
		$sqli="DELETE FROM `bank_payment` WHERE `transaction_id` = '$id'" ;
		$conn->query($sqli) or die(mysqli_error());
}elseif{$tale_name == 'bank_reciept'}{
		$result="DELETE FROM `transaction` WHERE  `id` = '$id' AND company_email = '$company_email'";
		$new = $conn->query($result) or die (mysqli_error());	
		///////////////////*****************/////////////// DELETE JOURNAL///////////////////*****************///////////////
		$sqli="DELETE FROM `journal` WHERE `transaction_id` = '$id'" ;
		$conn->query($sqli) or die(mysqli_error());
		///////////////////*****************/////////////// DELETE JOURNAL///////////////////*****************///////////////
		$sqli="DELETE FROM `bank_payment` WHERE `transaction_id` = '$id'" ;
		$conn->query($sqli) or die(mysqli_error());
}elseif{$tale_name == 'inventory_receipt'}{
		$result="DELETE FROM `transaction` WHERE  `id` = '$id' AND company_email = '$company_email'";
		$new = $conn->query($result) or die (mysqli_error());	
		$sqli="DELETE FROM `inventory_goods` WHERE `goods_id`= '$id' AND `company_email` = '$company_email'";
		$conn->query($sqli) ;
}elseif{$tale_name == 'inventory_issue'}{
		$result="DELETE FROM `transaction` WHERE  `id` = '$id' AND company_email = '$company_email'";
		$new = $conn->query($result) or die (mysqli_error());	
		$sqli="DELETE FROM `inventory_goods` WHERE `goods_id`= '$id' AND `company_email` = '$company_email'";
		$conn->query($sqli) ;
}
/*********************************************************************************************/

?>