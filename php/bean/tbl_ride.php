<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

class tbl_ride{
    private $ride_id;
    private $ride_date;
    private $from;
    private $to;
    private $total_distance;
    private $luggage;
    private $total_fare;
    private $status;
    private $customer_user_id;
    
    function __construct($ride_id, $ride_date, $from, $to, $total_distance, $luggage, $total_fare, $status, $customer_user_id) {
        $this->ride_id = $ride_id;
        $this->ride_date = $ride_date;
        $this->from = $from;
        $this->to = $to;
        $this->total_distance = $total_distance;
        $this->luggage = $luggage;
        $this->total_fare = $total_fare;
        $this->status = $status;
        $this->customer_user_id = $customer_user_id;
    }
    
    function getRide_id() {
        return $this->ride_id;
    }

    function getRide_date() {
        return $this->ride_date;
    }

    function getFrom() {
        return $this->from;
    }

    function getTo() {
        return $this->to;
    }

    function getTotal_distance() {
        return $this->total_distance;
    }

    function getLuggage() {
        return $this->luggage;
    }

    function getTotal_fare() {
        return $this->total_fare;
    }

    function getStatus() {
        return $this->status;
    }

    function getCustomer_user_id() {
        return $this->customer_user_id;
    }

    function setRide_id($ride_id): void {
        $this->ride_id = $ride_id;
    }

    function setRide_date($ride_date): void {
        $this->ride_date = $ride_date;
    }

    function setFrom($from): void {
        $this->from = $from;
    }

    function setTo($to): void {
        $this->to = $to;
    }

    function setTotal_distance($total_distance): void {
        $this->total_distance = $total_distance;
    }

    function setLuggage($luggage): void {
        $this->luggage = $luggage;
    }

    function setTotal_fare($total_fare): void {
        $this->total_fare = $total_fare;
    }

    function setStatus($status): void {
        $this->status = $status;
    }

    function setCustomer_user_id($customer_user_id): void {
        $this->customer_user_id = $customer_user_id;
    }



}

