<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
$locations = array(
    "Charbagh"=> 0,
    "Indra Nagar"=> 10,
    "BBD"=> 30,
    "Barabanki"=> 60,
    "Faizabad"=> 100,
    "Basti"=> 150,
    "Gorakhpur"=> 210
);

header('Content-Type: application/json');
print_r(json_encode($locations));

