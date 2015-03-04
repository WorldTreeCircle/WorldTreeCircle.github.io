$(document).ready(function () {
    //Move imgLogo from center of page to top
    $('#imgLogo').delay(600, function () {
        $(this).next().slideDown(600, function () {
            $(this).next().delay(600).fadeIn(600);
        });
    });

    //Enable butLoginSignup when email is entered
    //$('#txtEmail').keyup()

    //Check to see if email is registered
    $('#butLoginSignup').click(function loginOrSignup () {
        var email = $('#txtEmail').val();
        //Insert code to query database for email
        var emailIsValid = false;
        if (emailIsValid) {
            //ask for password
            console.log("email is valid");
        }
        else {
            $("<div class='form-group'><label class='control-label sr-only' for='txtPasswd'>Password:</label><input id='txtPasswd' name='Password' type='password' placeholder='Password' /></div>").insertAfter('#txtEmail');
            $("#txtPasswd").addClass("form-control text-center input-lg center-block");
            $('#butLoginSignup').text("Signup");
        }
    });
});