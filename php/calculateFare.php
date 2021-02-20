<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
require_once './bean/RideBean.php';

$locations = array(
    "Charbagh" => 0,
    "Indra Nagar" => 10,
    "BBD" => 30,
    "Barabanki" => 60,
    "Faizabad" => 100,
    "Basti" => 150,
    "Gorakhpur" => 210
);

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
$distance = calculateDistance(filter_input(INPUT_POST, "dropLocation"), filter_input(INPUT_POST, "pickupLocation"));

$newRide = new RideBean(
        filter_input(INPUT_POST, "dropLocation"),
        filter_input(INPUT_POST, "pickupLocation"),
        $luggage,
        $distance,
        filter_input(INPUT_POST, "cabType"));

$totalFare = $newRide->calculateFare();
header('Content-Type: application/json');
print_r(json_encode($newRide->jsonSerialize()));

function calculateDistance($dropLocation, $pickupLocation) {
    $locations = &$GLOBALS['locations'];
    return abs($locations[$pickupLocation] - $locations[$dropLocation]);
}
