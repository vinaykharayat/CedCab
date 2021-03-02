<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
include_once $_SERVER['DOCUMENT_ROOT'] . '/cedcab/php/bean/tbl_user.php';

if (isset($_POST["getUsers"])) {
    $users = new tbl_user();
    if ($users->getAllUsers() == 200) {
        header('Content-Type: application/json');
        print_r(json_encode($users->getAllUsersArr()));
    } else {
        
    }
}

if (isset($_POST["blockUser"])) {
    $user = new tbl_user();
    $res = $user->blockUnblockUser($_POST["userId"], $_POST["blockUser"]);
    if ($res == 200) {
        die("200");
    } else {
        die("500");
    }
}

if (isset($_POST["profileChange"])) {
    $user = new tbl_user();
    $res = $user->updateUserProfile($_SESSION["user"]["user_id"], filter_input(INPUT_POST, "userName"), filter_input(INPUT_POST, "userMobile"));
    if ($res == 200) {
        $_SESSION["user"]["name"] = filter_input(INPUT_POST, "userName");
        $_SESSION["user"]["mobile"] = filter_input(INPUT_POST, "userMobile");
        die("200");
    } else {
        die("500");
    }
}

if (isset($_POST["oldPassword"])) {
    $user = new tbl_user();
    $res = $user->changePassword($_SESSION["user"]["user_id"], filter_input(INPUT_POST, "oldPassword"), filter_input(INPUT_POST, "newPassword"));
    if ($res == 500) {
        die("500");
    } else if ($res == 403) {
        die("403");
    } else if ($res == 200) {
        die("200");
    }
}

if (isset($_FILES["imgupload"])) {
    $user = new tbl_user();
    $profilePicPath = uploadFile();
    $res = $user->changeProfilePic($_SESSION["user"]["user_id"], $profilePicPath);
    if($res == 200){
        $_SESSION["user"]["profilePic"] = $profilePicPath;
        die("200");
    }else{
        die("500");
    }
}

function uploadFile() {
    $target_dir = "uploads/";
    $target_file = $target_dir . $_SESSION['user']["mobile"] . ".";
    $uploadOk = 1;
    $imageFileType = strtolower(pathinfo($_FILES["imgupload"]["name"], PATHINFO_EXTENSION));
    $target_file .= $imageFileType;

    // Check if image file is a actual image or fake image
    $check = getimagesize($_FILES["imgupload"]["tmp_name"]);
    if ($check !== false) {
//            echo "File is an image - " . $check["mime"] . ".";
        $uploadOk = 1;
    } else {
//            echo "File is not an image.";
        $uploadOk = 0;
    }


// Check file size
    if ($_FILES["imgupload"]["size"] > 500000) {
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

        if (move_uploaded_file($_FILES["imgupload"]["tmp_name"], $target_file)) {
//            echo "The file " . htmlspecialchars(basename($_FILES["file"]["name"])) . " has been uploaded.";
        } else {
//            echo "Sorry, there was an error uploading your file.";
        }
    }
    return "./" . $target_file;
}
