<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

require_once $_SERVER['DOCUMENT_ROOT'].'/cedcab/php/bean/tbl_location.php';


header('Content-Type: application/json');
$locationsObj = new tbl_location();
$locationsArr = $locationsObj->getAllLocations();
if($locationsObj->getAllLocations() == 200){
    print_r(json_encode($locationsObj->getLocations()));
}else{
    print_r("Something went wrong!");
}

