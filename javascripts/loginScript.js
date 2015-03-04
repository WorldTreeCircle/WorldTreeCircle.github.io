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
        //Query database for email
        if (window.XMLHttpRequest) {
            // code for IE7+, Firefox, Chrome, Opera, Safari
            xmlhttp = new XMLHttpRequest();
        } else {
            // code for IE6, IE5
            xmlhttp = new ActiveXObject("Microsoft.XMLHTTP");
        }
        xmlhttp.onreadystatechange = function () {
            if (xmlhttp.readyState == 4 && xmlhttp.status == 200) {
                console.log("response = " + xmlhttp.response);
                if (xmlhttp.responseText == true) {
                    //ask for password
                    $("<div class='form-group'><label class='control-label sr-only' for='txtPasswd'>Password:</label><input id='txtPasswd' name='Password' type='password' placeholder='Password' /></div>").insertAfter('#txtEmail');
                    $("#txtPasswd").addClass("form-control text-center input-lg center-block");
                    $('#butLoginSignup').text("Login");
                }
                else {
                    //Display Signup information
                    $("<div class='form-group'><label class='control-label sr-only' for='txtPasswd'>Password:</label><input id='txtPasswd' name='Password' type='password' placeholder='Password' /></div>").insertAfter('#txtEmail');
                    $("#txtPasswd").addClass("form-control text-center input-lg center-block");
                    $('#butLoginSignup').text("Signup");
                }
            }
        }
        xmlhttp.open("GET", "resources/validation.php?q=" + $('#txtEmail').val(), true);
        xmlhttp.send();
            
   });
});