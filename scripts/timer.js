var tag;
var gtime;

function initTimer() {
    menu = document.getElementById('menu');
    login = document.getElementById('login_menu');
    updateClock();
    setInterval(updateClock, 1000);
    updateTimer();
    setInterval(updateTimer, 1000);
}

function start() {
    tag = prompt("Enter a Session Tag (Studying Math... e.g.)", "");
    if (tag == null) {
        return;
    } else if (tag == '') {
        alert("Please enter a tag!");
        return;
    }
    setTimeout(function () {
        var docElm = document.body;
        if (docElm.requestFullscreen) {
            docElm.requestFullscreen();
        } else if (docElm.mozRequestFullScreen) {
            docElm.mozRequestFullScreen();
        } else if (docElm.webkitRequestFullScreen) {
            docElm.webkitRequestFullScreen();
        } else if (docElm.msRequestFullscreen) {
            docElm.msRequestFullscreen();
        }
    }, 200);

    setTime();
    document.getElementById("button").innerHTML = "Stop and Save";
    document.getElementById("button").onclick = stopAndSave;
}

function updateTimer() {
    getTime(function (time) {
        time = new Date().getTime() / 1000 - time;
        gtime = time;
        var elem = document.getElementById('timer');
        var hours = time / 3600;
        var minutes = Math.floor(time / 60) % 60;
        var seconds = Math.floor(time) % 60;
        elem.innerHTML = (hours < 10 ?
            '0' + Math.floor(hours) : Math.floor(hours));
        elem.innerHTML += ':';
        elem.innerHTML += (minutes < 10 ?
            '0' + minutes : minutes);
        elem.innerHTML += ':';
        elem.innerHTML += (seconds < 10 ?
            '0' + seconds : seconds);
        document.getElementById("button").innerHTML = "Stop and Save";
        document.getElementById("button").onclick = stopAndSave;
    });
}

function toggleFullScreen() {
    var isInFullScreen = (document.fullscreenElement && document.fullscreenElement !== null) ||
        (document.webkitFullscreenElement && document.webkitFullscreenElement !== null) ||
        (document.mozFullScreenElement && document.mozFullScreenElement !== null) ||
        (document.msFullscreenElement && document.msFullscreenElement !== null);

    var docElm = document.body;
    if (!isInFullScreen) {
        if (docElm.requestFullscreen) {
            docElm.requestFullscreen();
        } else if (docElm.mozRequestFullScreen) {
            docElm.mozRequestFullScreen();
        } else if (docElm.webkitRequestFullScreen) {
            docElm.webkitRequestFullScreen();
        } else if (docElm.msRequestFullscreen) {
            docElm.msRequestFullscreen();
        }
    } else {
        if (document.exitFullscreen) {
            document.exitFullscreen();
        } else if (document.webkitExitFullscreen) {
            document.webkitExitFullscreen();
        } else if (document.mozCancelFullScreen) {
            document.mozCancelFullScreen();
        } else if (document.msExitFullscreen) {
            document.msExitFullscreen();
        }
    }
}

function unsetRecord() {
    $.ajax({
        url: "../php/index.php",
        data: "function=unset_study_start_time",
        type: "post"
    });
    document.getElementById("timer").innerHTML = "00:00:00";
    document.getElementById("button").innerHTML = "<img src='../images/play.png' width='16px'> Start";
    document.getElementById("button").onclick = start;
}

function stopAndSave() {
    var flag = false;
    if (gtime < 1 * 15) {
        alert("The minimum study time is 15 mins, you can't save this record!");
        flag = true;
    }
    if (confirm("Are you sure you want to proceed?")) {
        if (flag) {
            unsetRecord();
        } else {
            $.ajax({
                url: "../php/index.php",
                data: "function=get_study_start_time",
                type: "post",
                success: function (result) {
                    var timeElapsed = Math.floor(new Date().getTime()) / 1000 - Number(result);
                    addRecord(timeElapsed);
                }
            });
        }
    }
}

function addRecord(time) {
    $.ajax({
        url: "../php/index.php",
        data: "function=add_study_session&time=" + time + "&tag=" + tag,
        type: "post",
        success: function (result) {
            window.location.href = "study.php";
        },
        error: function () {
            console.log("Error");

        }
    });
}

function setTime() {
    $.ajax({
        url: "../php/index.php",
        data: "function=set_study_start_time&timer=" + Math.floor(new Date().getTime() / 1000) + "&tag=" + tag,
        type: "post",
        success: function (result) {
            console.log(result);
        }
    });
}

function getTime(onSuccess) {
    $.ajax({
        url: "../php/index.php",
        data: "function=get_study_start_time",
        type: "post",
        success: function (result) {
            if (result.fail) {
                return;
            }
            onSuccess(Number(result));
        }
    });
}

function updateClock() {
    var date = new Date();
    var minutes = date.getMinutes() >= 10 ? date.getMinutes() : '0' + date.getMinutes();
    var sec = date.getSeconds() >= 10 ? date.getSeconds() : '0' + date.getSeconds();
    document.getElementById('clock').innerHTML = date.getHours() + ":" + minutes + ":" + sec;
}

window.addEventListener('load', initTimer, false);