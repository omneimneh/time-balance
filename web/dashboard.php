<!DOCTYPE html>
<html lang="en">

<head>
	<link rel="icon" href="../logo.png" type="image/x-icon">
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Time Balance | Dashboard</title>
    <script type="text/javascript" src="../scripts/jquery-3.3.1.js"></script>
    <script type="text/javascript" src="../scripts/global.js"></script>
    <script type="text/javascript" src="../scripts/ResizeSensor.js"></script>
    <script type="text/javascript" src="../scripts/dashboard.js"></script>
    <link rel="stylesheet" href="../styles/global.css">
    <link rel="stylesheet" href="../styles/dashboardStyle.css">
</head>

<body>

    <?php include '../templates/header.html';?>
    <?php

if (!isset($_SESSION['uid'])) {
    header('Location: login.php');
}
$db = new DB();
$user = $db->get_user_with_id($_SESSION['uid']);
$sh = $user['studyHours'];
$eh = $user['entertainHours'];
$ash = $db->actual_study_hours($_SESSION['uid']);
$aeh = $db->actual_entertain_hours($_SESSION['uid']);

if (abs($ash - $aeh) > abs($sh - $eh) + 10 || abs($ash - $aeh) < abs($sh - $eh) - 10) {
    $db->notify($user['email'], "Overbalance", "Your time is not balanced according to your plan, you need to work harder to find the right balance!", "#graphCanvas", null);
}

if (isset($_GET['clear'])) {
    $db->dismiss_notifications($_SESSION['uid']);
    header('Location: dashboard.php');
}

?>

        <script type="text/javascript">
            var sh = <?php echo $sh; ?>;
            var eh = <?php echo $eh; ?>;
            var ash = <?php echo $ash; ?>;
            var aeh = <?php echo $aeh; ?>;
        </script>

        <div class="mainContainer">
            <div class="leftContainer">


                <div class="quickLinks" style="display: flex; flex-direction: row; justify-content: space-evenly">
                    <a style="text-decoration: none; padding: 12px; align-text: center;" href="study.php"><img width="150" height="150" src="../images/ic_study.png" alt=""><br><big>Study Section</big></a>
                    <a style="text-decoration: none; padding: 12px; align-text: center;" href="myactivities.php"><img width="150" height="150" src="../images/ic_entertainment.png" alt=""><br><big>Entertain Section</big></a>
                </div>

                <div class="graphDiv">
                    <h3 style="margin: 12px">This week results (since
                        <script type="text/javascript">document.write(getMonday());</script>):
                    </h3>
                    <hr>
                    <br>
                    <canvas onresize="fixGraph()" id="graphCanvas" class="graph"></canvas>
                    <br>
                    <div class="annotations">
                        <div class="annotation">
                            <div style="background-color: gray" class="color"></div>
                            <big>Hours Planned</big>
                        </div>
                        <div class="annotation">
                            <div style="background-color: green" class="color"></div>
                            <big>Hours of Studying</big>
                        </div>
                        <div class="annotation">
                            <div style="background-color: orangered" class="color"></div>
                            <big>Hours of Fun</big>
                        </div>
                    </div>

                </div>


                <form onsubmit="submitHours()" id="hoursRange" class="hoursRange" action="">
                    <h3>Planned Time</h3>
                    <hr>
                    <label for="studyHours">Studying hours per week:</label>
                    <b id="hoursLabel">
                        <?php echo $sh; ?>
                    </b>
                    <br>
                    <input id="studyHours" onchange="updateValue(this, 'hoursLabel')" step="1" name="studyHours" type="range" min="1" max="42"
                        value='<?php echo $sh; ?>'>
                    <br>
                    <label for="entertainHours">Entertainment hours per week:</label>
                    <b id="minutesLabel">
                        <?php echo $eh; ?>
                    </b>
                    <br>
                    <input id="entertainHours" onchange="updateValue(this, 'minutesLabel')" step="1" name="entertainHours" type="range" min="1"
                        max="42" value="<?php echo $eh; ?>">
                    <br>
                    <br>
                    <input class="saveButton" type="submit" value="Save">
                </form>
            </div>

            <div class="rightContainer">
                <h3 id="notificationTitle">Notifications</h3>
                <a style="text-decoration: none" href="dashboard.php?clear=true">Dismiss All</a>
                <hr>
                <div id="notifiactions">

                </div>
            </div>

        </div>

        <?php include '../templates/footer.html';?>

</body>

</html>