<?php
    include "functionality/functions.php";
    include "functionality/getMetadataApi.php";
    include "header.php";

    if(isset($_GET['class']))
    {
        $class = ucfirst($_GET['class']);
    }
    if(isset($_GET['deckCode']))
    {
        $_COOKIE['deckCode'] = $_GET['deckCode'];
        $_SERVER['REQUEST_URI'] = $_SERVER['REQUEST_URI']."&deckcode=".$_COOKIE['deckCode'];
    }
    $pagetitle = "Deck builder";
?> 
    <main class="<?php echo isset($_SESSION['user'])? "logged-in": "";?>">
        <div class="content-container">
            <div>
                <a id="hintId" class="info-button">?</a>
            </div>
            <div class = "filters-container">
                <nav>
                    <ul>
                        <li>
                            <span>Mana Cost</span>
                            <select name="manaSelection" id="manaSelectionId">
                                <?php
                                    printManaOptions(8, 'manaCost');
                                ?>
                            </select>
                        </li>
                        <li>
                            <span>Card Type</span>
                            <select name="cardTypeSelection" id="cardTypeSelectionId">
                                <?php
                                    printOptions($cardTypes, 'type');
                                ?>
                            </select>
                        </li>
                        <li>
                            <span>Minion Type</span>
                            <select name="minionTypeSelection" id="minionTypeSelectionId">
                                <?php
                                    printOptions($minionTypes, 'minionTypeId');
                                ?>
                            </select>
                        </li>
                        <li>
                            <span>Rarity</span>
                            <select name="raritySelection" id="rarirySelectionId">
                                <?php
                                    printOptions($rarities, 'rarityId');
                                ?>
                            </select>
                        </li>
                        <li><span>Keywords</span>
                            <select name="keywordSelection" id="keywordSelectionId">
                                <?php
                                    printOptions($keywords, 'keywordIds');
                                ?>
                            </select>
                        </li>
                        <li>
                            <input type="button" id="searchBtnId" value="Filter">
                        </li>
                    </ul>
                </nav>
            </div>
            <div class="cards-deck-container">
                <div class="deck-container">
                    <div class="deck-header" id="deckHeaderId">
                        <p id="cardsCountId">0/30</p>
                    </div>
                    <div class="deck-area" id="deckAreaId">
                    </div>
                    <div>
                        <input type="button" id="copyCodeId" value="Copy Deck Code">
                    </div>
                </div>
                <div class = "cards-container">

                    <h2><?php echo (ucfirst($class))?></h2>
                    <div class = "class-cards" id="classCardsId">
                    </div>
                    <h2>Neutral</h2>
                    <div class = "neutral-cards" id="neutralCardsId">
                    </div>
                </div>
            </div>
        </div>
    </main>
    <script src="js/setFiltersOptions.js"></script>
    <script src="js/deckManager.js"></script>
<?php
    include "footer.php";
?>