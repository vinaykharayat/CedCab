<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

class RideBean implements \JsonSerializable {

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

    function __construct($dropLocation, $pickupLocation, $luggage, $distance, $cabType) {
        $this->dropLocation = $dropLocation;
        $this->pickupLocation = $pickupLocation;
        $this->luggage = $luggage;
        $this->distance = $distance;
        $this->cabType = $cabType;
    }

    private function calculateFinalFare($fare) {
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
                $this->totalFare = $this->calculateFinalFare($this->microFare)+ $this->luggage;
                return  $this->totalFare;
            case "mini":
                $this->totalFare = $this->calculateFinalFare($this->miniFare)+ $this->luggage;
                return  $this->totalFare;
            case "royal":
                $this->totalFare = $this->calculateFinalFare($this->royalFare)+ $this->luggage;
                return  $this->totalFare;
            case "suv":
                $this->totalFare = $this->calculateFinalFare($this->suvFare)+ ($this->luggage * 2);
                return $this->totalFare;
            default :
                break;
        }
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

}
