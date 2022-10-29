$(document).ready(function() {

    $("#nome").keyup(function() {
        var input = $(this).val();
        
        if (input.length < 3 || input.length > 100) {
            $("#nome").removeClass("is-valid");
            $("#nome").addClass("is-invalid");

        } else {
            $("#nome").removeClass("is-invalid");
            $("#nome").addClass("is-valid");
        }

    });
    
    $("#email").keyup(function() {
        var input = $(this).val();
        pattern = /^[a-zA-Z0-9._%-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,4}$/;
        
        if (!pattern.test(input)) {
            $("#email").removeClass("is-valid");
            $("#email").addClass("is-invalid");

        } else {
            $("#email").removeClass("is-invalid");
            $("#email").addClass("is-valid");
        }

    });
    
    $("#testo").keyup(function() {
        var input = $(this).val();

        if (input.length < 3 || input.length > 500) {
            $("#testo").removeClass("is-valid");
            $("#testo").addClass("is-invalid");

        } else {
            $("#testo").removeClass("is-invalid");
            $("#testo").addClass("is-valid");
        }

    });
});