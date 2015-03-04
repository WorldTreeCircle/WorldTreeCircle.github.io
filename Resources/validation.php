<?php
/**This script queries the database for the given email and returns true if the email exists and false if the email does not exist */

$q = intval($_GET['q']);

$con = new mysqli('localhost','fourleaf_ValEmai','validate*Email!WTC','fourleaf_wrdp1');
/** check connection */
if ($con->connect_error) {
    die('Could not connect: ' . $con->connect_error);
}

$sql="SELECT * FROM wp_users WHERE user_email = '".$q."'";
$result = $con->query($sql);

if ($result->num_rows > 0) {
	echo true;
}
else {
	echo false;
}

$con->close();
?>