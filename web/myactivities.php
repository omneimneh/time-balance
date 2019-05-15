<!DOCTYPE html>
<html lang="en">

<head>
	<link rel="icon" href="../logo.png" type="image/x-icon">
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <script type="text/javascript" src="../scripts/jquery-3.3.1.js"></script>
    <script type="text/javascript" src="../scripts/global.js"></script>
    <script type="text/javascript" src="../scripts/myactivities.js"></script>
    <link rel="stylesheet" href="../styles/global.css">
    <link rel="stylesheet" href="../styles/myactivitesStyle.css">
    <title>Time Balance | My Activities</title>
</head>

<body>
    <div class="randomFun">
        <div class="randomFunWindow">
        <img class="close" src="../images/close.png" alt="">
            <img id="imageRadom" width="200px" src="../images/ic_entertainment.png" alt="">
            <h2 id="titleRandom">Event title</h2>
            <p id="descRandom">Event description</p>
            <div>
                <button disable onclick="saveRandEvent()" id="saveRandom">Save as private event</button>
                <button onclick="newRandEvent()" id="dismissRandom">Doesn't seem fun to me</button>
            </div>
        </div>
    </div>
    <?php include '../templates/header.html';?>
    <?php if (!isset($_SESSION['uid'])) {
    header('Location: login.php?target=myactivities.php');
}
?>
    <div id="container" class="container">

        <div style="display: flex; flex-direction: column; justify-content: center; align-items: center" class="event">
            <a href="createactivity.php">
                <img src="../images/add.png">
            </a>
            <h2>Create an Activity</h2>
        </div>
        <div style="display: flex; flex-direction: column; justify-content: center; align-items: center" class="event">
            <a href="activities.php">
                <img src="../images/find.png">
            </a>
            <h2>Find activities</h2>
        </div>
        <div style="display: flex; flex-direction: column; justify-content: center; align-items: center" class="event">
            <img onclick="openRandomFun()" id="random" src="../images/random.png">
            <h2>Random Fun</h2>
        </div>
        <?php

$db = new DB();
include '../php/Event.php';
$result = $db->get_subscribed_events($_SESSION['uid']);
while ($row = $result->fetch(PDO::FETCH_ASSOC)) {
    $event = new Event($row['eid'], $row['name'], $row['description'], 'someone', $row['date'], $row['image']);
    echo $event->get();
}

?>


    </div>



    <?php include '../templates/footer.html';?>


</body>

</html>