<?php
    $pagetitle = "Home";
    include "functionality/functions.php";
    include "functionality/getMetadataApi.php";
    include "header.php";
?>
    <main>
        <div class="content-container">
            <div class="content-wrapper">
                <div class="index-content">
                    <div class="content-text">
                        <div>
                            <p>Hearthstone is a turn-based card game between two opponents, which uses assembled decks of 
                                30 cards along with a chosen hero with a unique power. Players use their limited mana 
                                crystals to cast abilities or summon minions to attack the enemy in order to destroy 
                                the enemy hero. By winning matches and completing quests, you will receive in-game gold, 
                                new card rewards, and other in-game prizes.</p>
                        </div>
                        <div class="start-decks-container">
                            <p>Here some decks for you to start with</p>
                            <ul>
                                <li>
                                    <div class="hex">
                                        <div class="hex-background">
                                            <img class="clipped_img" src="img/classIcons/paladin.png" alt="paladin">
                                        </div>
                                    </div>
                                    <a href="deckbuilder.php?class=paladin&deckcode=AAECAZ8FBvvoA%2FD2A%2BCLBPmkBLCyBOy6BAyq%2BAPJoATWoASStQThtQTeuQTjuQTUvQSywQTa0wTa2QSUpAUA">Mech Paladin</a>
                                </li>
                                <li>
                                <div class="hex">
                                        <div class="hex-background">
                                            <img class="clipped_img" src="img/classIcons/warrior.png" alt="warrior">
                                        </div>
                                    </div>
                                    <a href="deckbuilder.php?class=warrior&deckcode=AAECAQcGx%2FkDv4AEm4EEvIoEiqUEjskEDI7tA%2FiABPmMBPqMBIigBImgBKygBPyiBIu3BIy3BJC3BI7UBAA%3D">Charge Control Warrior</a>
                                </li>
                                <li>
                                <div class="hex">
                                        <div class="hex-background">
                                            <img class="clipped_img" src="img/classIcons/mage.png" alt="mage">
                                        </div>
                                    </div>
                                    <a href="deckbuilder.php?class=mage&deckcode=AAECAf0EArL3A6neBA7U6gPQ7AOu9wP0%2FAOogQT8ngSEsgSIsgS8sgSHtwSWtwTcuQThuQSywQQA">Naga Mage</a>
                                </li>
                                <li>
                                <div class="hex">
                                        <div class="hex-background">
                                            <img class="clipped_img" src="img/classIcons/warlock.png" alt="warlock">   
                                        </div>
                                    </div>
                                    <a href="deckbuilder.php?class=warlock&deckcode=AAECAa35AwSm7wOwkQTlsAT1xwQNk%2BgDlOgDoqAEq6AE9LEE1bIEvrQEgLUE470EssEEnMcE7tME%2FtgEAA%3D%3D">Murlock Warlock</a>
                                </li>
                                <li>
                                <div class="hex">
                                        <div class="hex-background">
                                            <img class="clipped_img" src="img/classIcons/druid.png" alt="druid">  
                                        </div>
                                    </div>
                                    <a href="deckbuilder.php?class=druid&deckcode=AAECAZICCOTuA7CKBLWKBImLBKWNBO%2BkBKWtBISwBAvA7AOvgASwgASJnwSunwTanwTPrAT%2FvQSn1ATaoQWKugUA">Anacondra Ramp Druid</a>
                                </li>
                            </ul>
                        </div>
                        <div class="deck-export-container">
                            <p>Or just import your deck</p>
                            <input type="text" name="inputDeckCode" id="inputDeckCodeId" placeholder="Paste a deck code here"><label for="inputDeckCodeId"></label>
                            <input type="button" id="importDeckId" value="Import">
                        </div>
                    </div>
                    <div  class="classes-container">
                        <div class="class-selector">
                            <h1>Choose your Class</h1>
                            <ul>
                                <?php
                                foreach($classes as $class)
                                {
                                    if($class->name != "Neutral")
                                    {
                                        echo "<li><a href=\"deckbuilder.php?class=$class->slug\"><img src=\"img/classImg/".$class->slug.".png\" alt=\"\"><span>$class->name</span></a></li>";
                                    }
                                }
                                ?>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </main>
    <script src="js/importDeck.js"></script>

<?php
    include "footer.php";
?>