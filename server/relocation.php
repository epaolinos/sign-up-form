<?php

/**
 * Profile opens through this file so that a user doesn't need to resend form on switching language.
 * It has independent access to MySQL, getting info with profile ID and e-mail (for better protection).
 */

// Connects to MySQL and gets the info
$link = mysqli_connect("localhost", "root", "", "");
if ($link === false) {
    die("ERROR: Could not connect." . mysqli_connect_error());
}
mysqli_set_charset($link, "utf8");
$useQuery = "USE users;";
$link->query($useQuery);
$getQuery = "SELECT * from profiles WHERE id = '{$_GET['id']}' AND email = '{$_GET['email']}';";
$result = $link->query($getQuery) or trigger_error($link->error."[$getQuery]");
$resArray = $result->fetch_array(MYSQLI_NUM);

// Sets variables that requires profile.html
$fname = $resArray[1];
$lname = $resArray[2];
$email = $resArray[3];
$pic = $resArray[5];
require_once('../client/profile.html');
exit();