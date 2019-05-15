$(document).ready(function () {
    $('.bgDiv').animate({ 'background-position-y': '0' }, 1000);
    $(document.body).animate({ 'opacity': '1' }, 1000);
    $('.sun').animate({ 'right': '300px', 'top': '50px' }, 1000);
    $("#subscribe").click(function () {
        $.ajax({
            url: '../php/index.php',
            data: 'function=subscribe_to_event&eid=' + findGetParameter('eid'),
            success: function (result) {
                console.log(result);
                window.location.reload(true);
            },
            type: "post"
        });
    });
});


function findGetParameter(parameterName) {
    var result = null,
        tmp = [];
    location.search
        .substr(1)
        .split("&")
        .forEach(function (item) {
            tmp = item.split("=");
            if (tmp[0] === parameterName) result = decodeURIComponent(tmp[1]);
        });
    return result;
}

function invite() {
    email = prompt("Enter the email address of the invited person", "");
    if (email) {
        if (/^.+\@+.*$/.test(email)) {
            sync();
            var eid = findGetParameter("eid");
            $.ajax({
                data: "function=invite&email=" + email + "&eid=" + eid,
                type: "post",
                url: "../php/index.php",
                success: function (result) {
                    console.log(result);

                    if (result.success) {
                        alert("The invite was successfuly sent.");
                    } else {
                        if (result.error == "self") {
                            alert("You can't send an invite to yourself!");
                        } else if (confirm("We couldn't find an account with this email, Do you want to invite this person to Time Balance via email?")) {
                            url = 'mailto:' + email + "?subject=Join me on Time Balance&body=Amazing features awaits, join me on http://www.-URL-.com/viewactivity?eid=" + eid;
                        }
                    }
                    now = true;
                },
                error: function () {
                }
            });
        } else {
            alert("Invalid email adress");
        }

    } else {

    }
}

var now = false;
var url = null;
var interval;

function sync() {
    interval = setInterval(function () {
        if (now && url) {
            window.open(url);
            clearInterval(interval);
            url = null;
        } else if (now) {
            clearInterval(interval);
        }
    }, 100);
}