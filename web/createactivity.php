<!DOCTYPE html>
<html lang="en">

<head>
	<link rel="icon" href="../logo.png" type="image/x-icon">
	<title>Time Balance | Create Activity</title>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<script type="text/javascript" src="../scripts/jquery-3.3.1.js"></script>
	<script type="text/javascript" src="../scripts/global.js"></script>
	<script type="text/javascript" src="../scripts/createactivity.js"></script>
	<link rel="stylesheet" type="text/css" href="../styles/global.css">
	<link rel="stylesheet" href="../styles/createactivity.css">

	<body>
		<?php include '../templates/header.html';?>
		<?php $db = new DB();

if (!isset($_SESSION['uid'])) {
    header('Location: login.php?target=createactivity.php');
}

?>

		<div class="bgDiv"></div>
		<img class="sun" width="200px" height="200px" src="../images/ic_sun.png">
		<form enctype="multipart/form-data" onsubmit="submitForm(event)" name="form" id="form" action="../php/index.php" method="POST"
		 class="container">
			<img onclick="openImageChooser()" id="eventImage" class="eventImage" width="200px" height="200px" src="../images/ic_entertainment.png"
			 alt="">
			<div>
				<input name="name" id="eventTitle" required placeholder="Event Title" type="text" class="eventTitle">
			</div>
			<br>
			<div>
				<b>Select type:&nbsp&nbsp</b>
				<select name="type" id="eventType">
					<option value="private">Private</option>
					<option value="public">Public</option>
				</select>
			</div>
			<br>
			<div border="0" style="text-align: center; min-width: 0;" class="eventDescription">

				<label for="startTime" style="flex: 1">
					<b>Start Time:&nbsp;</b>
				</label>
				<input name="date" style="width: 120px" id="startTime" required style="flex: 1" type="date">
				<input name="time" style="width: 120px" id="time" required style="flex: 1" type="time">
				<br>
				<br>
				<label for="hours" style="flex: 1">
					<b>&nbsp;Duration:&nbsp;</b>
				</label> hrs:
				<input required name="hours" id="hours" min="0" max="720" style="width: 80px" type="number"> mins:
				<input required name="minutes" id="minutes" value="00" min="0" max="59" style="width: 80px" type="number">

			</div>
			<br>
			<textarea name="description" id="eventDescription" required placeholder="Write your description here.." class="eventDescriptionX"></textarea>
			<h2>Choose a location:</h2>
			<div class="eventDescription" style="height: 500px; margin: 10px" id="map">
			</div>
			<script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyCaR7MZfGnQ4_cj8NIPCDg50rPH8Tgd0-g&callback=mapInit" async
			 defer></script>

			<input type="submit" name="submit" id="submitActivity" class="pressActivity" value="Save this Event">
		</form>
		<?php include '../templates/footer.html';?>
	</body>

</html>