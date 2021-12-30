<?php

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (isset($_FILES['uploadfile']['name'])) {
        // $filename = $_FILES['uploadfile']['name'];
        
        // $fileinfo = @getimagesize($_FILES["uploadfile"]["tmp_name"]);
        // $width = $fileinfo[0];
        // $height = $fileinfo[1];
        // $allowed_image_extension = array(
        //     "png",
        //     "jpg",
        //     "jpeg"
        // );
        
        // $file_extension = pathinfo($_FILES["uploadfile"]["name"]);
        // if (!in_array($file_extension['extension'], $allowed_image_extension)) {
        //     echo json_encode(['ok' => 0, 'error' => 'file_type']);
        // } 
        // else if (($_FILES["uploadfile"]["size"] > 2000000)) {
        //     echo json_encode(['ok' => 0, 'error' => 'file_size']);
        // }    
        // else if ($width > "1980" || $height > "1080") {
        //     echo json_encode(['ok' => 0, 'error' => 'file_dimension']);
        // }
        // else {
        //     $source = $_FILES['uploadfile']['tmp_name'];
        //     $target = 'assets/temp/' . $filename;
        //     if(move_uploaded_file($source,$target)){
        //         echo json_encode(['ok' => 1, 'temp_path' => $target]);
        //     }
        //     else{
        //         echo json_encode(['ok' => 0]);
        //     }
        // }
        // Get Image Dimension
    $fileinfo = @getimagesize($_FILES["uploadfile"]["tmp_name"]);
    $width = $fileinfo[0];
    $height = $fileinfo[1];
    
    $allowed_image_extension = array(
        "png",
        "jpg",
        "jpeg"
    );
    
    // Get image file extension
    $file_extension = pathinfo($_FILES["uploadfile"]["name"], PATHINFO_EXTENSION);
    
    // Validate file input to check if is not empty
      // Validate file input to check if is with valid extension
    if (! in_array($file_extension, $allowed_image_extension)) {
        echo json_encode(['ok' => 0, 'error' => 'file_type']);
    }    // Validate image file size
    else if (($_FILES["uploadfile"]["size"] > 2000000)) {
        echo json_encode(['ok' => 0, 'error' => 'file_size']);
    }    // Validate image file dimension
    else if ($width > "2048" || $height > "1600") {
        echo json_encode(['ok' => 0, 'error' => 'file_dimension']);
    } else {
        $target = 'assets/temp/' . basename($_FILES["uploadfile"]["name"]);
        if (move_uploaded_file($_FILES["uploadfile"]["tmp_name"], $target)) {
            echo json_encode(['ok' => 1, 'temp_path' => $target]);
        } else {
            echo json_encode(['ok' => 0]);
        }
    }
    } else {
        echo json_encode(['ok' => 0]);
    }
}
