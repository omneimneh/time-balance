<!DOCTYPE html>
<html lang="en">

<head>
	<link rel="icon" href="../logo.png" type="image/x-icon">
    <title>Time Balance | SignUp</title>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../styles/global.css">
    <link rel="stylesheet" href="../styles/signupStyle.css">
    <script type="text/javascript" src="../scripts/jquery-3.3.1.js"></script>
    <script type="text/javascript" src="../scripts/global.js"></script>
    <script type="text/javascript" src="../scripts/signup.js"></script>

</head>

<body>
    <?php include "../templates/header.html";?>

        <div class="bigContainer">
            <div>
                <div class="panelset">
                    <h1 style="padding: 10px; font-size: 28pt; margin: 0px; padding: 0px">Time Balance</h1>
                    <br>
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
                    <a href="../web/login.php" class="leftTab">
                        <h2>Login</h2>
                    </a>
                    <a class="rightTab">
                        <h2>Sign up</h2>
                    </a>
                </div>
                <div class="tab">
                    <form id="signupForm" method="POST" class="form" action="" style="display: flex; flex-direction: column">
                        <small style="padding: 0px 10px 0px 10px; font-size: 10pt">Username</small>
                        <input value="<?php if (isset($_POST['username'])) {
    echo $_POST['username'];
}
?>" id="username" class="field" name="username"
                            type="text" autocomplete="username">
                        <small style="padding: 0px 10px 0px 10px; font-size: 10pt">Email</small>
                        <input value="<?php if (isset($_POST['email'])) {
    echo $_POST['email'];
}
?>" id="email" class="field" name="email" type="email"
                            autocomplete="email">
                        <small value="<?php if (isset($_POST['username'])) {
    echo $_POST['username'];
}
?>" style="padding: 0px 10px 0px 10px; font-size: 10pt">Password</small>
                        <input id="password" class="field" name="password" type="password" autocomplete="new-password">
                        <small style="padding: 0px 10px 0px 10px; font-size: 10pt">Re-enter Password</small>
                        <input id="re-password" class="field" type="password" autocomplete="new-password">
                        <small id="invalid" style='display: none; margin: 4px; color: red; font-size: 8pt'>Email already exists!</small>

                        <input id="submit" disabled class="submit" type="submit" value="Sign up">
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