<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
session_start();
if (isset($_SESSION["emailotp"])) {
    if ($_POST["otp"] == $_SESSION["emailotp"]) {
        $_SESSION["emailVerified"] = true;
        echo '200';
        die();
    } else if ($_POST["otp"] != $_SESSION["emailotp"]) {
        echo '0';
    } else {
        "-1";
    }
}

if (isset($_SESSION["phoneotp"])) {
    if ($_POST["otp"] == $_SESSION["phoneotp"]) {
        $_SESSION["phoneVerified"] = true;
        echo '200';
    } else if ($_POST["otp"] != $_SESSION["phoneotp"]) {
        echo '0';
    } else {
        echo '-1';
    }
}

