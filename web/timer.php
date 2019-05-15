<html xmlns="http://www.w3.org/1999/xhtml">

<head>
	<link rel="icon" href="../logo.png" type="image/x-icon">
    <title>Time Balance | Focus</title>
    <link rel="stylesheet" href="../styles/global.css">
    <link rel="stylesheet" href="../styles/timerStyle.css">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script type="text/javascript" src="../scripts/jquery-3.3.1.js"></script>
    <script type="text/javascript" src="../scripts/global.js"></script>
    <script type="text/javascript" src="../scripts/timer.js"></script>
</head>

<body>
    <div class="container">
        <h1 id="timer" class="timer">00:00:00</h1>
        <button class="b" id="button" onclick="start();"><img src="../images/play.png" width="16px"> Start</button>
    </div>
    <?php include "../templates/header.html";?>
    <?php if (!isset($_SESSION['uid'])) {
    header('Location: login.php?target=timer.php');
}?>
    <br>
    <img class="fullscreen" style="margin-left: 10px; cursor: pointer" onclick="toggleFullScreen()" width="25px" src="../images/fullscreen.png" alt="">
    <div class="clock">
        <h2 id="clock">00:00:00</h2>
    </div>
    <br>
    <br>
    <br>
    <br>
    <br>
    <?php include "../templates/footer.html";?>

</body>

</html>