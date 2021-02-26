<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

require_once $_SERVER['DOCUMENT_ROOT'].'/cedcab/php/bean/tbl_user.php';

if (!isset($_SESSION["phoneVerified"])) {
    echo '-2'; //If phone is not verified
} else if (!isset($_SESSION["emailVerified"])) {

    echo '-1'; //If email is not verified
} else if (isset($_SESSION["emailVerified"]) && isset($_SESSION["phoneVerified"])) {

    echo registerUser();
}

function registerUser() {
    $newUser = new tbl_user();
    $newUser->setEmail_id(filter_input(INPUT_POST, 'email'));
    $newUser->setMobile(filter_input(INPUT_POST, 'phone'));

    $newUser->setPassword(filter_input(INPUT_POST, 'password'));

    $newUser->setName(filter_input(INPUT_POST, 'name'));

    $newUser->setProfilePicUrl(uploadFile());

    return $newUser->signUp();
}

function uploadFile() {
    $target_dir = "uploads/";
    $target_file = $target_dir . filter_input(INPUT_POST, "phone") . ".";
    $uploadOk = 1;
    $imageFileType = strtolower(pathinfo($_FILES["file"]["name"], PATHINFO_EXTENSION));
    $target_file .= $imageFileType;

    // Check if image file is a actual image or fake image
    if (filter_has_var(INPUT_POST, "email")) {
        $check = getimagesize($_FILES["file"]["tmp_name"]);
        if ($check !== false) {
//            echo "File is an image - " . $check["mime"] . ".";
            $uploadOk = 1;
        } else {
//            echo "File is not an image.";
            $uploadOk = 0;
        }
    }

// Check file size
    if ($_FILES["file"]["size"] > 500000) {
//        echo "Sorry, your file is too large.";
        $uploadOk = 0;
    }

// Allow certain file formats
    if ($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg" && $imageFileType != "gif") {
//        echo "Sorry, only JPG, JPEG, PNG & GIF files are allowed.";
        $uploadOk = 0;
    }

// Check if $uploadOk is set to 0 by an error
    if ($uploadOk == 0) {
//        echo "Sorry, your file was not uploaded.";
// if everything is ok, try to upload file
    } else {
        // Check if file already exists
        if (file_exists($target_file)) {
            unlink($target_file);
        }
        
        if (move_uploaded_file($_FILES["file"]["tmp_name"], $target_file)) {
//            echo "The file " . htmlspecialchars(basename($_FILES["file"]["name"])) . " has been uploaded.";
        } else {
//            echo "Sorry, there was an error uploading your file.";
        }
    }
    return "./" . $target_file;
}
