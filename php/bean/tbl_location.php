<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

require_once $_SERVER['DOCUMENT_ROOT'] . '/cedcab/php/dao/Dbcon.php';

class tbl_location extends Dbcon {

    const sourcetbl = "tbl_location";

    private $id;
    private $name;
    private $distance;
    private $is_available;
    private $locations;

    function __construct() {
        $this->getConn();
    }

    function getConn() {
        $this->createConnection();
    }

    function getAllLocations() {
        $query = "select * from `" . self::sourcetbl . "` where 1";
        $result = $this->conn->query($query);
        $locationsArr = array();
        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                $locationsArr[] = $row;
            }
            $this->makeAssocArray($locationsArr);
            return 200;
        } else {
            return -1;
        }
    }

    private function makeAssocArray($locationsArr) {
        for ($i = 0; $i < count($locationsArr); $i++) {
            $this->locations[$locationsArr[$i]["id"]] = array("name" => $locationsArr[$i]["name"], "distance" => $locationsArr[$i]["distance"]);
        }
    }

    function getLocationNameDistance($id) {
        $query = "select `name` , `distance` from `" . self::sourcetbl . "` where id='$id'";
        $result = $this->conn->query($query);
        return $result->fetch_assoc();
    }

    function getAllLocationsAdmin() {
        $query = "select * from " . self::sourcetbl . " where 1";
        $result = $this->conn->query($query);

        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                $this->locations[] = $row;
            }
            return 200;
        } else {
            return -1;
        }
    }

    function blockUnblockLocation($locationId, $blockLocation) {
        if ($blockLocation == "true") {
            $query = "update `" . self::sourcetbl . "` set `is_available`= '0' where `id`= '$locationId'";
        } else {
            $query = "update `" . self::sourcetbl . "` set `is_available`= '1' where `id`= '$locationId'";
        }
        $this->conn->query($query);
        if ($this->conn->affected_rows > 0) {
            return 200;
        } else {
            return 500;
        }
    }

    function deleteLocation($locationId) {
        $query = "DELETE FROM `". self::sourcetbl ."` WHERE `id` = '$locationId'";
        $this->conn->query($query);
        if ($this->conn->affected_rows > 0) {
            return 200;
        } else {
            return 500;
        }
    }

    function addNewLocation($locationName, $locationDistance, $locationStatus) {
        $query = "insert into `" . self::sourcetbl . "` (`name`, `distance`, `is_available`) value('$locationName', '$locationDistance', '$locationStatus')";
        $this->conn->query($query);
        if ($this->conn->affected_rows > 0) {
            return 200;
        } else {
            return 500;
        }
    }

    function getId() {
        return $this->id;
    }

    function getName() {
        return $this->name;
    }

    function getDistance() {
        return $this->distance;
    }

    function getIs_available() {
        return $this->is_available;
    }

    function setId($id): void {
        $this->id = $id;
    }

    function setName($name): void {
        $this->name = $name;
    }

    function setDistance($distance): void {
        $this->distance = $distance;
    }

    function setIs_available($is_available): void {
        $this->is_available = $is_available;
    }

    function getLocations() {
        return $this->locations;
    }

    function setLocations($locations): void {
        $this->locations = $locations;
    }

}
