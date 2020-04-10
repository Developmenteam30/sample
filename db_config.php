<?php
session_start();
//error_reporting(1);
//$conn = new mysqli("localhost", "moreacc","Satnam12345","moreacc" );

//$conn =  new mysqli(null, "moreacc", "Satnam12345", "moreacc", null, "/cloudsql/more-acc-186204:us-central1:more-acc");
$conn =  new mysqli("localhost", "break2ru_raghu", "Rnath123@", "break2ru_account");
	 if ($conn->connect_error){
	 echo "connection failed: " . $conn->connect_error;  
	 }
setlocale(LC_MONETARY,"en_US");	 
	 ?>
