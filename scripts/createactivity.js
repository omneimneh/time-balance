input = null;
map = null;
marker = null

function mapInit() {
  map = new google.maps.Map(document.getElementById("map"), {
    center: { lat: 33.8938, lng: 35.5018 },
    zoom: 8.5
  });
  getLocation();
  google.maps.event.addListener(map, "click", function (event) {
    //Get the location that the user clicked.
    var clickedLocation = event.latLng;
    //If the marker hasn't been added.
    if (!marker) {
      //Create the marker.
      marker = new google.maps.Marker({
        position: clickedLocation,
        map: map,
        draggable: true //make it draggable
      });
      //Listen for drag events!
      google.maps.event.addListener(marker, "dragend", function (event) {
        markerLocation();
      });
    } else {
      //Marker has already been added, so just change its location.
      marker.setPosition(clickedLocation);
    }
    //Get the marker's location.
    markerLocation();
  });
}

function openImageChooser() {
  input.click();
}

function putImage() {
  var file = input.files[0];
  var reader = new FileReader();
  reader.onloadend = function () {
    image = document.getElementById("eventImage");
    image.src = reader.result;
  };
  if (file) {
    reader.readAsDataURL(file);
  }
}

function markerLocation() {
  //Get location.
  var currentLocation = marker.getPosition();
  loc = currentLocation;
  console.log(loc);
}

function blank(str) {

  console.log(!/\S/.test(str));
  return !/\S/.test(str);
}

function toSeconds(h, m) {
  return h * 3600 + m * 60;
}

$(document).ready(function () {
  $(".bgDiv").animate({ "background-position-y": "0" }, 1000);
  $(document.body).animate({ opacity: "1" }, 1000);
  $(".sun").animate({ right: "300px", top: "50px" }, 1000);
  input = document.createElement("input");
  func = document.createElement("input");
  lng = document.createElement("input");
  lat = document.createElement("input");
  func.name = "function";
  lng.name = "longitude";
  lat.name = "latitude";
  input.type = "file";
  input.name = "image";
  input.accept = "image/png";
  input.onchange = putImage;
  f = document.getElementById("form");
  f.appendChild(input);
  f.appendChild(func);
  f.appendChild(lng);
  f.appendChild(lat);
  $(input).hide();
  $(func).hide();
  $(lng).hide();
  $(lat).hide();
});

function submitForm(ev) {
  func.value = "insert_event";
  if (!marker
    || blank($('#eventTitle').val())
    || blank($("#eventDescription"))
    || !($("#startTime").val())
    || !($("#time").val())
    || !($("#hours").val())
    || !($("#minutes").val())
  ) {
    ev.preventDefault();
    alert("Please choose your event location!");
    return false;
  } else {
    markerLocation();
    lng.value = loc.lng();
    lat.value = loc.lat();
    console.log("should continue");
    return true;
  }
}



function getLocation() {
  if (navigator.geolocation) {
    navigator.geolocation.getCurrentPosition(setPos);
  } else {
    console.log("Geolocation is not supported by this browser.");
  }
}

function setPos(position) {
  var mapPos = {
    lng: position.coords.longitude,
    lat: position.coords.latitude
  };
  map.setCenter(mapPos);
}