<?php
include_once 'db_connect_select.php';
include_once 'db_connect_insert.php';
include_once 'functions.php';

sec_session_start(); // Our custom secure way of starting a PHP session.

if (isset($_POST['Email'], $_POST['p'])) {//test for POST email and p variables
    $email = $_POST['Email'];
    $password = $_POST['p']; // The hashed password.

	$status = login($email, $password, $mysqli_select, $mysqli_insert);

    if ($status === true) {
        // Login success
        header('Location: ../ProfilePage.html');
    } else {
        // Login failed
        header('Location: ../login?error=' . $status);
    }
} else {
    // The correct POST variables were not sent to this page.
    echo 'Invalid Request';
}