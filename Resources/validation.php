<?php
/*This script queries the database for the given email and returns true if the email exists and false if the email does not exist */

$q = ltrim($_SERVER['QUERY_STRING'],"q=");

$con = new mysqli('localhost','fourleaf_wrdp1','kyRyNW3DA14DWY','fourleaf_wrdp1', 3306);
/* check connection */
if (mysqli_connect_errno()) {
    printf("Connect failed: %s\n", mysqli_connect_error());
    exit();
}

$sql="SELECT * FROM wp_users.fourleaf_wrdp1 WHERE user_email = " . $q;


if ($result = $mysqli->query($sql)) {
  /*Determine number of rows in result set */
  $row_count = $result->num_rows;

  if ($row_count > 0) {
  	/*Result set contains data -> return true*/
    echo 'true';
  }
  else {
    /*Result set is empty -> return false*/
  	echo 'false';
  }
  /*Close result set*/
  $result->close();
}

/*Close connection*/
$mysqli->close();
?>
