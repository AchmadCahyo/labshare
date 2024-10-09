<?php
$server = "localhost";
$user = "root";
$pass = "";
$database = "labshare";

$conn = mysqli_connect($server, $user, $pass, $database);
if (!$conn) {
    die("Conection To Database Failed!" . mysqli_connect_error());
}