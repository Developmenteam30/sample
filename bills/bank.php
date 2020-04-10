<?php
include("../db.php");
include("mpeb/mpdf.php");

$mpdf=new mPDF('c','A4','','',10,10,110,25,10,10); 

$mpdf->mirrorMargins = 1;	// Use different Odd/Even headers and footers and mirror margins
$id = $_REQUEST['id'];
$header = file_get_contents('http://www.more-acc.com//account//upload//bills//bank_header.php?id='.$id.'&userid='.$company_email);
$headerE = file_get_contents('http://www.more-acc.com//account//upload//bills//bank_header.php?id='.$id.'&userid='.$company_email);

$footer = file_get_contents('http://www.more-acc.com//account//upload//bills//bank_footer.php?userid='.$company_email);
$footerE = file_get_contents('http://www.more-acc.com//account//upload//bills//bank_footer.php?userid='.$company_email);


$mpdf->SetHTMLHeader($header);
$mpdf->SetHTMLHeader($headerE,'E');
$mpdf->SetHTMLFooter($footer);
$mpdf->SetHTMLFooter($footerE,'E');


$html = file_get_contents('http://www.more-acc.com//account//upload//bills//bank_content.php?id='.$id.'&userid='.$company_email);

$mpdf->WriteHTML($html);

$mpdf->Output();
exit;

?>