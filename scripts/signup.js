$(document).ready(function () {
    var onTextChange = function () {
        if ($('#password').val() == $('#re-password').val() && $('#password').val().length > 5) {
            if ($('#username').val() != '' && $('#email').val() != '') {
                $('#submit').prop('disabled', false);
                return;
            }
        }
        $('#submit').prop('disabled', true);
    }
    $('#username').bind('keyup keydown keypress DOMAttrModified propertychange', onTextChange);
    $('#email').bind('keyup keydown keypress DOMAttrModified propertychange', onTextChange);
    $('#password').bind('keyup keydown keypress DOMAttrModified propertychange', onTextChange);
    $('#re-password').bind('keyup keydown keypress DOMAttrModified propertychange', onTextChange);

    $('#signupForm').submit(function (ev) {
        ev.preventDefault();
        var values = $('#signupForm').serialize();
        values += "&function=sign_up";
        $.ajax({
            url: '../php/index.php',
            data: values,
            success: function (result) {
                if (result.success) {
                    var url_string = window.location.href;
                    var url = new URL(url_string);
                    var target = url.searchParams.get("target");
                    if (target != null) {
                        window.location = target;
                    } else {
                        window.location = "home.php";
                    }
                } else {
                    $('#invalid').fadeIn(400);
                }
            },
            type: "post"
        });
    });

});