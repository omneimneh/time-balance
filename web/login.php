<!DOCTYPE html>
<html lang="en">

<head>
	<link rel="icon" href="../logo.png" type="image/x-icon">
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <link rel="stylesheet" href="../styles/global.css">
    <link href="../styles/loginStyle.css" rel="stylesheet"></link>
    <script type="text/javascript" src="../scripts/jquery-3.3.1.js"></script>
    <script type="text/javascript" src="../scripts/global.js"></script>
    <script type="text/javascript" src="../scripts/login.js"></script>
    <title>Time Balance | LogIn</title>
</head>

<body>

<?php session_start();

if (isset($_GET['logout']) && $_GET['logout'] == true) {
    session_destroy();
    header('Location: login.php');
}

?>

    <?php include "../templates/header.html";?>


    <div class="bigContainer">
        <div>
            <div class="panelset">
                <h1 style="padding: 10px; font-size: 28pt; margin: 0px; padding: 0px">Time Balance</h1>
                <br>
                <?php

if (isset($_SESSION['uid'])) {
    echo "<big class='warning'>You're already signed in, you can switch to another account if you need to</big><br>";
}
?>
                <p style="color: gray; font-size: 14pt">Time Balance offers you unlimited free services:</p>
                <ul style="font-size: 13pt">
                    <li>Enter your sign in information</li>
                    <li>Make sure your password is at least 6 characters long</li>
                    <li>Visit
                        <a href="#">contact page</a> for support
                    </li>
                    <li>
                        <a href="home.php">Time Balance home page</a>
                    </li>
                </ul>
                <br>
                <p style="color: gray; font-size: 14pt">By signing up you agree to our:</p>
                <ul style="font-size: 13pt">
                    <li>
                        <a href="#">Term of policy</a>
                    </li>
                    <li>Time Balance Terms</li>
                </ul>
                <br>
                <br>
            </div>

        </div>
        <div class="login_container">

            <div style="display:flex; flex-direction: row; justify-content: space-between">
                <a class="leftTab">
                    <h2>Login</h2>
                </a>
                <a href="../web/signup.php" class="rightTab">
                    <h2>Sign up</h2>
                </a>
            </div>
            <div class="tab">
                <form id="loginForm" method="POST" class="form" action="" style="display: flex; flex-direction: column">
                    <small style="padding: 0px 10px 0px 10px; font-size: 10pt">Email</small>
                    <input required class="field" name="email" type="email" autocomplete="email">
                    <small style="padding: 0px 10px 0px 10px; font-size: 10pt">Password</small>
                    <input required class="field" name="password" type="password" autocomplete="current-password">
                    <small id="invalid" style="display: none; margin: 4px; color: red; font-size: 8pt">Wrong email or password</small>

                    <input class="submit" type="submit" value="Log in">
                </form>
            </div>
        </div>
    </div>

    <br>
    <br>
    <br>


    <?php include "../templates/footer.html";?>

</body>

</html>