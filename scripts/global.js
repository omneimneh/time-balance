function init() {
    $('.moreOption').click(function () {
        if ($('.mobileOptions').css('display') == 'none') {
            $('.mobileOptions').slideDown(400);
        } else {
            $('.mobileOptions').stop().hide();
        }
    });
    $(document.body).click(function (ev) {
        if (!(isChild(ev.target, $('.moreOption').get(0)) ||
            isChild(ev.target, $('.mobileOptions').get(0)))) {
            $('.mobileOptions').stop().hide();
        }
    });
    setInterval(function () {
        var elems = document.getElementsByClassName("logo");
        for (var i = 0; i < elems.length; i++) {
            AnimateRotate(360, elems[i]);
        }
    }, 5000);
}

function AnimateRotate(angle, object) {
    // caching the object for performance reasons
    var $elem = $(object);

    // we use a pseudo object for the animation
    // (starts from `0` to `angle`), you can name it as you want
    $({ deg: 0 }).animate({ deg: angle }, {
        duration: 500,
        step: function (now) {
            // in the step-callback (that is fired each step of the animation),
            // you can use the `now` paramter which contains the current
            // animation-position (`0` up to `angle`)
            $elem.css({
                transform: 'rotate(' + now + 'deg)'
            });
        }
    });
}

function isChild(child, parent) {
    if (child == parent) {
        return true;
    } else {
        for (var i = 0; i < parent.children.length; i++) {
            var current = parent.children[i];
            if (isChild(child, current)) {
                return true;
            }
        }
    }
    return false;
}

var int;
function syncNotifications(freq, callback) {
    if (int) {
        clearInterval(int);
    }
    int = setInterval(function () {
        $.ajax({
            url: '../php/index.php',
            data: 'function=get_active_notifications',
            type: "post",
            success: function (result) {
                callback(result);
            },
            error: function (error) {
                console.log(error);
            }
        });
    }, freq);
}

syncNotifications(1000, function (result) {
    var elem = document.getElementsByClassName("dashboardOption");

    if (result.length == 0) {
        for (var i = 0; i < elem.length; i++) {
            elem[i].innerHTML = ("Dashboard");
        }
    } else {
        for (var i = 0; i < elem.length; i++) {
            elem[i].innerHTML = ("Dashboard (" + result.length + ")");
        }
    }
});

window.addEventListener('load', init, false);