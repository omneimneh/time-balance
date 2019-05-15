$(document).ready(function () {
    $('#loginForm').submit(function (ev) {
        ev.preventDefault();
        var values = $('#loginForm').serialize();
        values += "&function=sign_in";
        $.ajax({
            url: '../php/index.php',
            data: values,
            success: function (result) {
                if (result.success) {
                    var url_string = window.location.href;
                    try {
                        var url = new URL(url_string);
                        var target = null;
                        if (url.searchParams) {
                            target = url.searchParams.get("target");
                        } else {
                            target = 'dashboard.php';
                        }
                    } catch (any) {
                        console.log(any);
                    }

                    if (target != null) {
                        window.location.href = target;
                    } else {
                        window.location.href = "dashboard.php";
                    }
                } else {
                    $('#invalid').fadeIn(400);
                }
            },
            type: "post"
        });
    });
});