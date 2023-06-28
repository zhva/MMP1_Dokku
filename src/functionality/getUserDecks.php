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
        public $class_slug;
        public $class_name;
        public $dust_cost;
        public $last_modified;
        public $user_id;
    }

    try
    {
        $sth = $dbh->prepare("SELECT 
            id, deck_name, deck_code, description, rating, class.slug as class_slug, class.name as class_name, dust_cost, last_modified, user_id
            FROM decks 
            LEFT JOIN class ON decks.class_id=class.api_id 
            WHERE user_id = ?
            ORDER BY last_modified DESC;");
        $sth->execute(array($userId));
        $decks = $sth->fetchAll(PDO::FETCH_CLASS, "Deck");

    }
    catch (PDOException $e)
    {
        http_response_code(500);
        exit;
    }

    $outData = array();
    $arr = array();
    for($i = 0; $i < count($decks); $i++)
    {
        $info = array(
            'id'            => $decks[$i]->id,
            'name'          => $decks[$i]->deck_name,
            'code'          => rawurldecode($decks[$i]->deck_code),
            'description'   => $decks[$i]->description,
            'rating'        => $decks[$i]->rating,
            'classSlug'     => $decks[$i]->class_slug,
            'className'     => $decks[$i]->class_name,
            'dustCost'      => $decks[$i]->dust_cost,
            'lastModified'  => $decks[$i]->last_modified
        );
        array_push($arr, $info);
    }
    $outData = array('decks' => $arr);
    exit(json_encode($outData));
?>