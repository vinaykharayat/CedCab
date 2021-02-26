<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

require_once $_SERVER['DOCUMENT_ROOT'] . '/cedcab/php/dao/Dbcon.php';

class tbl_ride extends Dbcon {

    const SOURCE_TBL = "tbl_ride";

    private $ride_id;
    private $ride_date;
    private $from;
    private $to;
    private $total_distance;
    private $luggage;
    private $total_fare;
    private $status;
    private $customer_user_id;
    private $cabType;
    private $allRidesArr;

    function __construct() {
        $this->getConn();
    }

    function getConn() {
        $this->createConnection();
    }

    function addNewRide() {
        $query = "insert into `" . self::SOURCE_TBL . "` "
                . "(`ride_date`, `from`, `to`,`total_distance`, `luggage`, `total_fare`, `status`, `customer_user_id`, `cabtype`) "
                . "values(now(), '$this->from', '$this->to', '$this->total_distance','$this->luggage','$this->total_fare','1','$this->customer_user_id','$this->cabType')";
        $result = $this->conn->query($query);
        if ($this->conn->affected_rows > 0) {
            return 200;
        } else if ($this->conn->affected_rows == 0) {
            return 404;
        } else {
            return $this->conn->error;
        }
    }

    function getAllRides($customer_user_id) {
        $query = "select * from `" . self::SOURCE_TBL . "` where `customer_user_id`= '$customer_user_id'";

        $result = $this->conn->query($query);

        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                $this->allRidesArr[] = $row;
            }
            return 200;
        } else {
            return -1;
        }
    }

    function calculateDistance($dropLocation, $pickupLocation) {
        return abs($pickupLocation - $dropLocation);
    }

    function getTotalPendingRides($userid) {
        $query = "select `status` from `tbl_ride` where `status` = '1' and `customer_user_id`  = '$userid'";
        $result = $this->conn->query($query);
        if ($this->conn->affected_rows > 0) {
            return $result->num_rows;
        }else{
            if($this->conn->errno==0)
                return 0;
            else
                return $this->conn->error;
        }
    }
    
    function getAllPendingRides($userid){
        $query = "select * from `" . self::SOURCE_TBL . "` where `status` = '1' and `customer_user_id`= '$userid'";

        $result = $this->conn->query($query);

        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                $this->allRidesArr[] = $row;
            }
            return 200;
        } else {
            return -1;
        }
    }

    function getTotalCancelledRides($userid) {
        $query = "select `status` from `tbl_ride` where `status` = '0' and `customer_user_id`  = '$userid'";
        $result = $this->conn->query($query);
        if ($this->conn->affected_rows > 0) {
            return $result->num_rows;
        }else{
            if($this->conn->errno==0)
                return 0;
            else
                return $this->conn->error;
        }
    }
    
    function getAllCancelledRides($userid){
        $query = "select * from `" . self::SOURCE_TBL . "` where `status` = '0' and `customer_user_id`= '$userid'";

        $result = $this->conn->query($query);

        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                $this->allRidesArr[] = $row;
            }
            return 200;
        } else {
            return -1;
        }
    }

    function getTotalSpent($userid) {
        $query = "select sum(`total_fare`) as `total_spent` from `tbl_ride` where `status` = '2' and `customer_user_id`  =  '$userid'";
        $result = $this->conn->query($query);
        if ($this->conn->affected_rows > 0) {
            return $result->fetch_assoc()['total_spent'];
        }else{
            if($this->conn->errno==0)
                return 0;
            else
                return $this->conn->error;
        }
    }
    
    function getAllTotalSpent($userid){
        $query = "select * from `" . self::SOURCE_TBL . "` where `status` = '2' and `customer_user_id`= '$userid'";

        $result = $this->conn->query($query);

        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                $this->allRidesArr[] = $row;
            }
            return 200;
        } else {
            return -1;
        }
    }

    function getTotalRides($userid) {
        $query = "select `status` from `tbl_ride` where `customer_user_id`  = '$userid'";
        $result = $this->conn->query($query);
        if ($this->conn->affected_rows > 0) {
            return $result->num_rows;
        }else{
            if($this->conn->errno==0)
                return 0;
            else
                return $this->conn->error;
        }
    }
    
    function getAllTotalRides($userid){
        $query = "select * from `" . self::SOURCE_TBL . "` where `customer_user_id`= '$userid'";

        $result = $this->conn->query($query);

        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                $this->allRidesArr[] = $row;
            }
            return 200;
        } else {
            return -1;
        }
    }
    
    function cancelRide($rideid){
        $query = "update `".self::SOURCE_TBL."` set `status` = '0' where `ride_id`='$rideid'";
        $this->conn->query($query);
        if($this->conn->affected_rows>0){
            return 200;
        }else{
            return $this->conn->error;
        }
    }

    function getCabType($userid) {
        return $this->cabType;
    }

    function setCabType($cabType): void {
        $this->cabType = $cabType;
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

    function getAllRidesArr() {
        return $this->allRidesArr;
    }

    function setAllRidesArr($allRidesArr): void {
        $this->allRidesArr = $allRidesArr;
    }

}
