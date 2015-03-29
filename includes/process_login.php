<?php
include_once 'db_connect_select.php';
include_once 'db_connect_insert.php';
include_once 'functions.php';

sec_session_start(); // Our custom secure way of starting a PHP session.

if (true) {//test for POST email and p variables
    $email = $_POST['email'];
    $password = $_POST['p']; // The hashed password.

    if (login($email, $password, $mysqli_select, $mysqli_insert) == true) {
        // Login success
        header('Location: ../ProfilePage.html');
    } else {
        // Login failed
        header('Location: ../login?error=1');
    }
} else {
    // The correct POST variables were not sent to this page.
    echo 'Invalid Request';
}