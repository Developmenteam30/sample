<?php
include("../db.php");

     $target_dir = "cat/";
     $name = $_POST['name'];
     $classname = $_POST['classname'];
     print_r($_FILES);
     $target_file = $target_dir . basename($_FILES["file"]["name"]);

     move_uploaded_file($_FILES["file"]["tmp_name"], $target_file);
 $fname = $target_file;
     //write code for saving to database 
$sql = "INSERT INTO `category`(`name`, `image`, `parent`, `class`) VALUES ('$name','$fname', '0', '$classname')";
if (mysqli_query($conn, $sql)) {
    $last_id = mysqli_insert_id($conn);
    echo "New record created successfully.";
} else {
    echo "Error: " . $sql . "<br>" . mysqli_error($conn);
}
  
?>