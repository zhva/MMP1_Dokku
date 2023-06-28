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
    include "getHsApiToken.php";

    $search_term = "metadata";
    $apiRoot = "https://us.api.blizzard.com/hearthstone/";

    $url = $apiRoot . $search_term . "?locale=en_US&access_token=" . $apiToken;
    $data = file_get_contents($url);
    $metaData = json_decode($data);
    $minionTypes = $metaData->minionTypes;
    $cardTypes = $metaData->types;
    $rarities = $metaData->rarities;
    $keywords = $metaData->keywords;
    $classes = $metaData->classes;
?>

