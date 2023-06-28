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
    if(!isset($_POST['email']) || !isset($_POST['password'])) 
    {
        header('Location: ../login.php');
        exit;
    }
    $email = "";
    $password = "";

    $email = validateInput($_POST['email']);
    $password = validateInput($_POST['password']);

    class User
    {
        public $login;
        public $email;
        public $password_hash;
    }

    try
    {
        $sth = $dbh->prepare("SELECT * FROM users WHERE email = ?;");
        $sth->execute(array($email));

        $user = $sth->fetchObject('User');
        if($user == false)
        {
            throw new Exception("User does not exist!");
        }
        else
        {
            $username = $user->login;
            $userpassh = $user->password_hash;


            if(!password_verify($password, $userpassh))
            {
                throw new Exception("Invalid password!");
            }
            else
            {
                $_SESSION['user'] = $username;
                setcookie('user', $username, time() + 3600*24, "/", '', isset($_SERVER['HTTPS']), true);
            }
        }

    }
    catch (Exception $e)
    {

        if($e->getMessage() == "User does not exist!")
        {
            header("Location: ../login.php?wronglogin=true");
            exit();
        }
        else if($e->getMessage() == "Invalid password!")
        {
            header("Location: ../login.php?wrongpass=true");
            exit();
        }
        else
        {
            header("Location: ../login.php?authentfailed=true");
            exit();
        }
    }

    header("Location: ../index.php");
    exit;
?>

