<?php
include('ProfileEnter.php');

// Starts MySQL connection and creates DB or table if needed.
$link = mysqli_connect("localhost", "root", "", "");
if ($link === false) {
    die ("ERROR: Could not connect. " . mysqli_connect_error());
}
mysqli_set_charset($link, "utf8");
$sql = "CREATE DATABASE IF NOT EXISTS users;
        USE users;
        CREATE TABLE IF NOT EXISTS profiles (
            id INTEGER NOT NULL AUTO_INCREMENT,
            fname TEXT NOT NULL,
            lname TEXT NOT NULL,
            email TEXT NOT NULL,
            password TEXT NOT NULL,
            pic TEXT NOT NULL,
            PRIMARY KEY (id)
        );
        CREATE UNIQUE INDEX email ON profiles(email);";
$result = mysqli_multi_query($link, $sql) or trigger_error($link->error."[$sql]");

// Makes an array and sends it to the object that will evaluate it and put it to the profile page
$form = array($_REQUEST['email'], $_REQUEST['password']);
$enter = new ProfileEnter($form, $link);
$enter->profilePage();
exit();
