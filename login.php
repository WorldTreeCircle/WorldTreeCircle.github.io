﻿<!DOCTYPE html>
<html lang="en">
<head>
    <!-- Set character set -->
    <meta charset="utf-8">

    <!-- Set viewport and scale (mobile friendly) -->
    <meta name="viewport" content="width=device-width, initial-scale=1">
    
    <!--Web Page Title-->
    <title>World Tree Circle</title>

    <!-- Web Page Icon -->
    <link rel="icon" href="images/WTC.gif" />

    <!-- Start Styles -->
    <link href="bootstrap-3.3.2-dist/css/bootstrap-theme.min.css" rel="stylesheet" />
    <link href="bootstrap-3.3.2-dist/css/bootstrap.min.css" rel="stylesheet" />
    <link rel="stylesheet" type="text/css" href="stylesheets/login.css" />
    <!-- End Styles -->

    <!-- jQuery -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.3/jquery.min.js"></script>

    <!-- Start JavaScript -->
    <script src="javascripts/loginScript.js" type="text/javascript"></script>
    <script src="bootstrap-3.3.2-dist/js/bootstrap.min.js"></script>
    <!-- End JavaScript -->
</head>
<body>
    <div id="main_content" class="container">
        <div class="row">
            <div class="col-xs-12 jumbotron" id="jumbotron">
                <img id="imgLogo" src="images/WTC.gif" class="img-responsive center-block" />
                <div id="divWTC" class="spacer50" hidden>
                    <h1 class="text-center">World Tree Circle</h1>
                </div>
                <form id="frmLogin" role="form" hidden>
                    <div id="userEmail" class="form-group">
                        <label class="control-label sr-only" for="txtEmail">Email:</label>
                        <input id='txtEmail' name='Email' type='email' placeholder='Email' class="form-control text-center input-lg center-block" />
                    </div>
                    <div id="frmButton" class="form-group">
                        <button type="button" id="butLoginSignup" class="btn-lg btn-success center-block text-center">Login or Signup</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</body>
</html>