<?php
	ob_start();
    include_once 'includes/db_connect_select.php';
	include_once 'includes/functions.php';

	sec_session_start();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <!-- Set character set -->
    <meta charset="utf-8" />

    <title>World Tree Circle</title>

    <!-- Web Page Icon -->
    <link rel="icon" href="images/WTC.gif" />

    <!-- jQuery -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.3/jquery.min.js"></script>

    <!-- Start AngualrJS -->
    <script src="javascripts/angular.min.js"></script>
    <script src="javascripts/angular-touch.js"></script>

    <!-- Start Styles -->
    <link href="bootstrap-3.3.2-dist/css/bootstrap.min.css" rel="stylesheet" />
    <link href="bootstrap-3.3.2-dist/css/bootstrap-theme.min.css" rel="stylesheet" />

    <!--Start Style Sheet-->
    <link href="stylesheets/ProfileStyleSheet.css" rel="stylesheet" />

    <!--Start Java-->
    <script src="bootstrap-3.3.2-dist/js/bootstrap.min.js"></script>
    <script src="bootstrap-3.3.2-dist/js/npm.js"></script>

    <!--Do Not REMOVE!-->
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">

</head>


<body id="Body">
	<?php if (login_check($mysqli_select) == true) :?>
		<!-- User is logged in -- display profile page -->
		<div class="container-fluid">
				<div class="row">
					<div id="Header" class="col-xs-12">
						<h1>World Tree Circle <img src="images/WTC.gif" alt="World Tree Circle" style="width:50px;height:50px" /> </h1>

						<div class="pull-right inline" height="100%">
							<a href="includes/logout">Logout</a>
						</div>
					</div>
				</div>
				<div class="row">
					<div id="LeftColumn" class="hidden-xs col-sm-2">
						<div id="ProfilePicPanel" class="ProfilePicPanel">
							<img style="width:100%;height:100%" alt="Paws" src="images/Paws%20(Pic%20Example).jpeg" />
						</div>
						<br />
						<div id="ProfileBio" class="ProfileBio">
							<p>
								Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor
								incididunt ut labore et dolore magna aliqua.
							</p>
							<p>
								Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut
								aliquip ex ea commodo consequat.
							</p>
						</div>
						<br />
						<div id="ExtraStuff" class="ExtraStuff">
						Extra Stuff
						</div><br />
					</div>

					<div id="MainFeed" class="col-xs-12 col-sm-7">
						<h1>Central Feed:</h1>
						This is where the main feed would go.<br />

					</div>

					<div id="MessageCenterPanel" class="hidden-xs col-sm-3">
						<div id="QandAPanel" class="QandAPanel">
							<a href="Http://worldtreecircle.net/qa">Q and A</a>
						</div>
						<div id="ScavengerHuntPanel" class="ScavengerHuntPanel">
							Scavenger Hunt
						</div>
						<div id="CommunityPanel" class="CommunityPanel">
							Community
						</div>
						<div id="CharitySectionPanel" class="CharitySectionPanel">
							Charity
						</div>
						<div id="SunRayesPanel" class="SunRaysPanel">
							Sun Rays
						</div>
						<div id="AdsPanel" class="AdsPanel">
							Ads
						</div>
					</div>

				</div>
			</div>
	<?php else :
		/* User is not logged in -- Redirect to login page */
		header('Location: ../login?msg=3');
		endif; 
	?>
</body>

</html>
