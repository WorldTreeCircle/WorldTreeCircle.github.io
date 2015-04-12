<?php
	include_once 'includes/functions.php';

	sec_session_start();

	if (login_check($mysqli) == true) {
		$logged = 'in';
	} else {
		$logged = 'out';
	}
?>
<!DOCTYPE html>
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
	<script src="javascripts/forms.js" type="text/javascript"></script>
	<script src="javascripts/sha512.js" type="text/javascript"></script>
    <!-- End JavaScript -->
</head>
<body>
    <div id="main_content" class="container">
		<?php
			if(isset($_GET['error'])) {
				echo '<div class="alert alert-danger text-center" role="alert"><span class="glyphicon glyphicon-exclamation-sign" aria-hidden="true"></span><span class="sr-only">Error:</span>&nbsp' . $_GET['error'] . '</div>';
			}
			if(isset($_GET['msg'])) {
				if($_GET['msg'] == 1) {
					//Successful logout
					echo '<div class="alert alert-info text-center" role="alert"><span class="glyphicon glyphicon-exclamation-sign" aria-hidden="true"></span><span class="sr-only">Error:</span>&nbspYou have successfully logged out!</div>';
				}
				if($_GET['msg'] == 2) {
					//Successful register
					echo '<div class="alert alert-info text-center" role="alert"><span class="glyphicon glyphicon-exclamation-sign" aria-hidden="true"></span><span class="sr-only">Error:</span>&nbspYou have successfully registered!<br />Now you can log in!</div>';
				}
			}
		?>
        <div class="row">
            <div class="col-xs-12 jumbotron" id="jumbotron">
                <img id="imgLogo" src="images/WTC.gif" class="img-responsive center-block" />
                <div id="divWTC" class="spacer50" hidden>
                    <h1 class="text-center">World Tree Circle</h1>
                </div>
                <form id="frmLogin" action="includes/process_login.php" method="post" role="form" hidden>
                    <div id="userEmail" class="form-group">
                        <label class="control-label sr-only" for="txtEmail">Email:</label>
                        <input id='txtEmail' name='Email' type='email' placeholder='Email' class="form-control text-center input-lg center-block" />
					</div>
					<div id='frmPassword' class='form-group'>
						<input id='txtPassword' name='password' type='password' placeholder='Password' class='form-control text-center input-lg center-block' />
                    </div>
                    <div id="frmButton" class="form-group">
							<button type="button" id="butLogin" class="btn-lg btn-success center-block text-center" onclick="formhash(this.form, this.form.password);">Login</button>
							<a id="butRegister" class="btn-md btn-link pull-right text-center" href="register">Register</a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</body>
</html>
