<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
//die(dirname(getcwd()));
session_start();
require_once $_SERVER['DOCUMENT_ROOT']."/cedcab/php/dao/Dbcon.php";

class tbl_user extends Dbcon {

    const sourcetbl = "tbl_user";
    const SUCCESS_CODE = 200;
    const FAILURE_CODE = -1;

    private $user_id;
    private $email_id;
    private $name;
    private $dateofsignup;
    private $mobile;
    private $status;
    private $password;
    private $is_admin;
    private $profilePicUrl;
    
    function __construct() {
        $this->getConn();
    }


    function getConn() {
        $this->createConnection();
    }

    public function LoginCheck($email, $password) {
        $this->email = $email;
        $this->password = md5($password);

        $query = "select * from `" . self::sourcetbl . "` where `email_id` = '$this->email' and `password` = '$this->password'";
        $result = $this->conn->query($query);
      
        if ($result->num_rows>0) {
            $user = $result->fetch_assoc();
            if ($user['is_admin'] == 1) { //user is admin
                $res = 1;
                $_SESSION['user'] = $user;
            } elseif ($user['status'] == 1) { //if user is not admin and is active
                $res = 0;
                $_SESSION['user'] = $user;
            } else {
                $res = -1; //if user is not admin and is not active
            }
        } else {
            $res = -2; //user does not exist
        }
        return $res;
    }

    public function signUp() {
        $query = "insert into tbl_user(`email_id`, `name`,`password`, `dateofsignup`, `mobile`, `status`, `is_admin`, `profilePic`) values('" . $this->email_id . "', '" . $this->name . "', '" . md5($this->password) . "', now() , '" . $this->mobile . "', '" . 1 . "', '" . 0 . "', '" . $this->profilePicUrl . "')";
        $this->conn->query($query);
        if ($this->conn->errno == 0) {
            if ($this->conn->affected_rows > 0) {
                return 200;
            } else {
                return 100;
            }
        } else {
            return $this->conn->error;
        }
    }

    public function checkAvalability($columnName, $valueToCheck) {
        $query = "select * from " . self::sourcetbl . " where `$columnName` = '$valueToCheck'";
        $result = $this->conn->query($query);
        if ($result->num_rows == 0) {
            return self::SUCCESS_CODE;
        } else {
            return self::FAILURE_CODE;
        }
    }

    function getProfilePicUrl() {
        return $this->profilePicUrl;
    }

    function setProfilePicUrl($profilePicUrl): void {
        $this->profilePicUrl = $profilePicUrl;
    }

    function getUser_id() {
        return $this->user_id;
    }

    function getEmail_id() {
        return $this->email_id;
    }

    function getName() {
        return $this->name;
    }

    function getDateofsignup() {
        return $this->dateofsignup;
    }

    function getMobile() {
        return $this->mobile;
    }

    function getStatus() {
        return $this->status;
    }

    function getPassword() {
        return $this->password;
    }

    function getIs_admin() {
        return $this->is_admin;
    }

    function setUser_id($user_id): void {
        $this->user_id = $user_id;
    }

    function setEmail_id($email_id): void {
        $this->email_id = $email_id;
    }

    function setName($name): void {
        $this->name = $name;
    }

    function setDateofsignup($dateofsignup): void {
        $this->dateofsignup = $dateofsignup;
    }

    function setMobile($mobile): void {
        $this->mobile = $mobile;
    }

    function setStatus($status): void {
        $this->status = $status;
    }

    function setPassword($password): void {
        $this->password = $password;
    }

    function setIs_admin($is_admin): void {
        $this->is_admin = $is_admin;
    }

}
