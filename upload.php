<?php
include("../db.php");

     $target_dir = "emoji/";
     $name = $_POST['name'];
     $cat = $_POST['cat'];
     print_r($_FILES);
     $target_file = $target_dir .$name. basename($_FILES["file"]["name"]);

     move_uploaded_file($_FILES["file"]["tmp_name"], $target_file);
 $fname = $target_file;
     //write code for saving to database 
$sql = "INSERT INTO `emojis`(`name`, `image`, `parent`) VALUES ('$name','$fname', '$cat')";
if (mysqli_query($conn, $sql)) {
    $last_id = mysqli_insert_id($conn);
    //echo "New record created successfully.";
} else {
    echo "Error: " . $sql . "<br>" . mysqli_error($conn);
}
  
?>