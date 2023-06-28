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
    $deckId = validateInput($data->deckId);

    try
    {
        $sth = $dbh->prepare("DELETE FROM decks WHERE id = ?;");
        $sth->execute(array($deckId));

    }
    catch (PDOException $e)
    {
        http_response_code(400);
        exit;
    }
    
    http_response_code(200);
    exit();
?>