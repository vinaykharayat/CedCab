<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

class tbl_location{
    private $id;
    private $name;
    private $distance;
    private $is_available;
    
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


}

