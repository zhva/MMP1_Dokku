<?php
    include "functionality/functions.php";
    $pagetitle = "LogIn";
    if(isset($_SESSION['user']))
    {
        header("Location: index.php");
    }

    include "header.php";
?>
    <main>
        <div class="content-container">
            <div class="content-wrapper">
                <div class="from-login">
                    <?php
                        if(isset($_GET['wronglogin']))
                        {
                            echo "<p class='text-error'>User does not exist!</p>";
                        }
                        if(isset($_GET['wrongpass']))
                        {
                            echo "<p class='text-error'>Invalid password!</p>";
                        }
                        if(isset($_GET['authentfailed']))
                        {
                            echo "<p class='text-error'>You have entered wrong email or password!</p>";
                        }
                    ?>
                    <form action="functionality/userLogin.php" method="post">
                        <input type="email" name="email" id="email" placeholder="Email" autocomplete="email" required><label for="email"></label>
                        <div class="show-hide-pass">
                            <input type="password" name="password" id="passwordId" placeholder="Password" required><label for="passwordId"></label>
                        </div>
                        <input type="submit" name="signUp" id="signUpId" value="Sign In">
                        <label for="signUpId"></label>
                    </form>
                </div>
                <hr>
                <div class="signin">
                    <p>Don't have an account? <a href="register.php">Sign up</a></p>
                </div>
            </div>
        </div>
    </main>
    <script src="js/userRegistration.js"></script>
<?php
    include "footer.php";
?>