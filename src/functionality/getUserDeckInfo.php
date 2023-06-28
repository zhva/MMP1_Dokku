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
    if(!isset($_COOKIE['user']))
    {
        header('Location: login.php');
        exit;
    }
    $login = $_COOKIE['user'];

    if(!isset($_GET['deckcode']))
    {
        // response that deckcode is not set
        exit;
    }
    $deckCode = rawurldecode($_GET['deckcode']);
    include 'functions.php';

    try
    {
        $sth = $dbh->prepare("SELECT id FROM users WHERE login = ?;");
        $sth->execute(array($login));
        $user = $sth->fetchObject();
        $userId = $user->id;
    }
    catch (PDOException $e)
    {
        //there is no such user registered
        header('Location: login.php');
        exit;
    }

    class Deck
    {
        public $id;
        public $deck_name;
        public $deck_code;
        public $description;
        public $rating;
        public $dust_cost;
        public $last_modified;
    }

    try
    {
        $deckCodeEncoded = rawurlencode($deckCode);
        $sth = $dbh->prepare("SELECT 
            id, deck_name, deck_code, description, rating, dust_cost, last_modified
            FROM decks 
            LEFT JOIN class ON decks.class_id=class.api_id 
            WHERE user_id = ? AND deck_code = ?;");
        $sth->execute(array($userId, $deckCodeEncoded));
        $deck = $sth->fetchObject("Deck");

    }
    catch (PDOException $e)
    {
        // Response that this user doesn't have deck with this deck code
        http_response_code(500);
        exit;
    }

    $outData;
    if ($deck == false) {
        $outData = array(
                    'nodeck'        => true
                );
    }
    else {
        $outData = array(        
                    'id'            => $deck->id,
                    'name'          => $deck->deck_name,
                    'code'          => $deck->deck_code,
                    'description'   => $deck->description,
                    'rating'        => $deck->rating,
                    'dustCost'      => $deck->dust_cost,
                    'nodeck'        => false
                );
    }
    exit(json_encode($outData));
?>