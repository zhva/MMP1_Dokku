<?php
// This project was created as a part of the bachelor's degree in MultiMediaTechnology at Salzburg
// University of Applied Sciences.

// It is a learning project and it does not pursue any commercial goals. All the images used in this project
// were either created by Viktoriia Zhuravel, found on the internet under the Creative Commons NonCommercial
// license or provided by the Blizzard API (https://develop.battle.net/). All the rights for the images from
// Blizzard API or any resources affiliated with Hearthstone(TM) as well as any names and trademarks belong to
// Blizzard Entertainment, Inc.

// MultiMediaProject 1 - Summer semester 2022

// Design & Development: Viktoria Zhuravel

include 'db_functions.php';


$clientId = "6eb49842bf6248c9831cc8343bb1fdd5";
$clientSecret = "S6iqxaH5w9I8QfFxZUdt6ZMJn2Wix5yz";

    if(!isset($_COOKIE['token']))
    {
        $oathUrl = 'https://us.battle.net/oauth/token';
        $data = array('grant_type' => 'client_credentials');
        $curl = curl_init($oathUrl);

        curl_setopt($curl, CURLOPT_URL, $oathUrl);
        curl_setopt($curl, CURLOPT_POST, true);
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);

        $headers = array(
            "Accept: application/json",
            "Content-Type: multipart/form-data",
            "Authorization: Basic ".base64_encode("$clientId:$clientSecret")
        );

        curl_setopt($curl, CURLOPT_HTTPHEADER, $headers);
        curl_setopt($curl, CURLOPT_POSTFIELDS, $data);

        $response = curl_exec($curl);
        curl_close($curl);

        $result = json_decode($response);
        $token = $result->access_token;
        setcookie(
            'token', $token, time() + $result->expires_in);
        $apiToken = $token;
    }
    else
    {
        $apiToken = $_COOKIE['token'];
    }
?>
