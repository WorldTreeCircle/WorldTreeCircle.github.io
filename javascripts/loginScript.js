$(document).ready(function () {
    //Create table with login textbox
    var content = "<tr colspan='2'><td><input id='txtEmail' name='Email' type='text' value='Email' /></td></tr><tr><td colspan='2'><button><h3>Login or Signup</h3></button></td></tr>";
    //Move imgLogo from center of page to top
    $('#imgLogo').delay(500).animate({ top: '25%' }, "slow", function () {
        $('#sub_content').fadeIn("slow"); //fade login form into view
    });

    //Clear default text on textbox focus
    $("input[type=text]").focus(function () {
        if(this.value == this.name) {
            $(this).val('');
        }
    })

    //Check to see if email is registered
    $('#butLoginSignup').click(function () {

        //Insert code to query database for email

    })
});