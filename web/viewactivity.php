<!DOCTYPE html>
<html lang="en">

<head>
	<title>%TITLE%</title>
	<link rel="icon" href="../logo.png" type="image/x-icon">
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<link rel="stylesheet" type="text/css" href="../styles/global.css">
	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
	<script type="text/javascript" src="../scripts/jquery-3.3.1.js"></script>
	<script type="text/javascript" src="../scripts/global.js"></script>
	<script type="text/javascript" src="../scripts/viewactivity.js"></script>
	<link rel="stylesheet" href="../styles/viewactivityStyle.css">

	<body>
		<?php include '../templates/header.html';?>

		<?php
@session_start();
$db = new DB();
if (!isset($_SESSION['uid'])) {
    $eid = $_GET['eid'];
    header("Location: login.php?target=viewactivity.php?eid=$eid");
} else {
    $event = $db->get_event($_GET['eid']);
    if (!$db->is_allowed($_SESSION['uid'], $_GET['eid'])) {
        die('This event does not exist or was deleted!');
    }
}

$buffer = ob_get_contents();
ob_end_clean();

$buffer = str_replace("%TITLE%", "Time Balance | " . $event['name'], $buffer);
echo $buffer;

?>


			<div class="bgDiv"></div>
			<img class="sun" width="200px" height="200px" src="../images/ic_sun.png">
			<div class="container">
				<img class="eventImage" width="200px" height="200px" src="<?php

if ($event['image']) {
    echo $event['image'];
} else {
    echo '../images/ic_entertainment.png';
}
?>" alt="">
				<div>
					<big class="eventTitle">
						<?php echo $event['name']; ?>
					</big>
				</div>
				<small>Created by `<?php

if ($username = $db->get_user_with_id($event['uid'])['email']) {
    echo $username;
} else {
    echo "Unkown User";
}
?>`
				</small>
				<br>
				<div style="display: flex; flex-direction: row; justify-content: space-evenly" class="eventDescription">
					<div>
						<i style="font-size:24px" class="fa fa-map-marker"></i>
						<a style="text-decoration: none; margin: 4px; color: black" href='<?php echo "https://www.google.com/maps/?q=" . $event['latitude'] . "," . $event['longitude']; ?>'>
							Check Location
						</a>
					</div>
					<div>
						<i style="font-size: 24px" class="fa fa-share-alt"></i>
						<a onclick="invite()" style="text-decoration: none; margin: 4px; color: black; cursor: pointer">Invite Others</a>
					</div>
				</div>

				<br>

				<div class="eventDescription">
					<big>
						<b>Start Time:</b>
					</big>
					<big>
						<?php echo date('Y-m-d H:i:s', strtotime($event['date'])); ?>
					</big>
					<br>
					<big>
						<b>Duration:</b>
					</big>
					<big>
						<?php echo DB::intToTime($event['duration']); ?>
					</big>
				</div>

				<p class="eventDescription">
					<?php echo $event['description']; ?>
				</p>

<?php
if ($db->is_subscribed($_GET['eid'], $_SESSION['uid'])) {
    echo "<small style='color: red'>You are Subscribed to this event</small>";
}
?>

				<button <?php
if ($db->is_subscribed($_GET['eid'], $_SESSION['uid'])) {
    echo 'disabled';
}
?> id="subscribe" class="pressActivity">Subscribe for this Event</button>
			</div>
			<?php include '../templates/footer.html';?>

	</body>

</html>