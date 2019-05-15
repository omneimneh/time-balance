$(document).ready(function () {
    $.ajax({
        url: '../php/index.php',
        data: 'function=get_study_sessions',
        success: showSessions,
        type: "post"
    });
});

function showSessions(result) {
    console.log(result);
    if (!result.success) {
        console.log("wrong response");
        return;
    }
    var x = 100;
    var times = 0;
    var n = result.count;
    var w = 300;
    if (result.count == 0) {
        var interval = setInterval(function () {
            $("#container").append($("<img width='500px' src='../images/site.png' style='position: relative;'>"));
            $("#container").append($("<big class='idea'>Click the block above to start a study session<br>Start Building your tower by studying hard...<big>"));
            renderCrane(200);
            clearInterval(interval);
        });
    } else {

        var i = setInterval(function () {
            var rand = Math.random();
            if (rand > 0.5) {
                rand -= 0.5;
                rand *= 80;
            } else {
                rand *= -80;
            }
            var block = $("<div style='display: none; position: relative; right:" + rand + "px;'></div>");
            block.append($("<div class='show' name='info' style='position: absolute; float: left; display: none'><h1>#"
                + result.sessions[times].name + "</h1>" + "<big>"
                + result.sessions[times].date + "</big><br><b>"
                + intToTime(result.sessions[times].duration) + "</b></div>"));
            block.append($("<img  width='" + w + "px' src='../images/block2.png'>"));
            block.mouseover(function () {
                block.children('div').fadeIn();
                block.children("img").css("opacity", "0.2");
            });
            block.mouseout(function () {
                block.children('div').stop().hide();
                block.children("img").css("opacity", "1");
            });
            $('#container').append(block);
            block.toggle("drop");
            x *= 0.9;
            w = 300 - 100 + x;
            if (window.scrollTo) {
                window.scrollTo(0, 0);
            }
            times++;
            if (times >= n) {
                clearInterval(i);
                renderCrane(200);
            }
        }, 1000 / n);

    }
}


function renderCrane(height) {
    $('#container').append($("<div style='height:" + height + "px'></div>"));
    var div = $("<div style='position: relative; cursor: pointer; right:0px;'></div>");
    var add = $("<img width='200px' src='../images/block2.png'>");
    div.append(add);
    var img = $("<a href='timer.php' style='font-size: 18pt; font-weight: 600; text-decoration: underline; color: red; text-align: center; left: 0; top: 0; padding: 12px; position: absolute'><br><big >Add a new session</big><a>");
    div.append(img);
    img.hide();
    div.mouseover(function () {
        add.css("opacity", "0.2");
        img.fadeIn();
    });
    div.mouseout(function () {
        add.css("opacity", "1");
        img.stop().hide();
    });
    $('#container').append(div);
    div.slideDown();
    $('#container').append($("<canvas width='200' height='170' style='margin-bottom: -20px' id='crane'/>"));
    animate(div, $('#crane').get(0));
}

function animate(block, canvas) {
    var ini = 50;
    var x = ini;
    var speed = 0;
    var falling = true;
    var cxt = canvas.getContext('2d');
    cxt.lineWidth = 5;
    setInterval(function () {
        cxt.clearRect(0, 0, canvas.width, canvas.height);
        var tmp = x;
        cxt.beginPath();
        cxt.moveTo(100, 0);
        cxt.lineTo((-x * 0.8 + 100), 100);

        cxt.moveTo((-x * 0.8 + 100), 100);
        cxt.lineTo((-x * 0.8 + 150), 155);

        cxt.moveTo((-x * 0.8 + 100), 100);
        cxt.lineTo((-x * 0.8 + 50), 155);
        cxt.stroke();

        block.css("right", x + "px");
        block.css("transform", "rotateZ(" + x / 10 + "deg)");
        if (falling) {
            speed += 0.5;
            x -= speed;
        } else {
            speed -= 0.5;
            x -= speed;
        }

        if (x < 0 && tmp >= 0 || x > 0 && tmp <= 0) {
            falling = !falling;
        }

    }, 50);
}

function intToTime(int) {
    return (Math.floor(int / 3600) + "").padStart(2, '0')
        + ":" + (Math.floor(int / 60 % 60) + "").padStart(2, '0')
        + ":" + (int % 60 + "").padStart(2, '0');
}

String.prototype.padStart = function (paddingValue) {
    return String(paddingValue + this).slice(-paddingValue.length);
}