<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
include_once $_SERVER['DOCUMENT_ROOT'] . '/cedcab/php/bean/tbl_location.php';

if (isset($_POST["getLocation"])) {
    $locationsObj = new tbl_location();
    if ($locationsObj->getAllLocationsAdmin() == 200) {
        header('Content-Type: application/json');
        print_r(json_encode($locationsObj->getLocations()));
    } else {
        die("500");
    }
}

if (isset($_POST["blockLocation"])) {
    $locationsObj = new tbl_location();
    $res = $locationsObj->blockUnblockLocation($_POST["locationId"], $_POST["blockLocation"]);
    if ($res == 200) {
        die("200");
    } else {
        die("500");
    }
}

if (isset($_POST["deleteLocation"])) {
    $locationsObj = new tbl_location();
    $res = $locationsObj->deleteLocation($_POST["locationId"]);
    if ($res == 200) {
        die("200");
    } else {
        die("500");
    }
}

if (isset($_POST["locationName"])) {
    $locationsObj = new tbl_location();
    $res = $locationsObj->addNewLocation(filter_input(INPUT_POST, "locationName"), filter_input(INPUT_POST, "locationDistance"), filter_input(INPUT_POST, "locationStatus"));
    if($res==200){
        die("200");
    }else{
        print_r($res);
        die();
    }
//    die("C");
}
