<!DOCTYPE html>
<html lang="en">

<head>
	<link rel="icon" href="../logo.png" type="image/x-icon">
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Time Balance | Study</title>
    <link rel="stylesheet" href="../styles/global.css">
    <link rel="stylesheet" href="../styles/studyStyle.css">
    <script type="text/javascript" src="../scripts/jquery-3.3.1.js"></script>
    <script type="text/javascript" src="../scripts/global.js"></script>
    <script type="text/javascript" src="../scripts/study.js"></script>
</head>

<body>
    <?php include '../templates/header.html';?>
    <?php

if (!isset($_SESSION['uid'])) {
    header('Location: login.php?target=study.php');
}

?>
        <img style="z-index: -1; position: fixed; top: 50px; left: 10px;" src="../images/cloud.png" alt="">
        <div class="container" id="container">
            <div class="ground"></div>
        </div>

        <?php include '../templates/footer.html';?>
</body>

</html>