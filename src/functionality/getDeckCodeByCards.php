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
    if(!isset($_GET['ids']))
    {
        return;
    }
    $cardsIds = $_GET['ids'];

    $apiRoot = "https://us.api.blizzard.com/hearthstone/deck?locale=en_US&ids=";
    $apiToken = $_COOKIE['token'];
    $url = $apiRoot .$cardsIds."&access_token=" . $apiToken;
    $data = file_get_contents($url);
    $json = json_decode($data);

    $outData = array('deckCode' => $json->deckCode, 'heroId' => $json->hero->id, 'classId' => $json->hero->classId, 'cards' => $cardsIds);

    $res = json_encode($outData);
    exit(json_encode($outData));
?>