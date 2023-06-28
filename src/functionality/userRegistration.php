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
    include "functions.php";
    if(!isset($_POST['login']) || !isset($_POST['email']) || !isset($_POST['password'])) 
    {
        $_SESSION["errormsg"]='You must fill password';
        header('Location: register.php');
        exit;
    }
    else if(strlen($_POST['password']) < 8)
    {
        $_SESSION["errormsg"]='Password must be at least 8 charachters';
        header('Location: register.php');
        exit;
    }

    $login = "";
    $email = "";
    $password = "";
    $passwordRepeat = "";
    $userExists = false;

    $login = validateInput($_POST['login']);
    $email = validateInput($_POST['email']);
    $password = validateInput($_POST['password']);
    $passwordRepeat = validateInput($_POST['password-repeat']);

    if($password != $passwordRepeat)
    {
        $_SESSION["errormsg"] = "Passwords do not match! Please try again!";
        header('Location: ../register.php');
        exit();
    }

    $password_hash = password_hash($password, PASSWORD_DEFAULT);

    try
    {
        $sth = $dbh->prepare("INSERT INTO users ( login, email, password_hash) VALUES (?, ?, ?);");
        $sth->execute(array($login, $email, $password_hash));
        
    }
    catch (PDOException $e)
    {
        if(strpos($e, 'users_email_key') != false)
        {
            $_SESSION["errormsg"] = "Someone has already registered with your email!";
        }
        else if(strpos($e, 'users_login_key') != false)
        {
            $_SESSION["errormsg"] = "User with this name already exists!";
        }
        $userExists = true;
    }

    if(!$userExists)
    {
        unset($_SESSION["errormsg"]);   
        header('Location: ../login.php');
    }
    else
    {   
        header('Location: ../register.php');
    }

?>