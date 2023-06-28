<?php
    include "functionality/functions.php";
    $pagetitle = "Decks";
    if(!isset($_SESSION['user']))
    {
        header("Location: login.php");
    }

    include "header.php";
?>
    <main>
        <div class="content-container">
            <div class="content-wrapper" id="userDecksContainerId">
            </div>
        </div>
    </main>
    <script src="js/userDecksManager.js"></script>
<?php
    include "footer.php";
?>