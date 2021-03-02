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

if (isset($_POST["action"]) && $_POST["action"] == "getUserRideInfo" && isset($_POST["isAdmin"]) && $_POST["isAdmin"] != "") {
    $ride = new tbl_ride();
    $userRideInfo = array(
        'pendingRides' => $ride->getTotalPendingRidesAdmin(),
        'cancelledRides' => $ride->getTotalCancelledRidesAdmin(),
        'totalSpent' => $ride->getTotalSpentAdmin(),
        'totalRides' => $ride->getTotalRidesAdmin()
    );
    header('Content-Type: application/json');
    print_r(json_encode($userRideInfo));
    die();
}

if (isset($_POST["action"]) && $_POST["action"] == "getUserRideInfo" && $_POST["isAdmin"] == "") {
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
    die();
}

if (isset($_POST["viewRide"])) {
    $ride = new tbl_ride();
    header('Content-Type: application/json');
    print_r(json_encode($ride->getRide($_POST["viewRide"])));
}

if (isset($_POST["cancelRide"])) {
    $ride = new tbl_ride();
    $rideid = $_POST["cancelRide"];

    echo $ride->cancelRide($rideid);
    die();
}

function getAllRides() {
    $ride = new tbl_ride();
    if ($_POST["isAdmin"] == "") {

        if ($ride->getAllRides($_SESSION["user"]["user_id"]) == 200) {
            header('Content-Type: application/json');
            print_r(json_encode($ride->getAllRidesArr()));
        } else {
            
        }
    } else if ($_POST["isAdmin"] == "admin") {
        if ($ride->getAllRidesAdmin() == 200) {
            header('Content-Type: application/json');
            print_r(json_encode($ride->getAllRidesArr()));
        } else {
            
        }
    }
}

function getPendingRides() {
    $ride = new tbl_ride();
    if ($_POST["isAdmin"] == "") {
        if ($ride->getAllPendingRides($_SESSION["user"]["user_id"]) == 200) {
            header('Content-Type: application/json');
            print_r(json_encode($ride->getAllRidesArr()));
        } else {
            
        }
    } else if ($_POST["isAdmin"] == "admin") {
        if ($ride->getAllPendingRidesAdmin() == 200) {
            header('Content-Type: application/json');
            print_r(json_encode($ride->getAllRidesArr()));
        } else {
            
        }
    }
}

function getCancelledRides() {
    $ride = new tbl_ride();
    if ($_POST["isAdmin"] == "") {
        if ($ride->getAllCancelledRides($_SESSION["user"]["user_id"]) == 200) {
            header('Content-Type: application/json');
            print_r(json_encode($ride->getAllRidesArr()));
        } else {
            
        }
    } else if ($_POST["isAdmin"] == "admin") {
        if ($ride->getAllCancelledRidesAdmin() == 200) {
            header('Content-Type: application/json');
            print_r(json_encode($ride->getAllRidesArr()));
        } else {
            
        }
    }
}

function getTotalSpent() {
    $ride = new tbl_ride();
    if ($_POST["isAdmin"] == "") {
        if ($ride->getAllTotalSpent($_SESSION["user"]["user_id"]) == 200) {
            header('Content-Type: application/json');
            print_r(json_encode($ride->getAllRidesArr()));
        } else {
            
        }
    } else if ($_POST["isAdmin"] == "admin") {
        if ($ride->getAllTotalSpentAdmin() == 200) {
            header('Content-Type: application/json');
            print_r(json_encode($ride->getAllRidesArr()));
        } else {
            
        }
    }
}

if (isset($_POST["selections"])) {
    switch ($_POST["action"]) {
        case "month":
            if ($_POST["week"] != "") {
                getTwoFilteredData($_POST["selections"]["month"], $_POST["selections"]["week"]);
            } else if ($_POST["sortBy"] != "") {
                getTwoFilteredData($_POST["selections"]["month"], $_POST["selections"]["sortBy"]);
            } else if ($_POST["cabType"] != "") {
                getTwoFilteredData($_POST["selections"]["month"], $_POST["selections"]["cabType"]);
            } else {
                getSingleFilteredData($_POST["selections"]["month"], "month", $_POST["status"]);
            }
            break;
        case "week":
            if ($_POST["month"] != "") {
                getTwoFilteredData($_POST["selections"]["week"], $_POST["selections"]["month"]);
            } else if ($_POST["sortBy"] != "") {
                getTwoFilteredData($_POST["selections"]["week"], $_POST["selections"]["sortBy"]);
            } else if ($_POST["cabType"] != "") {
                getTwoFilteredData($_POST["selections"]["week"], $_POST["selections"]["cabType"]);
            } else {
                getSingleFilteredData($_POST["selections"]["week"], "week", $_POST["status"]);
            }
            break;
        case "sortBy":
            if ($_POST["month"] != "") {
                getTwoFilteredData($_POST["selections"]["sortBy"], $_POST["selections"]["month"]);
            } else if ($_POST["week"] != "") {
                getTwoFilteredData($_POST["selections"]["sortBy"], $_POST["selections"]["week"]);
            } else if ($_POST["cabType"] != "") {
                getTwoFilteredData($_POST["selections"]["sortBy"], $_POST["selections"]["cabType"]);
            } else {
                getSingleFilteredData($_POST["selections"]["sortBy"], "sortBy", $_POST["status"]);
            }
            break;
        case "cabType":
            if ($_POST["month"] != "") {
                getTwoFilteredData($_POST["selections"]["sortBy"], $_POST["selections"]["month"]);
            } else if ($_POST["week"] != "") {
                getTwoFilteredData($_POST["selections"]["sortBy"], $_POST["selections"]["week"]);
            } else if ($_POST["sortBy"] != "") {
                getTwoFilteredData($_POST["selections"]["sortBy"], $_POST["selections"]["sortBy"]);
            } else {
                getSingleFilteredData($_POST["selections"]["cabType"], "cabType", $_POST["status"]);
            }
            break;
        default:
            break;
    }
}

function getSingleFilteredData($sortBy, $sortType, $rideStatus) {
    $ride = new tbl_ride();
    if($rideStatus = "pendingBtn"){
            $res = $ride->getSingleFilteredData($sortBy, $sortType, 1);

    }else if($rideStatus == "cancelledBtn"){
        $res = $ride->getSingleFilteredData($sortBy, $sortType, 0);
    }else if($rideStatus == "completedBtn"){
        $res = $ride->getSingleFilteredData($sortBy, $sortType, 2);
    }else if($rideStatus == "totalBtn"){
        $res = $ride->getSingleFilteredData($sortBy, $sortType, -1);
    }
    if ($res == 200) {
        header('Content-Type: application/json');
        print_r(json_encode($ride->getAllRidesArr()));
    }else{
        return 500;
    }
}

function getTwoFilteredData() {
    //   $_POST["status"]//filtering button
}
