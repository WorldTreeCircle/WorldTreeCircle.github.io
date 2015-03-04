<?php
/**This script queries the database for the given email and returns true if the email exists and false if the email does not exist */

$q = intval($_GET['q']);

$con = mysqli_connect('localhost','fourleaf_ValEmai','validate*Email!WTC','fourleaf_wrdp1');
if (!$con) {
    die('Could not connect: ' . mysqli_error($con));
}

mysqli_select_db($con,"ajax_demo");
$sql="SELECT * FROM wp_users WHERE user_email = '".$q."'";
$result = mysqli_query($con,$sql);

if ($result) {
	echo true;
}
else {
	echo false;
}

mysqli_close($con);
?>