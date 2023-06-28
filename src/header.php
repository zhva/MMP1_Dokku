<!DOCTYPE html>
<html lang="en">
<!-- 
This project was created as a part of the bachelor's degree in MultiMediaTechnology at Salzburg 
University of Applied Sciences.

It is a learning project and it does not pursue any commercial goals. All the images used in this project
were either created by Viktoriia Zhuravel, found on the internet under the Creative Commons NonCommercial 
license or provided by the Blizzard API (https://develop.battle.net/). All the rights for the images from 
Blizzard API or any resources affiliated with Hearthstone(TM) as well as any names and trademarks belong to 
Blizzard Entertainment, Inc.

MultiMediaProject 1 - Summer semester 2022

Design & Development: Viktoria Zhuravel -->
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo "$pagetitle"; ?></title>
    <link rel="stylesheet" href="css/reset.css">    
    <link rel="stylesheet" href="css/style.css">
</head>
<body>
    <header>
        <nav class="navigation">
            <ul>
                <li><a href="index.php">Deck builder</a></li>
                <?php 
                    if(isset($_SESSION['user']))
                    {
                        $user = $_SESSION['user'];
                        echo "<li><a href='userDecks.php'>My Decks</a></li>";
                        echo "<li><a href='logout.php'>LogOut</a> ($user)</li>";
                    }
                    else
                    {
                        echo "<li><a href='register.php'>Register</a></li>";
                        echo "<li><a href='login.php'>LogIn</a></li>";
                    }
                ?>
            </ul>
        </nav>
    </header>