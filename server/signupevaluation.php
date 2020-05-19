<?php
include("ProfileMaker.php");

// Makes MySQL connection and creates DB and table if not exists.
$link = mysqli_connect("localhost", "root", "", "");
if ($link === false) {
    die("ERROR: Could not connect." . mysqli_connect_error());
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

// Makes a form array with all the user data, sends it to ProfileMaker object and makes a profile
$pic = imageEval();
$form = array($_REQUEST["first_name"], $_REQUEST["last_name"], $_REQUEST["email"],
    $_REQUEST["password"], $_REQUEST["password_confirm"], $pic);
$profileMaker = new ProfileMaker($form, $link);
$profileMaker->makeProfile();
exit();

// Evaluates the pic, saves it to /server/userpics/ and returns it's name
function imageEval() {
    // If no photo returns standard pic's name
    if (empty($_FILES['file']['name'])) {
        return "standard.jpg";
    }

    $filePath  = $_FILES['file']['tmp_name'];

    // Check file type for security reasons
    $fi = finfo_open(FILEINFO_MIME_TYPE);
    $mime = (string) finfo_file($fi, $filePath);
    if (strpos($mime, 'image') === false) {
        die('Only images are allowed.');
    }

    // Check file size
    $image = getimagesize($filePath);
    $limitBytes = 1024 * 1024 * 2;
    if (filesize($filePath) > $limitBytes) {
        die('Image size must be less then 2 MB.');
    }

    // Set new pic name, move the file and return the file name.
    $extension = image_type_to_extension($image[2]);
    $name = md5_file($filePath) . $extension;
    if (!move_uploaded_file($filePath, __DIR__ . '/userpics/' . $name)) {
        die('Error during image upload.');
    }
    return $name;
}




