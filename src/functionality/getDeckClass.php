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
    if(!isset($_GET['deckcode']))
    {
        return;
    }
    $deckCode = rawurlencode($_GET['deckcode']);
    include 'functions.php';

    $apiRoot = "https://us.api.blizzard.com/hearthstone/deck?locale=en_US&code=";
    $apiToken = $_COOKIE['token'];
    $url = $apiRoot .$deckCode."&access_token=" . $apiToken;
    $data = file_get_contents($url);
    if($data === false)
    {
        http_response_code(403);
        exit();
    }
    else
    {
        $json = json_decode($data);
        $classId = $json->hero->classId;
        $class = "";

        try
        {
            $sth = $dbh->prepare("SELECT slug FROM class WHERE api_id = ?");
            $sth->execute(array($classId));
            $res = $sth->fetchObject();
            $class = $res->slug;
        }
        catch (PDOException $e)
        {
            http_response_code(400);
            exit;
        }

        $outData = array('class' => $class);
        exit(json_encode($outData));
    }
?>