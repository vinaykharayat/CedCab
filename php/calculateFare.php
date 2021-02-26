<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
session_start();
require_once $_SERVER['DOCUMENT_ROOT'].'/cedcab/php/bean/RideBean.php';
require_once $_SERVER['DOCUMENT_ROOT'].'/cedcab/php/bean/tbl_location.php';

$luggageFare = array(50, 100, 200);

/*******************************************************************************
 * Based on user selection, this assigns luggage value to below luggage variable
 *******************************************************************************/
$luggage = 0;

if (isset($_POST['luggage'])) {
    switch ($_POST['luggage']) {
        case 0:
            break;
        case 10:
            $GLOBALS['luggage'] = $luggageFare[0];
            break;
        case 20:
            $GLOBALS['luggage'] = $luggageFare[1];
            break;
        case 21:
            $GLOBALS['luggage'] = $luggageFare[2];
            break;
        default:
            break;
    }
}
$locationObj = new tbl_location();
$dropLocation = $locationObj->getLocationNameDistance(filter_input(INPUT_POST, "dropLocation"));
$pickupLocation = $locationObj->getLocationNameDistance(filter_input(INPUT_POST, "pickupLocation"));
$distance = calculateDistance($dropLocation['distance'], $pickupLocation['distance']);

$newRide = new RideBean();

$newRide->setDropLocation(filter_input(INPUT_POST, "dropLocation"));
$newRide->setPickupLocation(filter_input(INPUT_POST, "pickupLocation"));
$newRide->setLuggage($luggage);
$newRide->setDistance($distance);
$newRide->setCabType(filter_input(INPUT_POST, "cabType"));
$totalFare = $newRide->calculateFare();

header('Content-Type: application/json');
$_SESSION["rideInfoWithId"] = $newRide->jsonSerialize(); //This sets location id to session

$newRide->setDropLocation($newRide->getLocationNameDistance(filter_input(INPUT_POST, "dropLocation"))["name"]);
$newRide->setPickupLocation($newRide->getLocationNameDistance(filter_input(INPUT_POST, "pickupLocation"))["name"]);

print_r(json_encode($newRide->jsonSerialize()));

function calculateDistance($dropLocation, $pickupLocation) {
    return abs($pickupLocation - $dropLocation);
}
