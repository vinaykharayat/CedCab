<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

require_once $_SERVER['DOCUMENT_ROOT'].'/cedcab/php/bean/tbl_user.php';
$user = new tbl_user();
$user->setEmail_id(filter_input(INPUT_POST, "email"));
$user->setPassword(filter_input(INPUT_POST, "password"));
if(isset($_POST['password'])){
    $response = $user->LoginCheck($user->getEmail_id(), $user->getPassword());

    echo $response;
}

