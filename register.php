<?php
include_once 'includes/register.inc.php';
include_once 'includes/functions.php';
?>
<!DOCTYPE html>
<html>
    <head>
        <!-- Set character set -->
    <meta charset="utf-8">

    <!-- Set viewport and scale (mobile friendly) -->
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!--Web Page Title-->
    <title>World Tree Circle | Register</title>

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
    <script type="text/JavaScript" src="javascripts/sha512.js"></script>
    <script type="text/JavaScript" src="javascripts/forms.js"></script>
    </head>
    <body>
		<div id="main_content" class="container">
			<!-- Registration form to be output if the POST variables are not
			set or if the registration script caused an error. -->
			<div class="row">
				<div class="col-xs-12 jumbotron text-center" id="jumbotron">
					<img id="imgLogo" src="images/WTC.gif" class="img-responsive center-block" />
					<h1 class="spacer50">Register with us</h1>
					<?php
					if (!empty($error_msg)) {
						echo '<div class="alert alert-danger text-center" role="alert"><span class="glyphicon glyphicon-exclamation-sign" aria-hidden="true"></span><span class="sr-only">Error:</span>&nbsp' . $error_msg . '</div>';
					}
					?>
					<form action="<?php echo esc_url($_SERVER['PHP_SELF']); ?>" method="post" name="registration_form" role="form">
						<div class="form-group">

							<label class="control-label sr-only" for="txtUsername">Username:</label>
							<input id='txtUsername' name='username' type="email" placeholder='Username' class="form-control text-center input-lg center-block" />
						</div>
						<div class="form-group">
							<label class="control-label sr-only" for="txtEmail">Email:</label>
							<input id='txtEmail' name='Email' type='Email' placeholder='Email' class="form-control text-center input-lg center-block" />
						</div>
						<div class="form-group">
							<input id='txtPassword' name='password' type='password' placeholder='Password' class='form-control text-center input-lg center-block' />
						</div>
						<div class="form-group">
							<input id='txtConfirmPassword' name='confirmpwd' type='password' placeholder='Confirm Password' class='form-control text-center input-lg center-block' />
						</div>
						<div class="form-group">
							<button type="button" id="butLogin" class="btn-lg btn-success center-block text-center" onclick="return regformhash(this.form, this.form.username, this.form.Email, this.form.password, this.form.confirmpwd);">Register</button>
						</div>
						<div class="form-group">
							<a class="btn-md btn-link pull-left text-center" href="login">Login</a>
						</div>

					</form>
				</div>
			</div>
		</div>
    </body>
</html>
