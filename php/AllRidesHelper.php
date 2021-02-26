<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
session_start();
include_once $_SERVER['DOCUMENT_ROOT'] . '/cedcab/php/bean/tbl_ride.php';

if (isset($_POST["status"])) {
    switch ($_POST["status"]) {
        case 'pending':
            getPendingRides();
            break;
        case 'cancelled':
            getCancelledRides();
            break;
        case 'totalSpent':
            getTotalSpent();
            break;
        case 'allRides':
            getAllRides();
            break;
        default:
            break;
    }
}

if (isset($_POST["action"]) && $_POST["action"] == "getUserRideInfo") {
    $ride = new tbl_ride();
    $userid = $_SESSION["user"]["user_id"];
    $userRideInfo = array(
        'pendingRides' => $ride->getTotalPendingRides($userid),
        'cancelledRides' => $ride->getTotalCancelledRides($userid),
        'totalSpent' => $ride->getTotalSpent($userid),
        'totalRides' => $ride->getTotalRides($userid)
    );
    header('Content-Type: application/json');
    print_r(json_encode($userRideInfo));
}

if(isset($_POST["cancelRide"])) {
    $ride = new tbl_ride();
    $rideid = $_POST["cancelRide"];
    
    echo $ride->cancelRide($rideid);
    die();
}

function getAllRides() {
    $ride = new tbl_ride();

    if ($ride->getAllRides($_SESSION["user"]["user_id"]) == 200) {
        header('Content-Type: application/json');
        print_r(json_encode($ride->getAllRidesArr()));
    } else {
        
    }
}

function getPendingRides() {
    $ride = new tbl_ride();

    if ($ride->getAllPendingRides($_SESSION["user"]["user_id"]) == 200) {
        header('Content-Type: application/json');
        print_r(json_encode($ride->getAllRidesArr()));
    } else {
        
    }
}

function getCancelledRides() {
    $ride = new tbl_ride();
    if ($ride->getAllCancelledRides($_SESSION["user"]["user_id"]) == 200) {
        header('Content-Type: application/json');
        print_r(json_encode($ride->getAllRidesArr()));
    } else {
        
    }
}

function getTotalSpent() {
    $ride = new tbl_ride();
    if ($ride->getAllTotalSpent($_SESSION["user"]["user_id"]) == 200) {
        header('Content-Type: application/json');
        print_r(json_encode($ride->getAllRidesArr()));
    } else {
        
    }
}
