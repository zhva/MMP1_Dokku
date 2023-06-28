
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

    if(!isset($_GET['id']))
    {
        header("Location: ../index.php"); 
        exit();
    }
    $cardId = $_GET['id'];
    $cardJson;

    $apiRoot = "https://us.api.blizzard.com/hearthstone/cards/";


    function getCard($root, $searchTerm, $token)
    {
        if(empty($root) || empty($searchTerm) || empty($token))
        {
            return;
        }

        $url = $root . $searchTerm . "?locale=en_US&=&sort=manaCost:asc&access_token=" . $token;
        $data = file_get_contents($url);
        $json = json_decode($data);
        return $json;  
    }
    $apiToken = $_COOKIE['token'];
    $cardJson = getCard($apiRoot, $cardId, $apiToken);

    $outData = array(
            'name'      => $cardJson->name, 
            'id'        => $cardJson->id, 
            'manaCost'  => $cardJson->manaCost, 
            'cropImage' => $cardJson->cropImage, 
            'rarityId'  => $cardJson->rarityId
        );

    exit(json_encode($outData));
?>