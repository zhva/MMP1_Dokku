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

    include 'functions.php';
    function getClassCards($root, $searchTerm, $class, $pageSize, $token)
    {
        if(empty($root) || empty($searchTerm) || empty($class) || empty($pageSize) || empty($token))
        {
            return;
        }

        $url = $root . $searchTerm . "?locale=en_US&class=" . $class . "&set=standard&sort=manaCost:asc&pageSize=".$pageSize."&access_token=" . $token;
        $data = file_get_contents($url);
        $json = json_decode($data);
        return $json;  
    }
    function composeCardsJson($cards)
    {
        $arr = array();
        for($i = 0; $i < count($cards); $i++)
        {
            $name = $cards[$i]->name;
            $id = $cards[$i]->id;
            $manaCost = $cards[$i]->manaCost;
            $rarityId = $cards[$i]->rarityId;
            $cardTypeId = $cards[$i]->cardTypeId;
            $minionTypeId = (isset($cards[$i]->minionTypeId)) ? $cards[$i]->minionTypeId : null;
            $keywordIds = (isset($cards[$i]->keywordIds)) ? $cards[$i]->keywordIds : null;
            $image = $cards[$i]->image;
            $card = array(
                'name' => $name, 
                'id' => $id, 
                'manaCost' => $manaCost, 
                'rarityId' => $rarityId, 
                'cardTypeId' => $cardTypeId, 
                'minionTypeId' => $minionTypeId, 
                'keywordIds' => $keywordIds,
                'image' => $image
            );
            array_push($arr, $card);
        }

        return $arr;
    }

    $search_term = "cards";
    $apiRoot = "https://us.api.blizzard.com/hearthstone/";
    if(!isset($_GET['class']))
    {
        header("Location: ../index.php"); // send back
        exit(); 
    }
    $class = $_GET['class'];
    $classNeutral = "neutral";
    $pageS = 300;

    $jsonCardsClass = getClassCards($apiRoot, $search_term, $class, $pageS, $apiToken);
    $cardsClass = $jsonCardsClass->cards;

    $jsonCardsNeutral = getClassCards($apiRoot, $search_term, $classNeutral, $pageS, $apiToken);
    $cardsNeutral = $jsonCardsNeutral->cards;

    $outData = array();
    $outData = array('classCards' => composeCardsJson($cardsClass), 'neutralCards' => composeCardsJson($cardsNeutral));
    $data = array('cards' => $outData);
    $res = json_encode($data);
    exit($res);

?>