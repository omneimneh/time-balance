<!DOCTYPE html>
<html lang="en">

<head>
	<link rel="icon" href="../logo.png" type="image/x-icon">
    <meta charset="UTF-8">
    <title>Time Balance - Activities</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script type="text/javascript" src="../scripts/jquery-3.3.1.js"></script>
    <script type="text/javascript" src="../scripts/global.js"></script>
    <script type="text/javascript" src="../scripts/activities.js"></script>
    <link rel="stylesheet" href="../styles/global.css">
    <link rel="stylesheet" href="../styles/activitiesStyle.css">
</head>

<body>

    <?php include '../templates/header.html';?>
    <?php

@session_start();
if (isset($_SESSION['uid'])) {

} else {
    header('Location: login.php?target=activities.php');
}

?>

    <div class="activities">
        <div class="findAcitivity" id="created_activities">
        </div>
        <div class="mapActivity" id="map"></div>
        <script src="https://maps.googleapis.com/maps/api/js?key=YOUR_API_KEY&callback=initMap" async
            defer></script>
    </div>

    <button onclick="openCreateActivity()" class="floatingButton">+</button>

    <?php include '../templates/footer.html';?>

    <script>
    </script>

</body>

</html>