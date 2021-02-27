<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
include_once $_SERVER['DOCUMENT_ROOT'] . '/cedcab/php/bean/tbl_user.php';

if(isset($_POST["getUsers"])){
    $users = new tbl_user();
    if ($users->getAllUsers() == 200) {
            header('Content-Type: application/json');
            print_r(json_encode($users->getAllUsersArr()));
        } else {
            
        }
}

if(isset($_POST["blockUser"])){
    $user = new tbl_user();
    $res = $user->blockUnblockUser($_POST["userId"], $_POST["blockUser"]);
    if($res == 200){
        die("200");
    }
    else{
        die("500");
    }
}

