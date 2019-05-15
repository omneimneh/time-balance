function initMyActivities(pos) {
    var params = "function=get_public_events&longitude=" + pos.lng + "&latitude=" + pos.lat;
    $.ajax({
        url: "../php/index.php",
        data: params,
        success: function (result) {
            $("#created_activities").html("");
            var first = true;
            if (result.success) {
                result.events.forEach(function (element) {
                    var view = generateDomEvent(element.eid, element.name, element.date, element.description, element.longitude, element.latitude, element.image);
                    $("#created_activities").append(view);
                    first = false;
                });
                if (first) {
                    $("#created_activities").html($("<br><h2 style='font-weight: normal; width: 100%; text-align: center;'>No Events Found!</h2>"));
                }
            }
        },
        error: function () {
            console.log("error");
        },
        type: "post"
    });
}

function generateDomEvent(eid, name, date, desc, lng, lat, image) {
    var article = $("<article name='event' class='event'></article>");
    var outerDiv = $("<div style='flex: 1; flex-direction: row; display: flex'>");
    /*if (image) {
        outerDiv.append($("<img style='align-self: center' src='../uploads/" + image + "'width='100px' height='100px'/>"));
    } else {
        outerDiv.append($("<img style='align-self: center' src='../images/ic_entertainment.png' width='100px' height='100px'/>"));
    }*/
    var innerDiv = $("<div style='flex: 1'></div>");
    var header = $("<header></header>");
    header.append($("<h1 style='margin: 1px'>" + htmlEntities(name) + "</h1>"));
    header.append($("<small style='font-weight: bold; color: green'>" + formatDate(date) + "</small>"));
    innerDiv.append(header);
    innerDiv.append($("<p class='eventDesc'><small class= 'eventDesc'>" + htmlEntities(desc) + "</small></p>"));
    var footerDiv = $("<div style='position: relative; right: 0; display: flex; flex-direction: row; justify-content: flex-end'></div>");
    footerDiv.append($("<button onclick=\"confirmLink('admin.php?action=delete_event&eid=" + eid + "')\" class='pressActivity' height='20px'>Supress</button>"));
    footerDiv.append($("<a href = 'viewactivity.php?eid=" + eid + "'><button class='pressActivity'>See More</button></a>"));
    innerDiv.append(footerDiv);
    outerDiv.append(innerDiv);
    article.append(outerDiv);
    return article;
}

function htmlEntities(str) {
    return String(str)
        .replace(/&/g, "&amp;")
        .replace(/</g, "&lt;")
        .replace(/>/g, "&gt;")
        .replace(/"/g, "&quot;");
}

function openCreateActivity() {
    window.location = "createactivity.php";
}

function formatDate(date) {
    return date.substring(0, 10) + " at " + date.substring(11, 16);
}

$(document).ready(function () {
    initMyActivities({ lat: 0, lng: 0 });
});


function confirmLink(link) {
    if (confirm("Are you sure you want to preceed?")) {
        window.location.href = (link);
    }
}