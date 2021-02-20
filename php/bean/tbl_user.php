<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
class tbl_user extends dbCon{
    private $user_id;
    private $email_id;
    private $name;
    private $dateofsignup;
    private $mobile;
    private $status;
    private $password;
    private $is_admin;
    
    function __construct($user_id, $email_id, $name, $dateofsignup, $mobile, $status, $password, $is_admin) {
        $this->user_id = $user_id;
        $this->email_id = $email_id;
        $this->name = $name;
        $this->dateofsignup = $dateofsignup;
        $this->mobile = $mobile;
        $this->status = $status;
        $this->password = $password;
        $this->is_admin = $is_admin;
    }
    
    function signupLogin(){
        if($this->is_admin==1){
            
        }else{
            
        }
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
