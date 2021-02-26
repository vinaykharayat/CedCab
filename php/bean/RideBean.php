<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

require_once $_SERVER['DOCUMENT_ROOT'].'/cedcab/php/dao/Dbcon.php';

class RideBean extends Dbcon implements \JsonSerializable {

    const sourcetbl = "tbl_location";

    private $totalFare = 0;
    private $dropLocation;
    private $pickupLocation;
    private $luggage;
    private $distance;
    private $cabType;

    const MICRO_FARE = 50;
    const MINI_FARE = 150;
    const ROYAL_FARE = 200;
    const SUV_FARE = 250;

    private $microFare = array(self::MICRO_FARE, 13.5, 12, 10.2, 8.5);
    private $miniFare = array(self::MINI_FARE, 14.5, 13, 11.2, 9.5);
    private $royalFare = array(self::ROYAL_FARE, 15.5, 14, 12.2, 10.5);
    private $suvFare = array(self::SUV_FARE, 16.5, 15, 13.2, 11.5);

    
    function __construct() {
        $this->getConn();
    }


    function getConn() {
        $this->createConnection();
    }

    private function calculateFinalFare($fare /* This is an array with pricings of different type of cabs */) {
        for ($i = 0; $i < $this->distance; $i++) {
            if ($i < 10) {
                $this->totalFare += $fare[1];
            } else if ($i >= 10 && $i < 60) {
                $this->totalFare += $fare[2];
            } else if ($i >= 60 && $i < 160) {
                $this->totalFare += $fare[3];
            } else if ($i >= 160) {
                $this->totalFare += $fare[4];
            }
        }

        return $this->totalFare += $fare[0];
    }

    function calculateFare() {
        switch ($this->cabType) {
            case "micro":
                $this->totalFare = $this->calculateFinalFare($this->microFare) + $this->luggage;
                return $this->totalFare;
            case "mini":
                $this->totalFare = $this->calculateFinalFare($this->miniFare) + $this->luggage;
                return $this->totalFare;
            case "royal":
                $this->totalFare = $this->calculateFinalFare($this->royalFare) + $this->luggage;
                return $this->totalFare;
            case "suv":
                $this->totalFare = $this->calculateFinalFare($this->suvFare) + ($this->luggage * 2);
                return $this->totalFare;
            default :
                break;
        }
    }

    function getLocationNameDistance($id) {
        $query = "select `name` , `distance` from `" . self::sourcetbl . "` where id='$id'";
        $result = $this->conn->query($query);
        return $result->fetch_assoc();
    }

    function jsonSerialize() {
        return get_object_vars($this);
    }

    function getTotalFare() {
        return $this->totalFare;
    }

    function setTotalFare($totalFare): void {
        $this->totalFare = $totalFare;
    }

    function getDropLocation() {
        return $this->dropLocation;
    }

    function getPickupLocation() {
        return $this->pickupLocation;
    }

    function getLuggage() {
        return $this->luggage;
    }

    function getDistance() {
        return $this->distance;
    }

    function setDropLocation($dropLocation): void {
        $this->dropLocation = $dropLocation;
    }

    function setPickupLocation($pickupLocation): void {
        $this->pickupLocation = $pickupLocation;
    }

    function setLuggage($luggage): void {
        $this->luggage = $luggage;
    }

    function setDistance($distance): void {
        $this->distance = $distance;
    }
    
    function getCabType() {
        return $this->cabType;
    }

    function setCabType($cabType): void {
        $this->cabType = $cabType;
    }



}
