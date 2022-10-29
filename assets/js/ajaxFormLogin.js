$(document).ready(function() {

    $("#username-reg").keyup(function() {
        var input = $(this).val();
        var pattern = /^([a-zA-Z0-9\.\_\-])+$/;
        if (input.length < 4 || input.length > 20 || !pattern.test(input)) {
            $("#username-reg").removeClass("is-valid");
            $("#username-reg").addClass("is-invalid");

        } else {
            $("#username-reg").removeClass("is-invalid");
            $("#username-reg").addClass("is-valid");
        }

    });

    $("#email-reg").keyup(function() {
        var input = $(this).val();
        pattern = /^[a-zA-Z0-9._%-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,4}$/;
        if (!pattern.test(input)) {
            $("#email-reg").removeClass("is-valid");
            $("#email-reg").addClass("is-invalid");

        } else {
            $("#email-reg").removeClass("is-invalid");
            $("#email-reg").addClass("is-valid")
        }

    });

    $("#password-reg").keyup(function() {
        var input = $(this).val();
        pattern = /^[a-zA-Z0-9\_\*\-\+\!\?\,\:\;\.\xE0\xE8\xE9\xF9\xF2\xEC\x27]{8,20}/u;
        if (!pattern.test(input)) {
            $("#password-reg").removeClass("is-valid");
            $("#password-reg").addClass("is-invalid");

        } else {
            $("#password-reg").removeClass("is-invalid");
            $("#password-reg").addClass("is-valid")
        }

    });

    $("#password-reg1").keyup(function() {
        var input = $(this).val();
        pattern = /^[a-zA-Z0-9\_\*\-\+\!\?\,\:\;\.\xE0\xE8\xE9\xF9\xF2\xEC\x27]{8,20}/u;
        if (!pattern.test(input)) {
            $("#password-reg1").removeClass("is-valid");
            $("#password-reg1").addClass("is-invalid");

        } else {
            $("#password-reg1").removeClass("is-invalid");
            $("#password-reg1").addClass("is-valid")
        }

    });

});