<?php
if(!empty($_FILES['file'])){

    $data = file_get_contents($_FILES['file']['tmp_name']);
    $dada = chunk_split(base64_encode($data));
    $fname = "sample.pdf"; // name the file
    $file = fopen($fname, 'w'); // open the file path
    fwrite($file, $data); //save data
    fclose($file);
    echo "finelly ho gaya";
} else {
    echo "No Data Sent";
}
?>