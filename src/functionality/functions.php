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
    ini_set('display_errors', true);
    session_start();

    if(!isset($_COOKIE['user']))
    {
        setcookie('user', "", time() + (86400 * 30), "/", "", isset($_SERVER['HTTPS']), true);
    }

    include "getHsApiToken.php";
    $pagetitle = "Hearthstone Deck Manager";

    function validateInput($data)
    {
        $data = trim($data);
        $data = stripslashes($data);
        $data = htmlspecialchars($data);
        return $data;
    }

    function getManaString($i)
    {
        if($i == -1)
        {
            return "-Any-";
        }
        else if($i > -1 && $i < 8)
        {
            return $i;
        }
        else if($i >= 8)
        {
            return "8+";
        }
    }
    function printManaOptions($maxManaCost, $optionType)
    {
        $selectedIndex = -1;
        if (isset($_GET[$optionType]))
            $selectedIndex = $_GET[$optionType];

        $selectedAttribute = "";
        for($i = -1; $i <= $maxManaCost; $i++)
        {
            $selectedAttribute = ($i == $selectedIndex) ? " selected = \"selected\"" : "";
            echo "<option value=\"$i\"".$selectedAttribute.">".getManaString($i)."</option>\n";
        }
    }

    function printOptions($set, $optionType)
    {
        $selectedIndex = -1;
        $selectedAttribute = " selected = \"selected\"";
        if (isset($_GET[$optionType])) {
            $selectedIndex = $_GET[$optionType];
            $selectedAttribute = "";
        }

        echo "<option value=\"-1\"".$selectedAttribute.">-Any-</option>\n";

        for($i = 0; $i < sizeof($set); $i++)
        {
            $selectedAttribute = ($set[$i]->id == $selectedIndex) ? " selected = \"selected\"" : "";
            echo "<option value=\"".$set[$i]->id."\"".$selectedAttribute.">".$set[$i]->name."</option>\n";
        }
    }

    require "db_functions.php";

    if ( ! $DB_NAME ) die ('Please create config.php, define $DB_NAME, $DSN, $DB_USER, $DB_PASS there. See config_sample.php');

    try {
        $dbh = new PDO($DSN, $DB_USER, $DB_PASS);
        $dbh->setAttribute(PDO::ATTR_ERRMODE,            PDO::ERRMODE_EXCEPTION);
        $dbh->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_OBJ);

    } catch (Exception $e) {
        die ("Problem connecting to database $DB_NAME as $DB_USER: " . $e->getMessage() );
    }

    // $day_short = new IntlDateFormatter('de_DE', IntlDateFormatter::SHORT, IntlDateFormatter::SHORT);
    // $day_long = new IntlDateFormatter('de_DE', IntlDateFormatter::SHORT, IntlDateFormatter::SHORT);
    // $day_db = new IntlDateFormatter('de_DE', IntlDateFormatter::SHORT, IntlDateFormatter::SHORT);

    // $day_short->setPattern('d. LLL');
    // $day_long->setPattern('EEEE d. LLLL yyyy');
    // $day_db->setPattern('yyyy-LL-dd');

?>
