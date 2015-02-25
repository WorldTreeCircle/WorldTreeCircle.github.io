$(document).ready(function () {
    //Create table with login textbox
    var content = $("<table id=tblLogin><tr><td><input id='txtEmail' type='text' value='Email' /></td></tr></table>").addClass('loginTxt');
    //Move imgLogo from center of page to top
    $('#imgLogo').animate({ top: '25%' }, "slow", function () {
        $('#imgLogo').after(content); //insert hidden login textbox
        $('#tblLogin').fadeIn("slow"); //fade login textbox into view
    });

    //Clear default text on textbox focus
    $('input').focus(function () {
        console.log("txtEmail has focus.");
        $('#txtEmail').val('');
    })
});