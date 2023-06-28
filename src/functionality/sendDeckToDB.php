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
    $json = file_get_contents('php://input');
    if(empty($json))
    {
        http_response_code(400);
        exit();
    }
    $data = json_decode($json);
    $userLogin = '';
    if(!isset($_COOKIE['user']))
    {
        //user is not logged in
        header("Location: ../login.php");
        exit;
    }
    
    $userLogin = $_COOKIE['user'];
    try
    {
        $sth = $dbh->prepare("SELECT id FROM users WHERE login = ?;");
        $sth->execute(array($userLogin));

        $user = $sth->fetchObject();
        $userId = $user->id;

    }
    catch (PDOException $e)
    {
        http_response_code(400);
        exit;
    }

    $deckId = validateInput($data->deckId);
    $deckCode = validateInput($data->deckCode);
    $deckName = validateInput($data->deckName);
    $className = validateInput($data->className);
    $dustCost = intval(validateInput($data->dustCost));
    $rating = intval(validateInput($data->rating));
    $description = ($data->description);
    $lastModified = date('Y-m-d H:i:s');
    $classId = "";
    $newDeckId ="";
    $outData = "";
    $deckCodeEncoded = rawurlencode($deckCode);

    try
    {
        $sth = $dbh->prepare("SELECT api_id FROM class WHERE slug = ?;");
        $sth->execute(array($className));

        $class = $sth->fetchObject();
        $classId = $class->api_id;

    }
    catch (PDOException $e)
    {
        http_response_code(400);
        exit;
    }

    if(empty($deckId))
    {
        try
        {
            $sth = $dbh->prepare("INSERT INTO decks (deck_name, deck_code, description, rating, class_id, dust_cost, last_modified, user_id)
            VALUES(?, ?, ?, ?, ?, ?, ?, ?) RETURNING id;");
            $sth->execute(array($deckName, $deckCodeEncoded, $description, $rating, $classId, $dustCost, $lastModified, $userId));

            $res = $sth->fetchObject();
            $newDeckId = $res->id;
        }
        catch (PDOException $e)
        {
            http_response_code(418);
            exit();
        }
    }
    else
    {
        $deckId = intval($deckId);
        try
        {
            $sth = $dbh->prepare("UPDATE decks SET deck_name = ?, deck_code = ?, description = ?, rating = ?, dust_cost = ?, last_modified = ?
                                  WHERE id = $deckId");
            $sth->execute(array($deckName, rawurlencode($deckCode), $description, $rating, $dustCost, $lastModified));
            $newDeckId = $deckId;
        }
        catch (PDOException $e)
        {
            http_response_code(418);
            exit();
        }
    }
    $outData = array('deckId' => $newDeckId);
    http_response_code(200);
    exit(json_encode($outData));

?>