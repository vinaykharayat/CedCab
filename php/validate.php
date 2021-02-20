<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */


require_once __DIR__ . '/bean/tbl_user.php';
$name = filter_input(INPUT_GET, "name");
$emailInput = filter_input(INPUT_GET, "email");
$phoneInput = filter_input(INPUT_GET, "mobile");
//die(print_r(isset($_GET["mobile"])));
const SUCCESS_CODE = 200;
$newUser = new tbl_user();
if (isset($_GET["email"]) && trim($emailInput)!="") {
    $result = $newUser->checkAvalability("email_id", $emailInput);
    if ($result == 200) {
        echo 'nExist';
        $newUser->setEmail_id($emailInput);
        $newUser->setIs_admin(0);
        $newUser->setMobile($phoneInput);
        $newUser->setPassword($password);
    } else {
        echo 'exist';
    }
}

if(isset($_GET["mobile"]) && trim($phoneInput)!=""){
    $result = $newUser->checkAvalability("mobile", $phoneInput);
    if ($result == 200) {
        echo 'nExist';
        $newUser->setEmail_id($emailInput);
        $newUser->setIs_admin(0);
        $newUser->setMobile($phoneInput);
        $newUser->setPassword($password);
    } else {
        echo 'exist';
    }
}

