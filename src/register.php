<?php
    include "functionality/functions.php";
    $pagetitle = "Register";

    include "header.php";
?>
    <main>
        <div class="content-container">
            <div class="content-wrapper">
                <div class="register-form">
                    <form action="functionality/userRegistration.php" method="post">
                        <p>Please fill in this form to create an account</p>
                        <div id='alertMsgId'><?php if(isset($_SESSION["errormsg"])){ echo ("<p class='text-error'>" . $_SESSION['errormsg'] . "</p>"); }?></div>
                        <input type="text" name="login" id="loginId" placeholder="User name" required><label for="loginId"></label>
                        <input type="email" name="email" id="email" placeholder="Email" autocomplete="email" required><label for="email"></label>
                        <div class="show-hide-pass">
                            <input type="password" name="password" id="passwordId" placeholder="Password" minlength="8" required><label for="passwordId"></label>
                        </div>
                        <div class="show-hide-pass">
                            <input type="password" name="password-repeat" id="repeatPasswordId" placeholder="Repeat password" minlength="8" required><label for="repeatPasswordId"></label>
                        </div>
                        <input type="submit" name="signUp" id="signUpId" value="Sign Up">
                    </form>
                    <p>Welcome to the Hearthstone Deck Builder! Here you can build your deck for every Class. 
                       You don't need to be registred to build a Deck, but if you want to save the Deck you 
                       need to be logged in. Registration allows you to save your deck for later use, leave comments 
                       and give ratings.</p>
                </div>
                <hr>

                <div class="signin">
                    <p>Already have an account? <a href="login.php">Sign in</a></p>
                </div>
            </div>
        </div>
    </main>
    <script src="js/userRegistration.js"></script>
<?php
    include "footer.php";
?>