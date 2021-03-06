﻿$(document).ready(function () {
    //Move imgLogo from center of page to top
    $('#imgLogo').delay(600, function () {
        $(this).next().slideDown(600, function () {
            $(this).next().delay(600).fadeIn(600);
        });
    });

    //Enable butLogin when email is entered
    //$('#txtEmail').keyup()

    //Navigate through signup process
    $('#btnPrev').click(function () {
        console.log("Signup Step is: " + $('#signupStep').contents());
        if ($('#signupStep').contents() == 'Create a Password') {
            console.log("Removing Password Step");
            $('#frmLogin').find('*').not('#userEmail, #frmButton').remove();
            $('#frmButton').empty().append('<button type="button" id="butLoginSignup" class="btn-lg btn-success center-block text-center">Login or Signup</button>');
        }
    });
});

function passwordStep() {
    //Remove Login/Signup button
    $('#butLoginSignup').fadeOut(300, function () { $(this).remove() });

    //Deactivate email box
    $('#txtEmail').attr('readonly', 'true');

    //Display Create a Password Title
    $("#frmLogin").prepend("<h3 id='signupStep' class='text-center'>Create a Password</h3>")
    //Display Password Boxes
    $("<div id='passwd1' class='form-group'><label class='control-label sr-only' for='txtPasswd1'>Password:</label><input id='txtPasswd1' name='Password1' type='password' placeholder='Password' /></div>").insertAfter('#userEmail');
    $("#txtPasswd1").addClass("form-control text-center input-lg center-block");

    $("<div id='passwd2' class='form-group'><label class='control-label sr-only' for='txtPasswd2'>Re-enter Password:</label><input id='txtPasswd2' name='Password2' type='password' placeholder='Re-enter Password' /></div>").insertAfter('#passwd1');
    $("#txtPasswd2").addClass("form-control text-center input-lg center-block");

    //Display Previous and Next buttons
    $("#frmButton").append("<ul class='pager'><li><a  id='btnPrev' href='#' class='btn-warning btn-large'>Previous</a></li><li><a href='#' class='btn-success btn-large'>Next</a></li></ul>");
}

function displayPasswordBox() {

}
