<?php
    include "functionality/functions.php";
    $pagetitle = "LogOut";

    if(!isset($_SESSION['user']))
    {
        header("Location: index.php");
    }
    $pagetitle = "LogOut";
    if(isset($_POST['log_out']))
    {
        $_SESSION = array();
        $_COOKIE = array();
        session_set_cookie_params(0);
        setcookie('user', '', time() - 3600*24);
        setcookie(session_id(), '', time() - 3600*24);
        session_destroy();
        session_write_close();
        header("Location: index.php");
        exit;
    }

    include "header.php";
?>
    <main>
        <div  class="content-container">
            <div class="content-wrapper">
                <div class="logout-form">
                    <form method="post" action="logout.php">
                        <label for="log_outId">Do you want to logout?</label>
                        <input type="submit" value="Log Out" name="log_out" id="log_outId"><br>
                        <a href="index.php">Home page</a>
                    </form>
                    <img src="img/miss_you_frog.png" alt="miss you frog">
                </div>
            </div>
        </div>
    </main>
<?php
    include "footer.php";
?>