
function renderNotification(n) {
    return div = $("<div class='notification'><h4>" + n.title + "</h4><p>" + n.message + "<br><br><a href='" + n.url + "'><button>See more</button></a></p><hr></div>");
}

function drawAxis(canvas) {
    canvas.height = canvas.offsetHeight;
    canvas.width = canvas.offsetWidth;
    height = canvas.height;
    width = canvas.width;
    var cxt = canvas.getContext('2d');
    cxt.lineWidth = 1;
    cxt.strokeStyle = 'black';
    cxt.fillStyle = 'black';
    cxt.shadowColor = 'black';
    cxt.shadowBlur = 0;
    cxt.globalAlpha = 1;


    cxt.beginPath();
    cxt.moveTo(1, height);
    cxt.lineTo(width, height);
    cxt.stroke();
    cxt.closePath();

    cxt.beginPath();
    cxt.moveTo(1, height);
    cxt.lineTo(1, 1);
    cxt.stroke();
    cxt.closePath();
}


function drawBlock1(canvas, h, color, next) {
    var time = 0;
    var i = 0;
    var interval = setInterval(function () {
        height = canvas.height;
        width = canvas.width;

        var cxt = canvas.getContext('2d');
        cxt.beginPath();
        cxt.fillStyle = color;
        cxt.rect(0.1 * width, height, 0.15 * width, -h * height * time / 100);
        cxt.closePath();
        cxt.fill();
        i++;
        time = Math.sqrt(i) * 22;
        if (time > 100) {
            clearInterval(interval);
            if (next) {
                next();
            }
        }
    }, 20);
}

function drawBlock2(canvas, h, color, next) {
    width = canvas.width;
    height = canvas.height;
    var time = 0;
    var i = 0;
    var interval = setInterval(function () {
        var cxt = canvas.getContext('2d');
        cxt.beginPath();
        cxt.fillStyle = color;
        cxt.rect(0.27 * width, height, 0.15 * width, -h * height * time / 100);
        cxt.closePath();
        cxt.fill();
        i++;
        time = Math.sqrt(i) * 22;
        if (time > 100) {
            clearInterval(interval);
            if (next) {
                next();
            }
        }
    }, 20);
}

function drawBlock3(canvas, h, color, next) {
    height = canvas.height;
    width = canvas.width;
    var time = 0;
    var i = 0;
    var interval = setInterval(function () {

        var cxt = canvas.getContext('2d');
        cxt.beginPath();
        cxt.fillStyle = color;
        cxt.rect(0.55 * width, height, 0.15 * width, -h * height * time / 100);
        cxt.closePath();
        cxt.fill();
        i++;
        time = Math.sqrt(i) * 22;
        if (time > 100) {
            clearInterval(interval);
            if (next) {
                next();
            }
        }
    }, 20);
}

function drawBlock4(canvas, h, color, next) {
    height = canvas.height;
    width = canvas.width;
    var time = 0;
    var i = 0;
    var interval = setInterval(function () {

        var cxt = canvas.getContext('2d');
        cxt.beginPath();
        cxt.fillStyle = color;
        cxt.rect(0.72 * width, height, 0.15 * width, -h * height * time / 100);
        cxt.closePath();
        cxt.fill();
        i++;
        time = Math.sqrt(i) * 22;
        if (time > 100) {
            clearInterval(interval);
            if (next) {
                next();
            }
        }
    }, 20);
}



function drawBlocks(canvas, h1, h2, h3, h4, c1, c2, c3, c4) {
    drawBlock1(canvas, h1, c1,
        function () {
            drawBlock2(canvas, h2, c2,
                function () {
                    drawBlock3(canvas, h3, c3,
                        function () { drawBlock4(canvas, h4, c4) })
                })
        });
}

function updateValue(range, label) {
    document.getElementById(label).innerHTML = range.value;
}

function submitHours() {
    var values = "function=set_planned_time&studyHours=" + $("#studyHours").val() + "&entertainHours=" + $("#entertainHours").val();
    $.ajax({
        url: "../php/index.php",
        type: "post",
        data: values,
        success: function (result) {
            window.location.reload(true);
        }
    });
    return false;
}

function getMonday() {
    var date = new Date();
    var day = date.getDay() || 7;
    if (day !== 1)
        date.setHours(-24 * (day - 1));
    var dd = date.getDate();
    var mm = date.getMonth() + 1; //January is 0!

    var yyyy = date.getFullYear();
    if (dd < 10) {
        dd = '0' + dd;
    }
    if (mm < 10) {
        mm = '0' + mm;
    }
    var value = dd + '/' + mm + '/' + yyyy;
    return value;
}

function fixGraph() {
    canvas.getContext('2d').clearRect(0, 0, canvas.width, canvas.height);
    drawAxis(canvas);
    drawBlocks(canvas, sh / 42, ash / 42, eh / 42, aeh / 42, 'dimgray', 'green', 'dimgray', 'orangered');
}

$(document).ready(function () {
    canvas = $("#graphCanvas").get(0);
    drawAxis(canvas);
    drawBlocks(canvas, sh / 42, ash / 42, eh / 42, aeh / 42, 'dimgray', 'green', 'dimgray', 'orangered');
    $('#hoursRange').submit(false);
    new ResizeSensor($('.graphDiv'), fixGraph);
    var changed = 0;
    syncNotifications(1000, function (result) {
        $('#notificationTitle').html("Notifications (" + result.length + ")");
        if (changed != result.length) {
            changed = result.length;
            $("#notifiactions").html('');
            result.forEach(function (element) {
                $("#notifiactions").append(renderNotification(element));
            });
        }
    });
});