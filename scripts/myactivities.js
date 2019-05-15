$(document).ready(function () {
    $('.close').click(function () {
        $('.randomFun').hide();

    });
    $(document).keydown(function (e) {
        if (e.keyCode == 27) {
            $('.randomFun').hide();
        }
    });
    randEvent = {};
    newRandEvent();
});

function newRandEvent() {
    $.ajax({
        url: '../php/index.php',
        type: "post",
        data: "function=get_random_event",
        success: function (result) {
            console.log(result);
            randEvent.rid = result.rid;
            $('#titleRandom').html(result.name);
            $('#descRandom').html(result.description);
            $('#imageRadom').attr("src", "../random/" + result.rid + ".png");
            $('#saveRandom').prop("disabled", false);
        }
    });
}

function saveRandEvent() {
    if (randEvent.rid) {
        $.ajax({
            url: '../php/index.php',
            data: 'function=insert_random_event&rid=' + randEvent.rid,
            type: "post",
            success: function (rs) {
                window.location.reload(true);
            }
        })
    }
}

function deleteEvent(event) {
    if (confirm('Are you sure you want to delete this activity?')) {
        $.ajax({
            url: '../php/index.php',
            type: "post",
            data: "function=delete_event&eid=" + event,
            success: function () {
                window.location.reload(true);
            }
        });
    }
}

function unsubscribe(event) {
    if (confirm('Are you sure you want to unsubscribe from this activity?')) {
        $.ajax({
            url: '../php/index.php',
            type: "post",
            data: "function=unsubscribe&eid=" + event,
            success: function (result) {
                window.location.reload(true);
            },
            error: function () {
                console.log("error");
            }
        });
    }
}

function openRandomFun() {
    $('.randomFun').css("display", "flex");
}