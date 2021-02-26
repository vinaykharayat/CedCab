<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
use PHPMailer\PHPMailer\PHPMailer;
session_start();
define("OTP", mt_rand(100000, 999999));


if(isset($_POST["email"])){
    sendOTPToEmail(filter_input(INPUT_POST, "email"));
}
if(isset($_POST["phone"])){
    sendOTPToPhone(filter_input(INPUT_POST, "phone"));
}

function sendOTPToPhone($userPhone){
    $fields = array(
        "sender_id" => "CHKSMS",
        "message" => "2",
        "variables_values" => OTP,
        "route" => "s",
        "numbers" => $userPhone,
    );
    
    $curl = curl_init();

    curl_setopt_array($curl, array(
        CURLOPT_URL => "https://www.fast2sms.com/dev/bulkV2",
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_ENCODING => "",
        CURLOPT_MAXREDIRS => 10,
        CURLOPT_TIMEOUT => 30,
        CURLOPT_SSL_VERIFYHOST => 0,
        CURLOPT_SSL_VERIFYPEER => 0,
        CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
        CURLOPT_CUSTOMREQUEST => "POST",
        CURLOPT_POSTFIELDS => json_encode($fields),
        CURLOPT_HTTPHEADER => array(
            "authorization: tEPtZANxzhBY8fC62LADehwaaB3cyeIunTqzsAxbNzbHFWhZzZimcWRZDDPV",
            "accept: */*",
            "cache-control: no-cache",
            "content-type: application/json"
        ),
    ));

    $response = curl_exec($curl);
    $err = curl_error($curl);

    curl_close($curl);

    if ($err) {
        echo -1;
    } else {
        $_SESSION["phoneotp"] = OTP;
        echo 200;
    }
}

function sendOTPToEmail($userEmail){
                
    require_once dirname(getcwd()).'/php/libs/PHPMailer/src/PHPMailer.php';
    require_once dirname(getcwd()).'/php/libs/PHPMailer/src/SMTP.php';
    require_once dirname(getcwd()).'/php/libs/PHPMailer/src/Exception.php';

    $mail = new PHPMailer();
    $mail->isSMTP();
    $mail->Host = "smtp.gmail.com";
    $mail->SMTPAuth = true;
    $mail->Username = "shastrishraddha1001@gmail.com"; //Mail will be sent from this email
    $mail->Password = "Jungle@mogli10";
    $mail->Port = 465;
    $mail->SMTPSecure = "ssl";
    //Email settings
    $mail->isHTML(true);
    $mail->setFrom($_POST['email'], $_POST['name']);

    $mail->addAddress($userEmail);    //Mail will be sent to this email
    $mail->Subject = $_POST["subject"];
    $mail->Body = "Registration successful. Welcome " . $_POST['name'] . "Your otp is " . OTP;
    if ($mail->send()) {
        $_SESSION["emailotp"] = OTP;
        echo 200;
    } else {
        echo -1;
    }
}
